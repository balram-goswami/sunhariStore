<div id="page-content">
    <!--Collection Banner-->
    <div class="collection-header">
        <div class="collection-hero">
            <div class="collection-hero__image">
                <img class="blur-up lazyload" data-src="{{ publicPath('themeAssets/images/cat-women.jpg') }}"
                    src="{{ publicPath('themeAssets/images/cat-women.jpg') }}" alt="Women" title="Women" />
            </div>
            <div class="collection-hero__title-wrapper">
                <h1 class="collection-hero__title page-width">Shop</h1>
            </div>
        </div>
    </div>
    <!--End Collection Banner-->
    <br>
    <div class="container">
        <div class="row">
            <!--Main Content-->
            <div class="col-12 main-col">
                <div class="productList">
                    <div class="grid-products grid--view-items">
                        <div class="row">
                            @if ($products->count() > 0)
                            @foreach ($products as $items)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3 item">
                                <!-- start product image -->
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
                                        $percent =
                                        (($items->price - $items->sale_price) / $items->price) * 100;
                                        @endphp
                                        <div class="product-labels rectangular">
                                            <span class="lbl on-sale">- {{ round($percent) }}%</span>
                                            @foreach($items->tag as $tag)
                                            <span class="lbl pr-label1">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </a>

                                    <!-- Start product button -->
                                    @if ($items->qty > 0)
                                    @if($items->has_variants)
                                    <div class="variants add">
                                        <a href="{{ route('product', $items->slug) }}" class="btn"
                                            style="letter-spacing: 0;">Select Options</a>
                                    </div>
                                    @else
                                    <div class="variants add">
                                        <button class="btn btn-add-to-cart"
                                            data-id="{{ $items->id }}" data-qty="1">
                                            Add to Cart
                                        </button>
                                    </div>
                                    <div class="button-set">
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist"
                                                href="">
                                                <i class="icon anm anm-heart-l"></i>
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- <div class="variants add text-center mt-2">
                                        <a href="{{ url('/order-whatsapp/' . $items->id) }}"
                                            class="btn btn-whatsapp"
                                            target="_blank" rel="noopener">
                                            <i class="fa fa-whatsapp"></i> Order on WhatsApp
                                        </a>
                                    </div> -->
                                    @else
                                    <div class="variants add">
                                        <button class="btn btn-add-to-cart">
                                            Coming Soon
                                        </button>
                                    </div>
                                    @endif
                                </div>
                                <!-- end product image -->

                                <!--start product details -->
                                <div class="product-details text-center">
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

                                    <div class="product-review">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i
                                            class="font-13 fa {{ $i <= $items->rating ? 'fa-star text-warning' : 'fa-star-o' }}"></i>
                                            @endfor
                                    </div>
                                </div>
                                <!-- End product details -->
                            </div>
                            @endforeach
                            @else
                            <div class="col-12 text-center mt-4">
                                <p>No Product Found, try another category or brand.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </div>
</div>

<style>
    /* WhatsApp button styling */
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

    /* 📱 Mobile View */
    @media only screen and (max-width: 1024px) {
        .btn-whatsapp {
            width: 100%;
            font-size: 14px;
            padding: 10px 14px;
            border-radius: 10px;
            justify-content: center;
            background-color: #25D366 !important;
            color: #fff !important;
        }
    }
</style>