
// MySQL connection pool using mysql2 (promise API)
let pool;
try {
  // load .env if present (optional)
  require('dotenv').config();
} catch (e) {}

const mysql = require('mysql2/promise');

pool = mysql.createPool({
  host: process.env.DB_HOST || 'localhost',
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASS || 'leonel123',
  database: process.env.DB_NAME || 'shop',
  waitForConnections: true,
  connectionLimit: Number(process.env.DB_CONN_LIMIT) || 10,
  queueLimit: 0
});

module.exports = pool;
