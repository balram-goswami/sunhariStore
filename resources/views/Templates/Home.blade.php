<div id="page-content">
    <div class="slideshow slideshow-wrapper pb-section sliderFull">
        <div class="home-slideshow">
            <div class="slide">
                <div class="blur-up lazyload bg-size">
                    <img class="blur-up lazyload bg-img" data-src="{{ publicPath('themeAssets/demo/10.jpg') }}"
                        src="{{ publicPath('themeAssets/demo/10.jpg') }}" alt="Shop Our New Collection"
                        title="Shop Our New Collection" />
                    <div class="slideshow__text-wrap slideshow__overlay classic bottom">
                        <div class="slideshow__text-content bottom">
                            <div class="wrap-caption center">
                                <h2 class="h1 mega-title slideshow__title">Shop Our New Collection</h2>
                                <span class="mega-subtitle slideshow__subtitle">From High to low, classic or
                                    modern. We have you covered</span>
                                <span class="btn">Shop now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide">
                <div class="blur-up lazyload bg-size">
                    <img class="blur-up lazyload bg-img" data-src="{{ publicPath('themeAssets/demo/11.jpg') }}"
                        src="{{ publicPath('themeAssets/demo/11.jpg') }}" alt="Summer Bikini Collection"
                        title="Summer Langha Collection" />
                    <div class="slideshow__text-wrap slideshow__overlay classic bottom">
                        <div class="slideshow__text-content bottom">
                            <div class="wrap-caption center">
                                <h2 class="h1 mega-title slideshow__title">Summer Langha Collection</h2>
                                <span class="mega-subtitle slideshow__subtitle">Save up to 50% off this weekend
                                    only</span>
                                <span class="btn">Shop now</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-slider-product section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <h2 class="h2">New Arrivals</h2>
                        <p>Browse the huge variety of our products</p>
                    </div>
                    <div class="tabs-listing">
                        <div class="tab_container">
                            <div class="tab_content grid-products">
                                <div class="productSlider">

                                    @foreach ($products as $items)
                                    <div class="col-12 item">
                                    @include('components.product-card' , compact('items'))
                                    @endforeach
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="collection-box section">
        <div class="container-fluid">
            <div class="collection-grid">
                <div class="collection-grid-item">
                    <a href="{{ route('products') }}" class="collection-grid-item__link">
                        <img data-src="{{ publicPath('themeAssets/demo/1.png') }}"
                            src="{{ publicPath('themeAssets/demo/1.png') }}" alt="Fashion" class="blur-up lazyload" />
                        <div class="collection-grid-item__title-wrapper">
                            <h3 class="collection-grid-item__title btn btn--secondary no-border">Designer Lehengas</h3>
                        </div>
                    </a>
                </div>
                <div class="collection-grid-item">
                    <a href="{{ route('products') }}" class="collection-grid-item__link">
                        <img class="blur-up lazyload" data-src="{{ publicPath('themeAssets/demo/3.png') }}"
                            src="{{ publicPath('themeAssets/demo/3.png') }}" alt="Cosmetic" />
                        <div class="collection-grid-item__title-wrapper">
                            <h3 class="collection-grid-item__title btn btn--secondary no-border">Best Fabric</h3>
                        </div>
                    </a>
                </div>
                <div class="collection-grid-item blur-up lazyloaded">
                    <a href="{{ route('products') }}" class="collection-grid-item__link">
                        <img data-src="{{ publicPath('themeAssets/demo/4.png') }}"
                            src="{{ publicPath('themeAssets/demo/4.png') }}" alt="Bag"
                            class="blur-up lazyload" />
                        <div class="collection-grid-item__title-wrapper">
                            <h3 class="collection-grid-item__title btn btn--secondary no-border">Printed Lehengas</h3>
                        </div>
                    </a>
                </div>
                <div class="collection-grid-item">
                    <a href="{{ route('products') }}" class="collection-grid-item__link">
                        <img data-src="{{ publicPath('themeAssets/demo/2.png') }}"
                            src="{{ publicPath('themeAssets/demo/2.png') }}" alt="Accessories"
                            class="blur-up lazyload" />
                        <div class="collection-grid-item__title-wrapper">
                            <h3 class="collection-grid-item__title btn btn--secondary no-border">Hand work
                            </h3>
                        </div>
                    </a>
                </div>
                <div class="collection-grid-item">
                    <a href="{{ route('products') }}" class="collection-grid-item__link">
                        <img data-src="{{ publicPath('themeAssets/demo/5.png') }}"
                            src="{{ publicPath('themeAssets/demo/5.png') }}" alt="Shoes"
                            class="blur-up lazyload" />
                        <div class="collection-grid-item__title-wrapper">
                            <h3 class="collection-grid-item__title btn btn--secondary no-border">Panelled Lehenga</h3>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="section logo-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="logo-bar">
                        <div class="logo-bar__item">
                            <img src="{{ publicPath('themeAssets/images/logo/brandlogo1.png') }}" alt=""
                                title="" />
                        </div>
                        <div class="logo-bar__item">
                            <img src="{{ publicPath('themeAssets/images/logo/brandlogo2.png') }}" alt=""
                                title="" />
                        </div>
                        <div class="logo-bar__item">
                            <img src="{{ publicPath('themeAssets/images/logo/brandlogo3.png') }}" alt=""
                                title="" />
                        </div>
                        <div class="logo-bar__item">
                            <img src="{{ publicPath('themeAssets/images/logo/brandlogo4.png') }}" alt=""
                                title="" />
                        </div>
                        <div class="logo-bar__item">
                            <img src="{{ publicPath('themeAssets/images/logo/brandlogo5.png') }}" alt=""
                                title="" />
                        </div>
                        <div class="logo-bar__item">
                            <img src="{{ publicPath('themeAssets/images/logo/brandlogo6.png') }}" alt=""
                                title="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="product-rows section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="section-header text-center">
                        <h2 class="h2">Featured collection</h2>
                        <p>Our most popular products based on sales</p>
                    </div>
                </div>
            </div>
            <div class="grid-products">
                <div class="row">

                    @foreach ($products as $items)
                   

                    <div class="col-6 col-sm-6 col-md-4 col-lg-4 item grid-view-item style2">
                        <div class="grid-view_image">
                            <a href="{{ route('product', $items->slug) }}"
                                class="grid-view-item__link">
                                <img class="primary"
                                    src="{{ asset('storage/' . $items->image_array[0]) }}"
                                    alt="{{ $items->name }}">

                                <img class="hover"
                                    src="{{ asset('storage/' . ($items->image_array[1] ?? $items->image_array[0])) }}"
                                    alt="{{ $items->name }}">

                                @if (!empty($items->sale_price))
                                 @php
        $percent = (($items->price - $items->sale_price) / $items->price) * 100;
        @endphp
                                <div class="product-labels rectangular">
                                    <span class="lbl on-sale">-{{ $percent }} %</span>
                                    <span class="lbl pr-label1">new</span>
                                </div>
                                @endif
                            </a>

                            <div class="product-details hoverDetails text-center mobile">
                                <div class="product-name">
                                    <a
                                        href="{{ route('product', $items->slug) }}">
                                        {{ $items->name }}
                                    </a>
                                </div>

                                <div class="product-price">
                                    @if (!empty($items->sale_price))
                                    <span class="old-price">₹ {{ $items->price }}</span>
                                    <span class="price"> ₹{{ $items->sale_price }}</span>
                                    @else
                                    <span class="price">₹ {{ $items->price  }}</span>
                                    @endif
                                </div>

                                <!-- <div class="button-set">
                                        <a href="javascript:void(0)" title="Quick View"
                                            class="quick-view-popup quick-view" data-toggle="modal"
                                            data-target="#content_quickview_{{ $items->slug }}">
                                            <i class="icon anm anm-search-plus-r"></i>
                                        </a>
                                        <form class="variants add" action="#"
                                            onclick="window.location.href='cart.html'" method="post">
                                            <button class="btn cartIcon btn-addto-cart" type="button"
                                                tabindex="0">
                                                <i class="icon anm anm-bag-l"></i>
                                            </button>
                                        </form>
                                        <div class="wishlist-btn">
                                            <a class="wishlist add-to-wishlist"
                                                href="">
                                                <i class="icon anm anm-heart-l"></i>
                                            </a>
                                        </div>
                                        <div class="compare-btn">
                                            <a class="compare add-to-compare" href="compare.html"
                                                title="Add to Compare">
                                                <i class="icon anm anm-random-r"></i>
                                            </a>
                                        </div>
                                    </div>  -->
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <div class="store-feature section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <ul class="display-table store-info">
                        <li class="display-table-cell">
                            <i class="icon anm anm-truck-l"></i>
                            <h5>Free Shipping &amp; Return</h5>
                            <span class="sub-text">Free shipping on all US orders</span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-dollar-sign-r"></i>
                            <h5>Money Guarantee</h5>
                            <span class="sub-text">30 days money back guarantee</span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-comments-l"></i>
                            <h5>Online Support</h5>
                            <span class="sub-text">We support online 24/7 on day</span>
                        </li>
                        <li class="display-table-cell">
                            <i class="icon anm anm-credit-card-front-r"></i>
                            <h5>Secure Payments</h5>
                            <span class="sub-text">All payment are Secured and trusted.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click', '.btn-add-to-cart', function(e) {
        e.preventDefault();
        console.log("Add to cart clicked!");

        let productId = $(this).data('id');
        let qty = $(this).data('qty');
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "{{ route('add-to-cart') }}",
            type: "POST",
            data: {
                _token: token,
                product_id: productId,
                quantity: qty
            },
            success: function(response) {
                console.log(response);
                if (response.status === 'success') {
                    $("#cart-count").text(response.cart_count);
                    alert(response.message);
                }
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
            }
        });
    });

    $(document).on('click', '.btn-remove-from-cart', function(e) {
        e.preventDefault();
        let itemId = $(this).data('id');
        let token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: "/remove-from-cart/" + itemId,
            type: "POST",
            data: {
                _token: token
            },
            success: function(response) {
                if (response.status === 'success') {
                    $("#cart-count").text(response.cart_count);
                    alert(response.message);
                }
            }
        });
    });
</script>