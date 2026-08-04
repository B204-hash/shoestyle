<?php
session_start();
require_once __DIR__ . '/admin/connection.php'; 


$uploadsBase = 'admin/uploads/';

if (isset($_GET['api']) && $_GET['api'] === 'products') {
  header('Content-Type: application/json; charset=utf-8');
  try {
    $stmt = $pdo->prepare("SELECT product_id, product_name, price, image, stock 
                           FROM products 
                           WHERE category = 'women'"); 
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
  } catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch products.']);
  }
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>women's Shoes</title>

  <!-- Fonts & CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/styles.css" />

  <style>
    .card img { max-height: 240px; object-fit: cover; }
    .cart-column {
      background: #f8f9fa; border-radius: 10px; padding: 18px;
      position: sticky; top: 90px;
    }
    .qty-input { width: 70px; }
  </style>

  <script>
    // Make uploads base available to JS so image paths are always correct.
    window.UPLOADS_BASE = <?php echo json_encode(rtrim($uploadsBase, '/').'/'); ?>;
  </script>
</head>
<body>

<?php $page_title= "Women's Shoes"; include __DIR__ . '/includes/navbar.php'; ?>

<div class="container my-5">
  <h2 class="mb-4 text-center">Women's Shoes</h2>

  <div class="row align-items-start g-4">
    <!-- Products -->
    <div class="col-lg-8">
      <div class="row" id="product-list"></div>
    </div>

    <!-- Cart -->
    <div class="col-lg-4">
      <div class="cart-column">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <h4 class="mb-0">Your Cart</h4>
          <span class="badge text-bg-primary" id="cart-count">0</span>
        </div>
        <div id="cart-items"></div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script>
const cart = {
  products: {},   // product map keyed by product_id (string)
  items: {},      // { product_id: qty } stored in localStorage

  // --- Storage ---
  loadCart() {
    try {
      const saved = localStorage.getItem('cart');
      this.items = saved ? JSON.parse(saved) : {};
    } catch (e) {
      this.items = {};
    }
  },
  saveCart() {
    localStorage.setItem('cart', JSON.stringify(this.items));
  },

  // --- Data ---
  async fetchProducts() {
    try {
      const res = await fetch('women_shoes.php?api=products', { cache: 'no-store' });
      const data = await res.json();
      if (!Array.isArray(data)) throw new Error('Invalid products response');

      // Build product map with string keys to match object key behavior
      this.products = {};
      data.forEach(p => { this.products[String(p.product_id)] = p; });

      this.renderProducts();
      this.renderCart();
    } catch (err) {
      document.getElementById('product-list').innerHTML =
        '<div class="col-12"><div class="alert alert-danger">Could not load products.</div></div>';
    }
  },

  // --- UI: Products ---
  renderProducts() {
    const container = document.getElementById('product-list');
    container.innerHTML = '';

    const productsArr = Object.values(this.products);
    if (productsArr.length === 0) {
      container.innerHTML = '<div class="col-12 text-center text-muted">No women\'s shoes found.</div>';
      return;
    }

    productsArr.forEach(p => {
      const col = document.createElement('div');
      col.className = 'col-md-6';
      // Use UPLOADS_BASE from PHP; encodeURIComponent for safe filenames
      const imgSrc = window.UPLOADS_BASE + encodeURIComponent((p.image || '').trim());

      col.innerHTML = `
        <div class="card h-100 shadow-sm">
          <img src="${imgSrc}" class="card-img-top" alt="${escapeHtml(p.product_name || 'Shoe')}"
               onerror="this.onerror=null;this.src='${window.UPLOADS_BASE}placeholder.jpg';">
          <div class="card-body text-center">
            <h5 class="card-title mb-1">${escapeHtml(p.product_name)}</h5>
            <div class="text-muted small mb-2">Stock: ${Number(p.stock) || 0}</div>
            <div class="fw-semibold mb-3">$${Number(p.price).toFixed(2)}</div>
            <button class="btn btn-success btn-sm add-to-cart" data-id="${p.product_id}">Add to Cart</button>
          </div>
        </div>
      `;
      container.appendChild(col);
    });

    container.querySelectorAll('.add-to-cart').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = String(e.currentTarget.dataset.id);
        this.addToCart(id);
      });
    });
  },

  // --- Cart Ops ---
  addToCart(id) {
    this.items[id] = (this.items[id] || 0) + 1;
    this.saveCart();
    this.renderCart();
  },
  updateQty(id, qty) {
    qty = Number(qty);
    if (!qty || qty < 1) {
      delete this.items[id];
    } else {
      this.items[id] = qty;
    }
    this.saveCart();
    this.renderCart();
  },
  removeFromCart(id) {
    delete this.items[id];
    this.saveCart();
    this.renderCart();
  },
  emptyCart() {
    if (confirm('Empty your cart?')) {
      this.items = {};
      this.saveCart();
      this.renderCart();
    }
  },

  // --- UI: Cart ---
  renderCart() {
    const wrap = document.getElementById('cart-items');
    const countBadge = document.getElementById('cart-count');
    wrap.innerHTML = '';

    const keys = Object.keys(this.items);
    countBadge.textContent = keys.reduce((a,k)=>a+Number(this.items[k]||0),0);

    if (keys.length === 0) {
      wrap.innerHTML = '<p class="text-muted mb-0">Your cart is empty.</p>';
      return;
    }

    let total = 0;
    keys.forEach(id => {
      const product = this.products[id];
      if (!product) return; // in case something went out of sync

      const qty = Number(this.items[id]) || 0;
      const price = Number(product.price) || 0;
      const line = qty * price;
      total += line;

      const row = document.createElement('div');
      row.className = 'd-flex align-items-center justify-content-between mb-2 border-bottom pb-2';
      row.innerHTML = `
        <div class="me-2 flex-grow-1">
          <div class="fw-semibold">${escapeHtml(product.product_name)}</div>
          <div class="small text-muted">$${price.toFixed(2)} each</div>
        </div>
        <input type="number" class="form-control form-control-sm qty-input me-2" min="1" value="${qty}" data-id="${id}">
        <div class="me-2">$${line.toFixed(2)}</div>
        <button class="btn btn-sm btn-outline-danger remove-btn" title="Remove" data-id="${id}">
          <i class="fa fa-times"></i>
        </button>
      `;
      wrap.appendChild(row);
    });

    const controls = document.createElement('div');
    controls.className = 'mt-3 d-flex justify-content-between align-items-center';
    controls.innerHTML = `
      <button class="btn btn-warning btn-sm" id="emptyCartBtn">Empty Cart</button>
      <a href="checkout.php" class="btn btn-primary btn-sm">Proceed to Checkout - $${total.toFixed(2)}</a>
    `;
    wrap.appendChild(controls);

    // Bind qty + remove + empty
    wrap.querySelectorAll('.qty-input').forEach(inp => {
      inp.addEventListener('change', (e) => {
        const id = String(e.currentTarget.dataset.id);
        const qty = e.currentTarget.value;
        this.updateQty(id, qty);
      });
    });
    wrap.querySelectorAll('.remove-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const id = String(e.currentTarget.dataset.id);
        this.removeFromCart(id);
      });
    });
    document.getElementById('emptyCartBtn').addEventListener('click', () => this.emptyCart());
  },

  // --- Init ---
  init() {
    this.loadCart();
    this.fetchProducts();
  }
};

// Small helper to avoid XSS in names coming from DB
function escapeHtml(str){
  return String(str || '').replace(/[&<>"']/g, s => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
  }[s]));
}

document.addEventListener('DOMContentLoaded', () => cart.init());
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>