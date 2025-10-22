
class CartManager {
    constructor() {
        this.variants = null;
        this.hasVariants = false;
        this.attributeMap = {};
        this.selected = {};
        this.currentVariant = null;

        this.swatchGroups = document.getElementById("swatchGroups");
        this.init();
        this.cart = null;
    }

    init() {
        this.initializeProductDetails();
        this.bindEvents();
        this.cartHeader();
    }

    cartHeader() {
        $.ajax({
            url: window.cartHeaderUrl,
            method: "GET",
            success: (res) => {
                this.cart = res;
                this.cartContent();
            }
        });
    }

    initializeProductDetails() {
        if (this.swatchGroups) {
            this.variants = JSON.parse(this.swatchGroups.dataset.variants);
            this.hasVariants = this.swatchGroups.dataset.hasVariants === 'true';

            if (this.hasVariants && Array.isArray(this.variants) && this.variants.length > 0) {
                this.selected = { ...this.variants[0].attributes };
                this.buildAttributes();
                this.renderSwatches();
            } else if (!this.hasVariants && this.variants) {
                // Single product without variants
                this.selected = {};
                this.currentVariant = this.variants;
                this.updateProductDetails(this.variants);
                this.updateQuantityControls(this.variants.stock);
                this.setAddToCartData(this.variants);
            }
        }
    }

    buildAttributes() {
        this.attributeMap = {};
        this.variants.forEach(v => {
            Object.entries(v.attributes).forEach(([key, value]) => {
                if (!this.attributeMap[key]) this.attributeMap[key] = new Set();
                this.attributeMap[key].add(value);
            });
        });
    }

    renderSwatches() {
        const container = this.swatchGroups;
        if (!container) return;

        container.innerHTML = "";

        Object.entries(this.attributeMap).forEach(([attr, values]) => {
            const groupDiv = document.createElement("div");
            groupDiv.className = "mt-1";
            groupDiv.innerHTML = `<h6 class="attribute-name">${attr.charAt(0).toUpperCase() + attr.slice(1)}</h6>`;

            const swatchRow = document.createElement("div");
            swatchRow.className = "d-flex flex-wrap";

            values.forEach(val => {
                const div = document.createElement("div");
                if (this.selected && this.selected[attr] === val) {
                    div.className = "swatch active";
                } else {
                    div.className = "swatch";
                }
                div.textContent = val;
                div.onclick = (e) => this.selectSwatch(attr, val, e);
                swatchRow.appendChild(div);
            });

            groupDiv.appendChild(swatchRow);
            container.appendChild(groupDiv);
        });

        this.checkVariant();
    }

    selectSwatch(attr, value, event) {
        event.currentTarget.parentNode.querySelectorAll(".swatch").forEach(el => el.classList.remove("active"));
        event.currentTarget.classList.add("active");
        this.selected[attr] = value;
        this.checkVariant();
    }

    checkVariant() {
        let match = null;

        if (this.hasVariants) {
            match = this.variants.find(v =>
                Object.entries(this.selected).every(([key, val]) => v.attributes[key] === val)
            );
        } else {
            match = this.variants;
        }

        const allAttrsSelected = Object.keys(this.attributeMap).every(attr => this.selected[attr]);
        const addToCartBtn = document.getElementById("addToCartBtn");

        if (this.hasVariants && !allAttrsSelected) {
            this.currentVariant = null;
            if (addToCartBtn) addToCartBtn.removeAttribute('data-product');
            this.variantDetailsEmpty();
            this.updateQuantityControls(0);
        } else if (match) {
            this.currentVariant = match;
            this.updateProductDetails(match);
            this.updateQuantityControls(match.stock);
            this.setAddToCartData(match);
        } else {
            this.currentVariant = null;
            if (addToCartBtn) addToCartBtn.removeAttribute('data-product');
            this.variantDetailsEmpty();
            this.updateQuantityControls(0);
        }
    }

    updateProductDetails(match) {
        const priceContainer = document.getElementById("variant__details__price");
        const statusContainer = document.getElementById("variantStatus");
        const skuElement = document.getElementById("sku_number");

        if (priceContainer) {
            let price = '';
            if (match.salePrice && match.salePrice > 0) {
                price = `
                    <span class="sale-price">$${match.salePrice.toFixed(2)}</span>
                    <del class="regular-price">$${match.regularPrice.toFixed(2)}</del>
                `;
            } else {
                price = `<span class="regular-price">$${match.regularPrice.toFixed(2)}</span>`;
            }
            priceContainer.innerHTML = `<h3 class="price">${price}</h3>`;
        }

        if (statusContainer) {
            statusContainer.textContent = match.stock > 0 ? "" : "Out of Stock";
        }

        if (skuElement) {
            skuElement.innerHTML = match.sku;
            skuElement.closest("span").style.display = "inline";
        }
    }

    variantDetailsEmpty() {
        const priceContainer = document.getElementById("variant__details__price");
        const statusContainer = document.getElementById("variantStatus");
        const skuElement = document.getElementById("sku_number");
        const addToCartBtn = document.getElementById("addToCartBtn");

        if (priceContainer) priceContainer.innerHTML = "";
        if (statusContainer) statusContainer.textContent = "This combination is not available.";
        if (skuElement) {
            skuElement.innerHTML = "";
            skuElement.closest("span").style.display = "none";
        }
        if (addToCartBtn) addToCartBtn.disabled = true;
    }

    setAddToCartData(match) {
        const addToCartBtn = document.getElementById("addToCartBtn");
        if (addToCartBtn) {
            addToCartBtn.setAttribute('data-product', JSON.stringify(match));
            addToCartBtn.disabled = match.stock <= 0;
        }
    }

    updateQuantityControls(stock) {
        const quantityInput = document.getElementById("quantityInput");
        const minusBtn = document.getElementById("quantityMinus");
        const plusBtn = document.getElementById("quantityPlus");

        if (stock > 0) {
            if (quantityInput) {
                quantityInput.disabled = false;
                quantityInput.max = stock;
                if (parseInt(quantityInput.value) > stock) {
                    quantityInput.value = 1;
                }
            }
            if (minusBtn) minusBtn.disabled = false;
            if (plusBtn) plusBtn.disabled = false;
        } else {
            if (quantityInput) {
                quantityInput.disabled = true;
                quantityInput.value = 1;
            }
            if (minusBtn) minusBtn.disabled = true;
            if (plusBtn) plusBtn.disabled = true;
        }
    }

    bindEvents() {
        const minusBtn = document.getElementById("quantityMinus");
        const plusBtn = document.getElementById("quantityPlus");
        const quantityInput = document.getElementById("quantityInput");

        if (minusBtn) {
            minusBtn.addEventListener("click", (e) => {
                $(e.target).closest('.product__item__select__option').find('.add-to-cart').text("Add to Cart");
                const input = document.getElementById("quantityInput");
                if (input) {
                    const currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                }
            });
        }

        if (plusBtn) {
            plusBtn.addEventListener("click", (e) => {
                $(e.target).closest('.product__item__select__option').find('.add-to-cart').text("Add to Cart");
                const input = document.getElementById("quantityInput");
                if (input) {
                    const currentValue = parseInt(input.value);
                    const maxStock = this.currentVariant ? this.currentVariant.stock : 0;

                    if (currentValue < maxStock) {
                        input.value = currentValue + 1;
                    }
                }
            });
        }

        if (quantityInput) {
            quantityInput.addEventListener("input", (e) => {
                $(e.target).closest('.product__item__select__option').find('.add-to-cart').text("Add to Cart");
                const value = parseInt(e.target.value);
                const maxStock = this.currentVariant ? this.currentVariant.stock : 0;
                if (value < 1) {
                    e.target.value = 1;
                } else if (value > maxStock) {
                    e.target.value = maxStock;
                }
            });
        }

        $(document).on('click', '.quantity-minus', (e) => {
            e.preventDefault();

            const productId = $(e.target).data('product-id');
            const input = $(`.quantity-input[data-product-id="${productId}"]`);
            if (input.length) {
                const currentValue = parseInt(input.val());
                if (currentValue > 1) {
                    input.val(currentValue - 1);
                }
            }
        });

        $(document).on('click', '.quantity-plus', (e) => {
            e.preventDefault();

            const productId = $(e.target).data('product-id');
            const input = $(`.quantity-input[data-product-id="${productId}"]`);
            if (input.length) {
                const currentValue = parseInt(input.val());
                const maxValue = parseInt(input.attr('max')) || 99;
                if (currentValue < maxValue) {
                    input.val(currentValue + 1);
                }
            }
        });

        $(document).on('input', '.quantity-input[data-product-id]', (e) => {
            e.preventDefault();
            $(e.target).closest('.product__item__select__option').find('.add-to-cart').text("Add to Cart");
            const value = parseInt(e.target.value);
            const maxValue = parseInt(e.target.getAttribute('max')) || 99;
            if (value < 1) {
                e.target.value = 1;
            } else if (value > maxValue) {
                e.target.value = maxValue;
            }
        });

        // Add to cart functionality
        $(document).on('click', '.add-to-cart', (e) => {
            e.preventDefault();
            this.handleAddToCart(e);
        });

        this.enableProductCardQuantityControls();


        $(document).on('click', '.delete-cart-item', (e) => {
            const $btn = $(e.currentTarget);
            const rowId = $btn.data('row-id');

            this.handleCartItemDelete($btn, rowId);
        });

        $(document).on('click change input', '.update-cart-item', (e) => {
            const $btn = $(e.currentTarget);
            const rowId = $btn.data('row-id');
            let quantity = $btn.data('quantity');
            if (e.type === 'change') {
                quantity = $btn.val();
            }
            if (quantity === undefined || quantity < 1 || quantity > $btn.data('max')) {
                return;
            }

            this.handleCartItemUpdate(rowId, quantity);
        });
    }

    enableProductCardQuantityControls() {
        $('.quantity-selector[data-product-id]').each(function () {
            const $selector = $(this);
            const productId = $selector.data('product-id');

            const hasVariants = $selector.closest('.product__item').find('a[href*="product"]').text().includes('Select Options');

            if (!hasVariants) {
                $selector.find('.quantity-minus, .quantity-plus').prop('disabled', false);
                $selector.find('.quantity-input').prop('disabled', false);
            }
        });
    }

    handleAddToCart(e) {
        const $btn = $(e.currentTarget);
        const productData = $btn.attr('data-product');
        $btn.text("Adding to Cart...");

        if (!productData) {
            console.error('No product data found');
            return;
        }

        try {
            const match = JSON.parse(productData);
            let quantity = 1;

            // Check if this is from product detail page
            const quantityInput = document.getElementById("quantityInput");
            if (quantityInput) {
                quantity = parseInt(quantityInput.value);
            } else {
                // Check if this is from product card
                const productId = $btn.data('product-id');
                if (productId) {
                    const cardQuantityInput = $(`.quantity-input[data-product-id="${productId}"]`);
                    if (cardQuantityInput.length) {
                        quantity = parseInt(cardQuantityInput.val());
                    }
                }

                // Fallback to data-qty attribute
                if (!quantity || quantity < 1) {
                    quantity = $btn.data('qty') || 1;
                }
            }

            // Use existing AJAX cart functionality
            $.ajax({
                url: window.addToCartUrl,
                method: "POST",
                data: {
                    _token: window.csrfToken,
                    product_id: match.id,
                    variant_id: match.variant_id || null,
                    qty: quantity
                },
                success: (res) => {
                    this.handleCartResponse(res, $btn);
                },
                error: () => {
                    this.handleCartError($btn);
                }
            });
        } catch (error) {
            this.handleCartError($btn);
        }
    }

    handleCartResponse(res, $btn) {
        if (res.success) {
            this.cart = res;
            $btn.text("Added to Cart");
            this.cartContent();
        }
    }

    handleCartError($btn) {
        $btn.text("Add to Cart");
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Something went wrong.'
        });
    }


    /**
     * Cart content...
     */
    handleCartItemUpdate(rowId, quantity) {
        $.ajax({
            url: window.cartUpdateUrl,
            method: "POST",
            data: {
                _token: window.csrfToken,
                rowId: rowId,
                qty: quantity
            },
            success: (res) => {
                this.cart = res;
                this.cartContent();
            },
            error: () => {
                this.handleCartError($btn);
            }
        });
    }

    handleCartItemDelete(btn, rowId) {
        $.ajax({
            url: window.cartRemoveUrl,
            method: "POST",
            data: {
                _token: window.csrfToken,
                rowId: rowId
            },
            success: (res) => {
                this.cart = res;
                this.cartContent();
            },
            error: () => {
                this.handleCartError(btn);
            }
        });
    }

    cartContent() {
        const cart = this.cart.data;

        this.addCartSummaryToContainer(cart);

        const cartItemContainer = document.querySelectorAll(".cart-item-container");
        cartItemContainer.forEach(element => {
            this.addCartItemToContainer(cart, element);
        });
    }

    addCartItemToContainer(cart, container, view = 'offcanvas') {
        let cart_items = cart.items;
        if (cart_items.length === 0) {
            container.innerHTML = `<p class="text-muted text-center">Your cart is empty.</p>`;
            return;
        }
        let html = "";

        Object.values(cart_items).forEach(item => {
      
            let attributes = "";
            let qty = "";
            let image = "";
            if (item.options.attributes !== null) {
                attributes = Object.entries(item.options.attributes).map(([key, value]) => `
                    <span><strong>${key.toUpperCase()}:</strong> ${value.toUpperCase()}</span>
                `).join(" ");
            }
            if (item.qty !== 0) {
                qty = `<div class="quantity-selector">
                    <button class="cart-quantity-btn update-cart-item" type="button" data-row-id="${item.rowId}" max="${item.options.stock}" data-quantity="${Number(item.qty) - 1}">-</button>
                    <input class="cart-quantity-input update-cart-item" type="number" data-row-id="${item.rowId}" value="${item.qty}" max="${item.options.stock}">
                    <button class="cart-quantity-btn update-cart-item" type="button" data-row-id="${item.rowId}" max="${item.options.stock}" data-quantity="${Number(item.qty) + 1}">+</button>
                </div>`;
            }
            if(item.options.image) {
                image = `<div class="cart-item-image"><img src="${item.options.image[0]}" alt="${item.name}"></div>`;
            }
            html += `
            <div class="cart-item" data-row-id="${item.rowId}">
                ${image}

                <div class="cart-body">
                    <div class="cart-item-name">
                        <span class="cart-item-sku">${item.options.sku}</span>
                        <h5>${item.name}</h5>
                    </div>
                    <div class="cart-attributes">
                        ${attributes}
                    </div>
                    <div class="cart-price-qty-item">
                        <div class="cart-stock">
                            ${qty}
                        </div>
                        <div class="cart-total">
                            <b>${cart.symbol + item.subtotal}</b>
                        </div>
                    </div>
                    
                    <div class="cart-action">
                        <button type="button" class="btn btn-danger btn-sm delete-cart-item" data-row-id="${item.rowId}">&times;</button>
                    </div>
                </div>
            </div>
            `;
        });
        container.innerHTML = html;
    }
    addCartSummaryToContainer(cart) {
        const cartCouter = document.querySelectorAll('.cart-count');
        const cartTotal = document.querySelectorAll(".cart-total");
        const cartGrandTotal = document.querySelectorAll(".cart-grand-total");
        const cartDiscount = document.querySelectorAll(".cart-discount");
        const cartTax = document.querySelectorAll(".cart-tax");

        if (cartTax.length > 0) {
            cartTax.forEach(element => {
                element.textContent = cart.total.tax;
            });
        }
        
        if (cartDiscount.length > 0) {
            cartDiscount.forEach(element => {
                element.textContent = cart.total.discount;
            });
        }

        if (cartTotal.length > 0) {
            cartTotal.forEach(element => {
                element.textContent = cart.total.subtotal;
            });
        }
        if (cartGrandTotal.length > 0) {
            cartGrandTotal.forEach(element => {
                element.textContent = cart.total.total;
            });
        }
        if (cartCouter.length > 0) {
            cartCouter.forEach(element => {
                element.textContent = cart.count;
            });
        }
    }
}

// Initialize cart manager when DOM is ready
$(document).ready(function () {
    window.cartManager = new CartManager();
});