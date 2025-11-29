
const express = require('express');
const router = express.Router();
const db = require('./config/db'); // mysql2/promise pool

let cart = [];

// GET /buying/products - list products from MySQL
router.get('/products', async (req, res) => {
  try {
    const [rows] = await db.query('SELECT id, name, price, stock FROM products');
    res.json(rows);
  } catch (err) {
    console.error('DB error /products', err);
    res.status(500).json({ message: 'Database error' });
  }
});

// POST /buying/cart - add item to cart (DB-backed)
router.post('/cart', async (req, res) => {
  try {
    const { productId, quantity } = req.body;
    if (!Number.isInteger(productId) || !Number.isInteger(quantity) || quantity <= 0) {
      return res.status(400).json({ message: 'Invalid productId or quantity' });
    }

    const [rows] = await db.execute('SELECT id, stock FROM products WHERE id = ?', [productId]);
    if (rows.length === 0 || rows[0].stock < quantity) {
      return res.status(400).json({ message: 'Product not available' });
    }

    // If product already in cart, increase quantity; otherwise insert
    const [existing] = await db.execute('SELECT id, quantity FROM cart_items WHERE product_id = ? LIMIT 1', [productId]);
    if (existing.length > 0) {
      await db.execute('UPDATE cart_items SET quantity = quantity + ? WHERE id = ?', [quantity, existing[0].id]);
    } else {
      await db.execute('INSERT INTO cart_items (product_id, quantity) VALUES (?, ?)', [productId, quantity]);
    }

    const [cartRows] = await db.query(`
      SELECT ci.id, ci.product_id AS productId, ci.quantity, p.name, p.price
      FROM cart_items ci
      JOIN products p ON p.id = ci.product_id
    `);

    res.json({ message: 'Added to cart', cart: cartRows });
  } catch (err) {
    console.error('DB error /cart', err);
    res.status(500).json({ message: 'Database error' });
  }
});

// POST /buying/checkout - create order from cart_items and deduct stock
router.post('/checkout', async (req, res) => {
  const connection = await db.getConnection();
  try {
    await connection.beginTransaction();

    // lock cart items
    const [cartItems] = await connection.query(`
      SELECT ci.id AS cart_id, ci.product_id AS productId, ci.quantity, p.price, p.stock
      FROM cart_items ci
      JOIN products p ON p.id = ci.product_id
      FOR UPDATE
    `);

    if (cartItems.length === 0) {
      await connection.rollback();
      return res.status(400).json({ message: 'Cart is empty' });
    }

    // validate stock
    for (const item of cartItems) {
      if (item.stock < item.quantity) {
        await connection.rollback();
        return res.status(400).json({ message: `Not enough stock for product ${item.productId}` });
      }
    }

    // create order
    const [orderResult] = await connection.execute('INSERT INTO orders (total_amount) VALUES (?)', [0]);
    const orderId = orderResult.insertId;

    let total = 0;
    for (const item of cartItems) {
      const lineTotal = Number(item.price) * item.quantity;
      total += lineTotal;
      await connection.execute('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)', [orderId, item.productId, item.quantity, item.price]);
      await connection.execute('UPDATE products SET stock = stock - ? WHERE id = ?', [item.quantity, item.productId]);
    }

    // update order total
    await connection.execute('UPDATE orders SET total_amount = ? WHERE id = ?', [total, orderId]);

    // clear cart
    await connection.execute('DELETE FROM cart_items');

    await connection.commit();
    res.json({ message: 'Order placed successfully', orderId, total });
  } catch (err) {
    await connection.rollback();
    console.error('DB error /checkout', err);
    res.status(500).json({ message: 'Database error' });
  } finally {
    connection.release();
  }
});

module.exports = router;

