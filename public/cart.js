
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
            method: "POST",
            data: {
                _token: window.csrfToken,
            },
            success: (res) => {
                console.log('🧾 Cart header response:', res);
                this.cart = res;
                this.cartContent();
            },
            error: (xhr) => {
                console.error('❌ Cart header error:', xhr.responseText);
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

            // ✅ SweetAlert success popup
            Swal.fire({
                icon: 'success',
                title: 'Added to Cart!',
                text: res.message || 'Product added to cart successfully.',
                showConfirmButton: false,
                timer: 1500
            });
        } else {
            // ⚠️ Handle backend failure (like out of stock)
            Swal.fire({
                icon: 'warning',
                title: 'Notice',
                text: res.message || 'Unable to add product to cart.',
            });
            $btn.text("Add to Cart");
        }
    }

    handleCartError($btn, error = null) {
        console.error("Cart error:", error);
        $btn.text("Add to Cart");

        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: 'Something went wrong while adding to cart.',
        });
    }

    // ✅ When updating quantity
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

                Swal.fire({
                    icon: 'success',
                    title: 'Cart Updated!',
                    text: res.message || 'Cart item updated successfully.',
                    showConfirmButton: false,
                    timer: 1200
                });
            },
            error: () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Unable to update cart item.',
                });
            }
        });
    }

    // ✅ When deleting an item
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

                Swal.fire({
                    icon: 'success',
                    title: 'Removed!',
                    text: res.message || 'Item removed from cart.',
                    showConfirmButton: false,
                    timer: 1200
                });
            },
            error: () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Unable to remove item from cart.',
                });
            }
        });
    }
    
    // use for dropdown effect (optional)
    minicart_dropdown() {
        $(".site-header__cart").off("click").on("click", function (e) {
            e.preventDefault();
            $(this).siblings(".block-cart").slideToggle();
        });

        $("body").off("click").on("click", function (event) {
            const $target = $(event.target);
            if (!$target.closest(".site-cart").length) {
                $(".block-cart").slideUp();
            }
        });
    }

    cartContent() {
        const cart = this.cart?.data;
        if (!cart) {
            console.error("Cart data missing", this.cart);
            return;
        }

        // ✅ Update summary
        this.addCartSummaryToContainer(cart);

        // ✅ Update cart item container
        const cartItemContainer = document.querySelectorAll(".site-cart");
        cartItemContainer.forEach(element => {
            this.addCartItemToContainer(cart, element);
        });
    }

    addCartItemToContainer(cart, container) {
        const cart_items = cart.items ? Object.values(cart.items) : [];

        if (cart_items.length === 0) {
            container.innerHTML = `
            <a href="#" class="site-header__cart" title="Cart">
                <i class="icon anm anm-bag-l"></i>
                <span id="CartCount" class="site-header__cart-count" data-cart-render="item_count">${cart.count}</span>
            </a>
            <div id="header-cart" class="block block-cart">
                <div class="total">
                    <div class="total-in">
                        <span class="label"><center>Your Cart is Empty!</center></span>
                    </div>
                </div>
            </div>
        `
            this.minicart_dropdown();
            return;
        }

        let rows = "";
        cart_items.forEach(item => {
            const imagePath = item?.options?.image; // ✅ get image path from backend

            const image = imagePath
                ? `${window.storageUrl}${imagePath}` // ✅ use global storage URL
                : "/themeAssets/images/images.jpg";  // ✅ fallback image

            const name = item?.name ?? "Unnamed";
            const sku = item?.options?.sku ?? "-";
            const price = item?.price ?? 0;
            const qty = item?.qty ?? 0;
            rows += `
            <li class="item">
                <a class="product-image" href="#">
                    <img class="cart__image" src="${image}" alt="${name}">
                </a>
                <div class="product-details">
                    <a href="#" class="remove cart__remove delete-cart-item" data-row-id="${item.rowId}">
                        <i class="anm anm-times-l" aria-hidden="true"></i>
                    </a>
                    <a class="pName" href="#">${name}</a>
                    <div class="variant-cart">${sku}</div>
                    <!-- <div class="wrapQtyBtn">
                        <div class="qtyField">
                            <span class="label">Qty:</span>
                            <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon icon-minus"></i></a>
                            <input class="cart__qty-input qty" type="text" value="${qty}" data-row-id="${item.rowId}">
                            <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon icon-plus"></i></a>
                        </div>
                    </div> -->
                    <div class="priceRow">
                        <div class="product-price">
                            <span class="money">${qty} × ${cart.symbol}${price}</span>
                        </div>
                    </div>
                </div>
            </li>
        `;
        });

        const subtotal = cart.total?.subtotal ?? 0;
        const currency = cart.symbol ?? "Rs";

        container.innerHTML = `
        <a href="#" class="site-header__cart" title="Cart">
            <i class="icon anm anm-bag-l"></i>
            <span id="CartCount" class="site-header__cart-count" data-cart-render="item_count">${cart.count}</span>
        </a>
        <!--Minicart Popup-->
        <div id="header-cart" class="block block-cart">
            <ul class="mini-products-list">
                ${rows}
            </ul>
            <div class="total">
                <div class="total-in">
                    <span class="label">Cart Subtotal:</span>
                    <span class="product-price">
                        <span class="money">${currency}${subtotal}</span>
                    </span>
                </div>
                <div class="buttonSet text-center">
                    <a href="${window.cart}" class="btn btn-secondary btn--small">View Cart</a>
                    <a href="${window.checkout}" class="btn btn-secondary btn--small">Checkout</a>
                </div>
            </div>
        </div>
    `
        this.minicart_dropdown();

    }

    addCartSummaryToContainer(cart) {
        const cartCouter = document.querySelectorAll('.cart-count');
        const cartTotal = document.querySelectorAll(".cart-total");
        const cartGrandTotal = document.querySelectorAll(".cart-grand-total");
        const cartDiscount = document.querySelectorAll(".cart-discount");
        const cartTax = document.querySelectorAll(".cart-tax");

        if (cartTax.length > 0) {
            cartTax.forEach(el => el.textContent = cart.total.tax);
        }

        if (cartDiscount.length > 0) {
            cartDiscount.forEach(el => el.textContent = cart.total.discount);
        }

        if (cartTotal.length > 0) {
            cartTotal.forEach(el => el.textContent = cart.symbol + cart.total.subtotal);
        }

        if (cartGrandTotal.length > 0) {
            cartGrandTotal.forEach(el => el.textContent = cart.symbol + cart.total.total);
        }

        if (cartCouter.length > 0) {
            cartCouter.forEach(el => el.textContent = cart.count);
        }
    }
}

// Initialize cart manager when DOM is ready
$(document).ready(function () {
    window.cartManager = new CartManager();
});