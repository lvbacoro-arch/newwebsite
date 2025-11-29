const express = require('express');
const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.json());

// Default route
app.get('/', (req, res) => {
  res.send('Hello World');
});

// Import buying system routes
const buyingSystem = require('./buyingSystem');
console.log('DEBUG: buyingSystem export type:', typeof buyingSystem);
console.log('DEBUG: buyingSystem export:', buyingSystem);
app.use('/buying', buyingSystem); // mount at /buying instead of root

// Start server
app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});


