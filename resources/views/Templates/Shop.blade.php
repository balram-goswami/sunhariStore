<style>
/* 🟢 WhatsApp Button Styling */
.btn-whatsapp {
    background-color: #25D366 !important;
    color: #fff !important;
    border: none;
    padding: 10px 18px;
    font-weight: 600;
    font-size: 15px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    text-align: center;
    white-space: nowrap;
    width: auto;
    box-shadow: 0 4px 10px rgba(37, 211, 102, 0.3);
}

.btn-whatsapp i {
    font-size: 18px;
}

.btn-whatsapp:hover {
    background-color: #1EBE5D !important;
    box-shadow: 0 6px 14px rgba(37, 211, 102, 0.45);
    transform: translateY(-2px);
}

.btn-whatsapp:active {
    transform: scale(0.97);
}

/* 🔁 Long & short text toggle */
.btn-whatsapp .long-text {
    display: inline;
}
.btn-whatsapp .short-text {
    display: none;
}

/* ✅ Responsive WhatsApp Button for Mobile */
@media (max-width: 768px) {
    .item {
        position: relative;
    }

    .variants.add {
        position: absolute;
        bottom: 10px;
        left: 10px;
        right: 10px;
        width: calc(100% - 20px);
        z-index: 5;
    }

    .btn-whatsapp {
        width: 100%;
        font-size: 14px;
        padding: 12px 0;
        border-radius: 8px;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 3px 8px rgba(37, 211, 102, 0.25);
    }

    .btn-whatsapp i {
        font-size: 20px;
    }

    .btn-whatsapp .long-text {
        display: none;
    }

    .btn-whatsapp .short-text {
        display: inline;
    }

    .product-image {
        padding-bottom: 60px;
    }
}

/* 🟣 Pagination Styling (Desktop) */
.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
    margin-bottom: 20px;
    width: 100%;
}

.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    list-style: none;
    padding: 0;
    margin: 0 auto;
}

.pagination .page-item {
    transition: all 0.25s ease;
}

.pagination .page-item .page-link {
    border: none;
    background: #f8f9fa;
    color: #c91a1aff;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}

.pagination .page-item .page-link:hover {
    background: #eaf9f0;
    transform: translateY(-2px);
}

.pagination .page-item.active .page-link {
    background: #c91a1aff;
    color: white;
    box-shadow: 0 3px 10px rgba(153, 56, 7, 0.4);
}

.pagination .page-item.disabled .page-link {
    opacity: 0.5;
    pointer-events: none;
}

/* 📱 Pagination – Mobile View */
@media (max-width: 768px) {
    .pagination-wrapper {
        margin-top: 30px;
        margin-bottom: 30px;
        padding: 0 10px;
    }

    .pagination {
        gap: 5px;
    }

    .pagination .page-item .page-link {
        width: 34px;
        height: 34px;
        font-size: 13px;
        border-radius: 50%;
        position: relative;
    }

    /* Hide "Previous" and "Next" text */
    .pagination .page-item:first-child .page-link span,
    .pagination .page-item:last-child .page-link span {
        display: none !important;
    }

    /* Add clean arrows */
    .pagination .page-item:first-child .page-link::before {
        content: "‹";
        font-size: 20px;
        font-weight: 700;
        color: #c91a1aff;
    }

    .pagination .page-item:last-child .page-link::before {
        content: "›";
        font-size: 20px;
        font-weight: 700;
        color: #c91a1aff;
    }
}
</style>


<div id="page-content">
    <!-- 🛍️ Collection Header -->
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image">
                <img class="blur-up lazyload"
                    data-src="{{ publicPath('themeAssets/images/cat-women.jpg') }}"
                    src="{{ publicPath('themeAssets/images/cat-women.jpg') }}"
                    alt="Women" title="Women" />
            </div>
            <div class="collection-hero__title-wrapper">
                <h1 class="collection-hero__title page-width">Shop</h1>
            </div>
        </div>
    </div>

    <br>

    <div class="container">
        <div class="row">
            <!-- 🏷️ Main Content -->
            <div class="col-12 main-col">
                <div class="productList">
                    <div class="grid-products grid--view-items">
                        <div class="row">
                            @if ($products->count() > 0)
                                @foreach ($products as $items)
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 item mb-4">
                                        <!-- Product Image -->
                                        <div class="product-image">
                                            <a href="{{ route('product', $items->slug) }}">
                                                <img class="primary blur-up lazyload"
                                                    data-src="{{ asset('storage/' . $items->image_array[0]) }}"
                                                    src="{{ asset('storage/' . $items->image_array[0]) }}"
                                                    alt="{{ $items->name }}">

                                                <img class="hover blur-up lazyload"
                                                    data-src="{{ asset('storage/' . ($items->image_array[1] ?? $items->image_array[0])) }}"
                                                    src="{{ asset('storage/' . ($items->image_array[1] ?? $items->image_array[0])) }}"
                                                    alt="{{ $items->name }}">

                                                @if (!empty($items->sale_price))
                                                    @php
                                                        $percent = (($items->price - $items->sale_price) / $items->price) * 100;
                                                    @endphp
                                                    <div class="product-labels rectangular">
                                                        <span class="lbl on-sale">- {{ round($percent) }}%</span>
                                                        @foreach ($items->tag as $tag)
                                                            <span class="lbl pr-label1">{{ $tag }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </a>

                                            @if ($items->qty > 0)
                                                <div class="variants add text-center mt-2">
                                                    <a href="{{ url('/order-whatsapp/' . $items->id) }}"
   class="btn btn-whatsapp"
   target="_blank" rel="noopener">
   <i class="fa fa-whatsapp"></i>
   <span class="long-text">Order on WhatsApp</span>
   <span class="short-text">Order Now</span>
</a>
                                                </div>
                                            @else
                                                <div class="variants add">
                                                    <button class="btn btn-add-to-cart">Coming Soon</button>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="product-details text-center mt-3">
                                            <div class="product-name">
                                                <a href="{{ route('product', $items->slug) }}">
                                                    {{ $items->name }}
                                                </a>
                                            </div>

                                            @if (!empty($items->sale_price))
                                                <div class="product-price">
                                                    <span class="old-price">₹{{ $items->price }}</span>
                                                    <span class="price">₹{{ $items->sale_price }}</span>
                                                </div>
                                            @else
                                                <div class="product-price">
                                                    <span class="price">₹{{ $items->price }}</span>
                                                </div>
                                            @endif

                                            <div class="product-review mt-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="font-13 fa {{ $i <= $items->rating ? 'fa-star text-warning' : 'fa-star-o' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- PAGINATION -->
                                <div class="col-12 pagination-wrapper">
                                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                                </div>
                            @else
                                <div class="col-12 text-center mt-4">
                                    <p>No Product Found, try another category or brand.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
