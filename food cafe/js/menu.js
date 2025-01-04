document.addEventListener("DOMContentLoaded", () => {
    const cuisineDropdown = document.getElementById("cuisine-dropdown");
    const menuItems = document.querySelectorAll(".me");
    const cartItemsList = document.getElementById("cart-items");
    const totalAmount = document.getElementById("total-amount");
    const subtotalAmount = document.getElementById("subtotal-amount");
    const discountAmount = document.getElementById("discount-amount");
    const taxAmount = document.getElementById("tax-amount");
    const discountCodeInput = document.getElementById("discount-code");
    const applyDiscountButton = document.getElementById("apply-discount");
    const cartCount = document.getElementById("cart-count");

    let cart = [];
    let discountValue = 0;
    const taxRate = 0.18;

    // Load cart from localStorage when the page loads
    const savedCart = JSON.parse(localStorage.getItem("cart"));
    if (savedCart) {
        cart = savedCart;
        updateCart();
    }

    // Filter menu items based on selected cuisine
    cuisineDropdown.addEventListener("change", function () {
        const selectedCuisine = this.value.toLowerCase();
        menuItems.forEach(item => {
            const itemCuisine = item.getAttribute("data-cuisine").toLowerCase();
            if (selectedCuisine === "all" || itemCuisine === selectedCuisine) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Add to cart functionality
    const preorderButtons = document.querySelectorAll(".yellow_btn");
    preorderButtons.forEach(button => {
        button.addEventListener("click", function () {
            const itemName = this.getAttribute("data-name");
            const itemPrice = parseFloat(this.getAttribute("data-price"));

            addToCart(itemName, itemPrice);
            toggleCart(); // Open the cart when an item is added
        });
    });

    // Function to add item to the cart
    function addToCart(itemName, itemPrice) {
        const existingItemIndex = cart.findIndex(item => item.name === itemName);

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantity++;
        } else {
            cart.push({ name: itemName, price: itemPrice, quantity: 1 });
        }

        updateCart();
    }

    // Function to update the cart UI
    function updateCart() {
        cartItemsList.innerHTML = "";
        let subtotal = 0;
        let totalItems = 0;

        cart.forEach((item, index) => {
            const listItem = document.createElement("li");
            listItem.innerHTML = `
                ${item.name} x${item.quantity} - Rs.${(item.price * item.quantity).toFixed(2)}
                <button onclick="updateQuantity(${index}, ${item.quantity - 1})">-</button>
                <button onclick="updateQuantity(${index}, ${item.quantity + 1})">+</button>
                <button onclick="removeFromCart(${index})">Remove</button>
            `;
            cartItemsList.appendChild(listItem);
        
            subtotal += item.price * item.quantity;
            totalItems += item.quantity;
        });

        // Calculate totals
        const discount = subtotal * discountValue;
        const tax = (subtotal - discount) * taxRate;
        const total = subtotal - discount + tax;

        // Update displayed amounts
        subtotalAmount.textContent = subtotal.toFixed(2);
        discountAmount.textContent = discount.toFixed(2);
        taxAmount.textContent = tax.toFixed(2);
        totalAmount.textContent = total.toFixed(2);
        cartCount.textContent = totalItems; // Update cart item count

        // Save cart to localStorage
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    // Function to update item quantity
    window.updateQuantity = (index, quantity) => {
        if (quantity < 1) {
            removeFromCart(index);
        } else {
            cart[index].quantity = quantity;
            updateCart();
        }
    };

    // Function to remove an item from the cart
    window.removeFromCart = (index) => {
        cart.splice(index, 1);
        updateCart();
    };

    // Apply discount code functionality
    applyDiscountButton.addEventListener("click", function () {
        const code = discountCodeInput.value;
        if (code === "DISCOUNT10") {
            discountValue = 0.1; // Apply 10% discount
        } else {
            discountValue = 0;
            alert("Invalid discount code");
        }
        updateCart();
    });

    // Toggle Cart Sidebar
    function toggleCart() {
        const cartSidebar = document.getElementById('cart-sidebar');
        const cartIcon = document.querySelector('.cart-icon');
        const cuisineDropdown = document.getElementById("cuisine-dropdown");
        
        // Toggle visibility of the cart sidebar
        cartSidebar.classList.toggle('active');

        // Ensure that the cart button and dropdown are still visible
        if (cartSidebar.classList.contains('active')) {
            cartIcon.style.visibility = 'visible';
            cuisineDropdown.style.visibility = 'visible';
        } else {
            cartIcon.style.visibility = 'visible';
            cuisineDropdown.style.visibility = 'visible';
        }
    }

    // Ensure toggleCart is accessible globally
    window.toggleCart = toggleCart;

    // Add event listener for checkout button
document.querySelector(".hell-btn").addEventListener("click", function () {
    // Send the cart data to the server
    fetch("save_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(cart) // Cart data from local storage or current session
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Cart saved successfully!");
            // Optionally, clear the cart here
            cart = [];
            updateCart();
        } else {
            alert("Failed to save cart. Try again!");
        }
    })
    .catch(error => console.error("Error:", error));
});

    
            
            
    
});
