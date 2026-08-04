let cart = JSON.parse(localStorage.getItem("cart")) || [];

function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

function addToCart(id) {
  // Check login status first
  fetch('check_auth.php')
    .then(res => res.json())
    .then(auth => {
      if (!auth.logged_in) {
        alert("Please log in to add items to your cart.");
        window.location.href = "login.php"; // Redirect to login
        return;
      }

      // Then fetch product info
      fetch(`get_product.php?id=${id}`)
        .then(response => response.json())
        .then(product => {
          if (!product || !product.name || !product.price || !product.stock) {
            alert("Product data incomplete.");
            return;
          }

          const existingItem = cart.find(item => item.id === id);
          if (existingItem) {
            if (existingItem.quantity < product.stock) {
              existingItem.quantity += 1;
            } else {
              alert("Maximum stock limit reached.");
            }
          } else {
            cart.push({
              id,
              name: product.name,
              price: parseFloat(product.price),
              quantity: 1,
              stock: parseInt(product.stock)
            });
          }

          saveCart();
          alert(`${product.name} added to cart!`);
        });
    })
    .catch(err => {
      console.error("Auth check failed", err);
      alert("Could not verify login status.");
    });
}

document.querySelectorAll('.add-to-cart').forEach(button => {
  button.addEventListener('click', () => {
    const id = parseInt(button.dataset.id);
    addToCart(id);
  });
});

// rest of renderCart, removeItem, etc. stays unchanged

function renderCart() {
  const cartItemsDiv = document.getElementById('cart-items');
  cartItemsDiv.innerHTML = "";
  let total = 0;

  if (cart.length === 0) {
    cartItemsDiv.innerHTML = "<p>Your cart is empty.</p>";
  } else {
    cart.forEach((item, index) => {
      const subtotal = item.price * item.quantity;
      const itemDiv = document.createElement("div");
      itemDiv.className = "mb-3";

      itemDiv.innerHTML = `
        <strong>${item.name}</strong> - $${item.price.toFixed(2)}
        x <input type="number" class="c-qty" min="1" max="${item.stock}" value="${item.quantity}" data-index="${index}" style="width:60px" />
        = $<span id="subtotal-${index}">${subtotal.toFixed(2)}</span>
        <button class="btn btn-sm btn-danger ms-2" onclick="removeItem(${index})">Remove</button>
      `;

      cartItemsDiv.appendChild(itemDiv);
      total += subtotal;
    });

    document.querySelectorAll('.c-qty').forEach(input => {
      input.addEventListener('change', (e) => {
        const index = e.target.dataset.index;
        let newQty = parseInt(e.target.value);
        const stock = cart[index].stock;

        if (newQty < 1) newQty = 1;
        if (newQty > stock) {
          newQty = stock;
          alert("Cannot exceed available stock.");
        }

        cart[index].quantity = newQty;
        saveCart();
        renderCart();
      });
    });
  }

  document.getElementById('total-price').textContent = total.toFixed(2);
}

function removeItem(index) {
  cart.splice(index, 1);
  saveCart();
  renderCart();
}

function checkout() {
  alert("Checkout complete!");
  cart = [];
  saveCart();
  renderCart();
}

// Auto-render cart
if (document.getElementById('cart-items')) {
  renderCart();
}
