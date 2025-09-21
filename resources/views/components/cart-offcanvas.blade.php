<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCart" aria-labelledby="offcanvasCartLabel">
    <div class="offcanvas-header border-bottom">
        <h5 id="offcanvasCartLabel" class="fw-bold">My Cart (<span class="cart-count">0</span>)</h5>
        <button type="button" class="btn-close text-danger" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column">
        <div class="cart-item-container"></div>
    </div>
    <div class="mt-auto p-3 border-top">
        <a href="{{ route('cart') }}" class="btn btn-primary w-100 mb-2">Go to Cart</a>
        <a href="{{ route('cart') }}" class="btn btn-primary w-100 mb-2">Checkout <span class="cart-total">{{ $showTotal ?? 0 }}</span></a>
        <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100">Continue Shopping</a>
    </div>
</div>