
document.addEventListener('DOMContentLoaded', function() {
    const checkoutContainer = document.getElementById('checkout-container');
    const paymentResult = document.getElementById('payment-result');
    const paymentMessage = document.getElementById('payment-message');
    
    // 1. Get cart from localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || {};
    const cartItems = Object.keys(cart).map(id => ({ id, quantity: cart[id] }));
    
    if (cartItems.length === 0) {
        checkoutContainer.innerHTML = `
            <div class="alert alert-warning">
                Your cart is empty. <a href="index.php">Continue shopping</a>
            </div>
        `;
        return;
    }
    
    // 2. Send cart to server to get order summary
    fetch('checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `cartData=${encodeURIComponent(JSON.stringify(cart))}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            checkoutContainer.innerHTML = `
                <div class="alert alert-danger">
                    ${data.error} <a href="main.php">Continue shopping</a>
                </div>
            `;
            return;
        }
        
        // 3. Display checkout form with order summary
        renderCheckoutForm(data);
    })
    .catch(error => {
        checkoutContainer.innerHTML = `
            <div class="alert alert-danger">
                Failed to load checkout: ${error.message}
            </div>
        `;
    });
    
    function renderCheckoutForm(orderData) {
        checkoutContainer.innerHTML = `
            <h2 class="text-center">Checkout</h2>
            <div class="card p-4 shadow">
                <h4>Your Order</h4>
                <ul class="list-group mb-3">
                    ${orderData.orderSummary.map(item => `
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <h6>${escapeHtml(item.name)}</h6>
                                <small>Quantity: ${item.quantity}</small>
                            </div>
                            <span>$${(item.price * item.quantity).toFixed(2)}</span>
                        </li>
                    `).join('')}
                    ${orderData.finalPrice >= 500 ? `
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <div><strong>10% Discount Applied</strong></div>
                        </li>
                    ` : ''}
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>$${orderData.finalPrice.toFixed(2)}</strong>
                    </li>
                </ul>

                <form id="payment-form" method="POST" novalidate>
                    <input type="hidden" name="orderData" value="${escapeHtml(JSON.stringify(orderData))}">
                    <small class="text-muted">* Orders $500+ get a 10% discount.</small>

                    <div class="payment-container mt-4">
                        <h4 class="mb-3">Payment Method (Credit/Debit Card)</h4>

                        <div class="mb-3">
                            <label for="cardHolderName" class="form-label">Cardholder Name</label>
                            <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" placeholder="Full Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" 
                                   placeholder="0000 0000 0000 0000" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cardExpiry" class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" id="cardExpiry" name="cardExpiry" 
                                       placeholder="MM/YY" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cardCVC" class="form-label">CVC</label>
                                <input type="text" class="form-control" id="cardCVC" name="cardCVC" 
                                       placeholder="123" maxlength="3" required>
                            </div>
                        </div>
                    </div>

                    <div class="billing-container mt-4">
                        <h4 class="mb-3">Billing Information</h4>
                        <div class="mb-3">
                            <label for="billingCountry" class="form-label">Country</label>
                            <select class="form-select" id="billingCountry" name="billingCountry" required>
                                <option value="">Select Country</option>
                                <option>United States</option>
                                <option>Albania</option>
                                <option>Germany</option>
                                <option>France</option>
                                <option>Italy</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="billingCity" class="form-label">City</label>
                            <input type="text" class="form-control" id="billingCity" name="billingCity" required>
                        </div>

                        <div class="mb-3">
                            <label for="billingPostalCode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="billingPostalCode" name="billingPostalCode" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-25 mx-auto d-block mt-4">Confirm Payment</button>
                </form>
            </div>
        `;

        // automatic formatting for card inputs
        const cardNumber = document.getElementById('cardNumber');
        const cardExpiry = document.getElementById('cardExpiry');
        const cardCvc = document.getElementById('cardCVC');

       // format card number with spaces between every 4 numbers
        cardNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/g, '');
            if (value.length > 16) value = value.substr(0, 16);
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value;
        });

        // Format expiry date with slash
        cardExpiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substr(0, 2) + '/' + value.substr(2, 2);
            }
            if (value.length > 5) value = value.substr(0, 5);
            e.target.value = value;
        });

        //  CVC == 3 digits
        cardCvc.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substr(0, 3);
        });

        // Handle form submission
        document.getElementById('payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!this.checkValidity()) {
                alert('Please fill out all required fields correctly.');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            fetch('checkout.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams(new FormData(this))
            })
            .then(response => response.json())
            .then(data => {
                // Show payment result
                checkoutContainer.style.display = 'none';
                paymentResult.style.display = 'block';
                
                if (data.success) {
                    paymentMessage.className = 'alert alert-success';
                    paymentMessage.innerHTML = data.success;
                    localStorage.removeItem('cart');
                } else if (data.error) {
                    paymentMessage.className = 'alert alert-danger';
                    paymentMessage.innerHTML = data.error;
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Confirm Payment';
                }
            })
            .catch(error => {
                paymentMessage.className = 'alert alert-danger';
                paymentMessage.innerHTML = 'Payment processing failed. Please try again.';
                paymentResult.style.display = 'block';
                checkoutContainer.style.display = 'none';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Confirm Payment';
            });
        });
    }
    // function to prevent XSS 
    function escapeHtml(str) {
        return String(str || '').replace(/[&<>"']/g, s => ({
            '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
        }[s]));
    }
});
