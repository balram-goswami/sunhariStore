<style>
    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .product-tabs li {
        cursor: pointer;
        display: inline-block;
        margin-right: 10px;
        padding: 5px 10px;
        background: #f1f1f1;
        border-radius: 4px;
    }

    .product-tabs li.active {
        background: #ddd;
        font-weight: bold;
    }
</style>

<div id="page-content">
    <!--MainContent-->
    <div id="MainContent" class="main-content" role="main">
        <!--Breadcrumb-->
        <div class="bredcrumbWrap">
            <div class="container breadcrumbs">
                <a href="{{ route('homePage')}}" title="Back to the home page">Home</a><span
                    aria-hidden="true">›</span><span>{{ $product->name }}</span>
            </div>
        </div>
        <!--End Breadcrumb-->

        <div id="ProductSection-product-template" class="product-template__container prstyle1 container">
            <!--product-single-->
            <div class="product-single">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="product-details-img">
                            <div class="product-thumb">
                                <div id="gallery" class="product-dec-slider-2 product-tab-left">
                                    @foreach ($product->image_array as $image)
                                    <a href="javascript:void(0);"
                                        data-image="{{ asset('storage/' . $image) }}"
                                        data-zoom-image="{{ asset('storage/' . $image) }}">
                                        <img class="blur-up lazyload"
                                            src="{{ asset('storage/' . $image) }}"
                                            alt="{{ $product->name }}">
                                    </a>
                                    @endforeach
                                </div>
                            </div>


                            <div class="zoompro-wrap product-zoom-right pl-20">
                                <div class="zoompro-span">
                                    <img id="mainProductImage" class="blur-up lazyload zoompro"
                                        data-zoom-image="{{ asset('storage/' . $product->image_array[0]) }}" alt="{{ $product->name }}"
                                        src="{{ asset('storage/' . $product->image_array[0]) }}">
                                </div>
                                <div class="product-labels">
                                    @if ($product->is_saleable)
                                    <span class="lbl on-sale">Sale</span>
                                    @endif
                                    @if ($product->is_featured)
                                    <span class="lbl pr-label1">New</span>
                                    @endif
                                </div>
                                <div class="product-buttons">
                                    <a href="#" class="btn prlightbox" title="Zoom">
                                        <i class="icon anm anm-expand-l-arrows" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="lightboximages">
                                <a href="{{ asset('storage/' . $product->image_array[0]) }}" data-size="1024x1024"></a>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="product-single__meta">
                            <h1 class="product-single__title">{{ $product->name }}</h1>
                            <div class="prInfoRow">
                                @if ($product->qty >= 1)
                                <div class="product-stock"> <span class="instock ">In Stock</span> </div>
                                @else
                                <div class="product-stock"><span class="outstock">Unavailable</span> </div>
                                @endif
                                <div class="product-sku">SKU: <span class="variant-sku">{{ $product->sku }}</span>
                                </div>
                                <div class="product-review"><a class="reviewLink" href="#tab2"><i
                                            class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i
                                            class="font-13 fa fa-star"></i><i class="font-13 fa fa-star-o"></i><i
                                            class="font-13 fa fa-star-o"></i><span class="spr-badge-caption">6
                                            reviews</span></a></div>
                            </div>
                            <p class="product-single__price product-single__price-product-template">
                                <span class="visually-hidden">Regular price</span>
                                <s id="ComparePrice-product-template">
                                    <span class="money">₹ {{ number_format($product->price, 2) }}</span>
                                </s>
                                <span
                                    class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                    <span id="ProductPrice-product-template">
                                        <span class="money">₹ {{ number_format($product->sale_price, 2) }}</span>
                                    </span>
                                </span>
                            </p>

                            <div class="orderMsg" data-user="23" data-time="24">
                                <img src="{{ publicPath('/themeAssets/images/order-icon.jpg') }}" alt="" />
                                <strong class="items">5</strong> sold in last <strong class="time">24</strong> hours
                            </div>
                        </div>
                        <div class="product-single__description rte">
                            <p>{{ $product->short_description }}</p>
                        </div>
                        @if ($product->qty > 0)
                        <div id="quantity_message">
                            Hurry! Only <span class="items">{{ $product->qty }}</span> left in stock.
                        </div>
                        @else
                        <div id="quantity_message" class="text-danger">
                            Out of Stock
                        </div>
                        @endif
                        <form method="post" action="http://annimexweb.com/cart/add" id="product_form_10508262282"
                            accept-charset="UTF-8" class="product-form product-form-product-template hidedropdown"
                            enctype="multipart/form-data">
                            <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                                <div class="product-form__item">
                                    <label class="header">Color: <span class="slVariant">Red</span></label>
                                    <div data-value="Black" class="swatch-element color black available">
                                        <input class="swatchInput" id="swatch-0-black" type="radio"
                                            name="option-0" value="Black"><label class="swatchLbl color small"
                                            for="swatch-0-black" style="background-color:black;"
                                            title="Black"></label>
                                    </div>
                                    <div data-value="Maroon" class="swatch-element color maroon available">
                                        <input class="swatchInput" id="swatch-0-maroon" type="radio"
                                            name="option-0" value="Maroon"><label class="swatchLbl color small"
                                            for="swatch-0-maroon" style="background-color:maroon;"
                                            title="Maroon"></label>
                                    </div>
                                    <div data-value="Blue" class="swatch-element color blue available">
                                        <input class="swatchInput" id="swatch-0-blue" type="radio" name="option-0"
                                            value="Blue"><label class="swatchLbl color small" for="swatch-0-blue"
                                            style="background-color:blue;" title="Blue"></label>
                                    </div>
                                    <div data-value="Dark Green" class="swatch-element color dark-green available">
                                        <input class="swatchInput" id="swatch-0-dark-green" type="radio"
                                            name="option-0" value="Dark Green"><label class="swatchLbl color small"
                                            for="swatch-0-dark-green" style="background-color:darkgreen;"
                                            title="Dark Green"></label>
                                    </div>
                                </div>
                            </div>
                            <!-- Product Action -->
                            <div class="product-action clearfix">
                                <!-- <div class="product-form__item--quantity">
                                    <div class="wrapQtyBtn">
                                        <div class="qtyField">
                                            <a class="qtyBtn minus" href="javascript:void(0);">
                                                <i class="fa anm anm-minus-r" aria-hidden="true"></i>
                                            </a>
                                            <input type="text" id="Quantity" name="quantity" value="1"
                                                class="product-form__input qty">
                                            <a class="qtyBtn plus" href="javascript:void(0);">
                                                <i class="fa anm anm-plus-r" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div> -->

                                @if ($product->qty >= 1)
                                <!-- <div class="product-form__item--submit">
                                    <button type="button" name="add" class="btn product-form__cart-submit">
                                        <span>Add to cart</span>
                                    </button>
                                </div>
                                <div class="shopify-payment-button" data-shopify="payment-button">
                                    <button type="button"
                                        class="shopify-payment-button__button shopify-payment-button__button--unbranded">
                                        Buy it now
                                    </button>
                                </div> -->

                                <div class="product-form__item--submit">
                                    <a href="{{ url('/order-whatsapp/'.$product->id) }}"
                                        class="btn btn-success">
                                        Order on WhatsApp
                                    </a>
                                </div>

                                @else
                                <!-- Out of Stock → Show Coming Soon -->
                                <div class="product-form__item--submit">
                                    <button type="button" class="btn btn-secondary" disabled>
                                        <span>Coming Soon</span>
                                    </button>
                                </div>
                                @endif
                            </div>

                            <!-- End Product Action -->
                        </form>
                        <div class="display-table shareRow">
                            <div class="display-table-cell medium-up--one-third">
                                <div class="wishlist-btn">
                                    <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist"><i
                                            class="icon anm anm-heart-l" aria-hidden="true"></i> <span>Add to
                                            Wishlist</span></a>
                                </div>
                            </div>
                            <div class="display-table-cell text-right">
                                <div class="social-sharing">
                                    <a target="_blank" href="#"
                                        class="btn btn--small btn--secondary btn--share share-facebook"
                                        title="Share on Facebook">
                                        <i class="fa fa-facebook-square" aria-hidden="true"></i> <span
                                            class="share-title" aria-hidden="true">Share</span>
                                    </a>
                                    <a target="_blank" href="#"
                                        class="btn btn--small btn--secondary btn--share share-twitter"
                                        title="Tweet on Twitter">
                                        <i class="fa fa-twitter" aria-hidden="true"></i> <span class="share-title"
                                            aria-hidden="true">Tweet</span>
                                    </a>
                                    <a href="#" title="Share on google+"
                                        class="btn btn--small btn--secondary btn--share">
                                        <i class="fa fa-google-plus" aria-hidden="true"></i> <span
                                            class="share-title" aria-hidden="true">Google+</span>
                                    </a>
                                    <a target="_blank" href="#"
                                        class="btn btn--small btn--secondary btn--share share-pinterest"
                                        title="Pin on Pinterest">
                                        <i class="fa fa-pinterest" aria-hidden="true"></i> <span class="share-title"
                                            aria-hidden="true">Pin it</span>
                                    </a>
                                    <a href="#" class="btn btn--small btn--secondary btn--share share-pinterest"
                                        title="Share by Email" target="_blank">
                                        <i class="fa fa-envelope" aria-hidden="true"></i> <span class="share-title"
                                            aria-hidden="true">Email</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <p id="freeShipMsg" class="freeShipMsg" data-price="{{ $product->sale_price ?? $product->price }}">
                            <i class="fa fa-truck" aria-hidden="true"></i>
                            GETTING CLOSER! ONLY <b class="freeShip"><span
                                    class="money">{{ $product->sale_price ?? $product->price }}</span></b> AWAY FROM
                            <b>FREE SHIPPING!</b>
                        </p>
                        <p class="shippingMsg">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> ESTIMATED DELIVERY
                            BETWEEN <b id="fromDate"></b> and <b id="toDate"></b>.
                        </p>
                        <div class="userViewMsg" data-user="20" data-time="11000"><i class="fa fa-users"
                                aria-hidden="true"></i> <strong class="uersView">14</strong> PEOPLE ARE LOOKING FOR
                            THIS PRODUCT</div>
                    </div>
                </div>
            </div>

            <script>
                function changeMainImage(imageUrl) {
                    const mainImg = document.getElementById('mainProductImage');
                    mainImg.src = imageUrl;
                    mainImg.setAttribute('data-zoom-image', imageUrl);
                }
            </script>

            <!--End-product-single-->
            <!--Product Fearure-->
            <div class="prFeatures">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                        <img src="{{ publicPath('/themeAssets/images/credit-card.png') }}" alt="Safe Payment"
                            title="Safe Payment" />
                        <div class="details">
                            <h3>Safe Payment</h3>Pay with the world's most payment methods.
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                        <img src="{{ publicPath('/themeAssets/images/shield.png') }}" alt="Confidence"
                            title="Confidence" />
                        <div class="details">
                            <h3>Confidence</h3>Protection covers your purchase and personal data.
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                        <img src="{{ publicPath('/themeAssets/images/worldwide.png') }}" alt="Worldwide Delivery"
                            title="Worldwide Delivery" />
                        <div class="details">
                            <h3>Worldwide Delivery</h3>FREE &amp; fast shipping to over 200+ countries &amp; regions.
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 feature">
                        <img src="{{ publicPath('/themeAssets/images/phone-call.png') }}" alt="Hotline"
                            title="Hotline" />
                        <div class="details">
                            <h3>Need Help</h3>Click here to get help
                        </div>
                    </div>
                </div>
            </div>
            <!--End Product Fearure-->
            <!--Product Tabs-->
            <div class="tabs-listing">
                <ul class="product-tabs">
                    <li rel="tab1"><a class="tablink">Product Details</a></li>
                    <li rel="tab2"><a class="tablink">Product Reviews</a></li>
                </ul>
                <div class="tab-container">
                    <div id="tab1" class="tab-content">
                        <div class="product-description rte">
                            {!! $product->description !!}
                        </div>
                    </div>

                    <div id="tab2" class="tab-content">
                        <div id="shopify-product-reviews">
                            <div class="spr-container">
                                <div class="spr-header clearfix">
                                    <div class="spr-summary">
                                        <span class="product-review"><a class="reviewLink"><i
                                                    class="font-13 fa fa-star"></i><i
                                                    class="font-13 fa fa-star"></i><i
                                                    class="font-13 fa fa-star"></i><i
                                                    class="font-13 fa fa-star-o"></i><i
                                                    class="font-13 fa fa-star-o"></i> </a><span
                                                class="spr-summary-actions-togglereviews">Based on
                                                reviews </span></span>
                                        <span class="spr-summary-actions">
                                            <a href="" class="spr-summary-actions-newreview btn">Write a
                                                review</a>
                                        </span>
                                    </div>
                                </div>
                                <div class="spr-content">
                                    {{-- <div class="spr-form clearfix">
                                        <form method="post" action="#" id="new-review-form"
                                            class="new-review-form">
                                            <h3 class="spr-form-title">Write a review</h3>
                                            <fieldset class="spr-form-contact">
                                                <div class="spr-form-contact-name">
                                                    <label class="spr-form-label"
                                                        for="review_author_10508262282">Name</label>
                                                    <input class="spr-form-input spr-form-input-text "
                                                        id="review_author_10508262282" type="text"
                                                        name="review[author]" value=""
                                                        placeholder="Enter your name">
                                                </div>
                                                <div class="spr-form-contact-email">
                                                    <label class="spr-form-label"
                                                        for="review_email_10508262282">Email</label>
                                                    <input class="spr-form-input spr-form-input-email "
                                                        id="review_email_10508262282" type="email"
                                                        name="review[email]" value=""
                                                        placeholder="john.smith@example.com">
                                                </div>
                                            </fieldset>
                                            <fieldset class="spr-form-review">
                                                <div class="spr-form-review-rating">
                                                    <label class="spr-form-label">Rating</label>
                                                    <div class="spr-form-input spr-starrating">
                                                        <div class="product-review"><a class="reviewLink"
                                                                href="#"><i class="fa fa-star-o"></i><i
                                                                    class="font-13 fa fa-star-o"></i><i
                                                                    class="font-13 fa fa-star-o"></i><i
                                                                    class="font-13 fa fa-star-o"></i><i
                                                                    class="font-13 fa fa-star-o"></i></a></div>
                                                    </div>
                                                </div>

                                                <div class="spr-form-review-title">
                                                    <label class="spr-form-label"
                                                        for="review_title_10508262282">Review Title</label>
                                                    <input class="spr-form-input spr-form-input-text "
                                                        id="review_title_10508262282" type="text"
                                                        name="review[title]" value=""
                                                        placeholder="Give your review a title">
                                                </div>

                                                <div class="spr-form-review-body">
                                                    <label class="spr-form-label" for="review_body_10508262282">Body
                                                        of Review <span
                                                            class="spr-form-review-body-charactersremaining">(1500)</span></label>
                                                    <div class="spr-form-input">
                                                        <textarea class="spr-form-input spr-form-input-textarea " id="review_body_10508262282" data-product-id="10508262282"
                                                            name="review[body]" rows="10" placeholder="Write your comments here"></textarea>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="spr-form-actions">
                                                <input type="submit"
                                                    class="spr-button spr-button-primary button button-primary btn btn-primary"
                                                    value="Submit Review">
                                            </fieldset>
                                        </form>
                                    </div> --}}
                                    <div class="spr-reviews">

                                        <!-- Review 1 -->
                                        <div class="spr-review">
                                            <div class="spr-review-header">
                                                <span
                                                    class="product-review spr-starratings spr-review-header-starratings">
                                                    <span class="reviewLink">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-half-o"></i>
                                                    </span>
                                                </span>
                                                <h3 class="spr-review-header-title">Absolutely stunning langha!</h3>
                                                <span class="spr-review-header-byline"><strong>Ayesha K.</strong> on
                                                    <strong>Aug 12, 2025</strong></span>
                                            </div>
                                            <div class="spr-review-content">
                                                <p class="spr-review-content-body">
                                                    The embroidery and color combination are perfect. It fit me
                                                    beautifully and I received so many compliments on my wedding day.
                                                    Highly recommend!
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Review 2 -->
                                        <div class="spr-review">
                                            <div class="spr-review-header">
                                                <span
                                                    class="product-review spr-starratings spr-review-header-starratings">
                                                    <span class="reviewLink">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span>
                                                </span>
                                                <h3 class="spr-review-header-title">Elegant and graceful!</h3>
                                                <span class="spr-review-header-byline"><strong>Meera S.</strong> on
                                                    <strong>Jul 22, 2025</strong></span>
                                            </div>
                                            <div class="spr-review-content">
                                                <p class="spr-review-content-body">
                                                    The langha exceeded my expectations. The fabric is soft and
                                                    comfortable, and the detailed work is exquisite. Loved every bit of
                                                    it!
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Review 3 -->
                                        <div class="spr-review">
                                            <div class="spr-review-header">
                                                <span
                                                    class="product-review spr-starratings spr-review-header-starratings">
                                                    <span class="reviewLink">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </span>
                                                </span>
                                                <h3 class="spr-review-header-title">Beautiful, but a bit long</h3>
                                                <span class="spr-review-header-byline"><strong>Ritu P.</strong> on
                                                    <strong>Jun 15, 2025</strong></span>
                                            </div>
                                            <div class="spr-review-content">
                                                <p class="spr-review-content-body">
                                                    Gorgeous design and embroidery, though I had to get minor tailoring.
                                                    Overall, a very elegant piece that makes you feel like a princess.
                                                </p>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab4" class="tab-content">
                        <h4>Returns Policy</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce eros justo, accumsan non dui
                            sit amet. Phasellus semper volutpat mi sed imperdiet. Ut odio lectus, vulputate non ex non,
                            mattis sollicitudin purus. Mauris consequat justo a enim interdum, in consequat dolor
                            accumsan. Nulla iaculis diam purus, ut vehicula leo efficitur at.</p>
                        <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. In blandit nunc enim, sit amet
                            pharetra erat aliquet ac.</p>
                        <h4>Shipping</h4>
                        <p>Pellentesque ultrices ut sem sit amet lacinia. Sed nisi dui, ultrices ut turpis pulvinar. Sed
                            fringilla ex eget lorem consectetur, consectetur blandit lacus varius. Duis vel scelerisque
                            elit, et vestibulum metus. Integer sit amet tincidunt tortor. Ut lacinia ullamcorper massa,
                            a fermentum arcu vehicula ut. Ut efficitur faucibus dui Nullam tristique dolor eget turpis
                            consequat varius. Quisque a interdum augue. Nam ut nibh mauris.</p>
                    </div>
                </div>
            </div>
            <!--End Product Tabs-->

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

                                            @foreach ($allproduct as $items)
                                            <div class="col-12 item">
                                                <!-- start product image -->
                                                <div class="product-image">
                                                    <!-- start product image -->
                                                    <a href="{{ route('product', $items->slug) }}">
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
                                                            <span class="lbl on-sale">- {{$percent}}%</span>
                                                            <span class="lbl pr-label1">new</span>
                                                        </div>
                                                        @endif
                                                        <!-- End product label -->
                                                    </a>
                                                    <!-- end product image -->

                                                    <!-- countdown start -->
                                                    <!-- <div class="saleTime desktop" data-countdown="2022/03/01"></div> -->
                                                    <!-- countdown end -->

                                                    <!-- Start product button -->
                                                    @if ($items->qty > 0)
                                                    <div class="variants add">
                                                        <!-- <button class="btn btn-add-to-cart"
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
                                                        </div> -->
                                                        <a href="{{ url('/order-whatsapp/'.$items->id) }}"
            class="btn btn-success">
            Order on WhatsApp
        </a>
                                                    </div>
                                                    @else
                                                    <div class="variants add">
                                                        <button class="btn btn-add-to-cart">
                                                            Coming Soon
                                                        </button>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="product-details text-center">
                                                    <div class="product-name">
                                                        <a
                                                            href="{{ route('product', $items->slug) }}">{{ $items->name }}</a>
                                                    </div>

                                                    @if (!empty($items->sale_price))
                                                    <div class="product-price">
                                                        <span class="old-price">₹ {{ $items->price }}</span>
                                                        <span class="price"> ₹{{ $items->sale_price }}</span>
                                                    </div>
                                                    @else
                                                    <div class="product-price">
                                                        <span class="price">₹ {{ $items->price }}</span>
                                                    </div>
                                                    @endif

                                                    <div class="product-review">
                                                        <i class="font-13 fa fa-star"></i>
                                                        <i class="font-13 fa fa-star"></i>
                                                        <i class="font-13 fa fa-star"></i>
                                                        <i class="font-13 fa fa-star"></i>
                                                        <i class="font-13 fa fa-star-o"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ publicPath('/themeAssets/js/vendor/photoswipe.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/vendor/photoswipe-ui-default.min.js') }}"></script>
<script>
    $(function() {
        var $pswp = $('.pswp')[0],
            image = [],
            getItems = function() {
                var items = [];
                $('.lightboximages a').each(function() {
                    var $href = $(this).attr('href'),
                        $size = $(this).data('size').split('x'),
                        item = {
                            src: $href,
                            w: $size[0],
                            h: $size[1]
                        }
                    items.push(item);
                });
                return items;
            }
        var items = getItems();

        $.each(items, function(index, value) {
            image[index] = new Image();
            image[index].src = value['src'];
        });
        $('.prlightbox').on('click', function(event) {
            event.preventDefault();

            var $index = $(".active-thumb").parent().attr('data-slick-index');
            $index++;
            $index = $index - 1;

            var options = {
                index: $index,
                bgOpacity: 0.9,
                showHideOpacity: true
            }
            var lightBox = new PhotoSwipe($pswp, PhotoSwipeUI_Default, items, options);
            lightBox.init();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let tabs = document.querySelectorAll(".product-tabs li");
        let contents = document.querySelectorAll(".tab-content");

        if (tabs.length > 0) {
            tabs[0].classList.add("active");
        }
        if (contents.length > 0) {
            contents[0].classList.add("active");
        }

        tabs.forEach(tab => {
            tab.addEventListener("click", function() {
                let tabId = this.getAttribute("rel");

                tabs.forEach(t => t.classList.remove("active"));
                contents.forEach(c => c.classList.remove("active"));

                this.classList.add("active");
                document.getElementById(tabId).classList.add("active");
            });
        });
    });
</script>
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="pswp__bg"></div>
    <div class="pswp__scroll-wrap">
        <div class="pswp__container">
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
            <div class="pswp__item"></div>
        </div>
        <div class="pswp__ui pswp__ui--hidden">
            <div class="pswp__top-bar">
                <div class="pswp__counter"></div><button class="pswp__button pswp__button--close"
                    title="Close (Esc)"></button><button class="pswp__button pswp__button--share"
                    title="Share"></button><button class="pswp__button pswp__button--fs"
                    title="Toggle fullscreen"></button><button class="pswp__button pswp__button--zoom"
                    title="Zoom in/out"></button>
                <div class="pswp__preloader">
                    <div class="pswp__preloader__icn">
                        <div class="pswp__preloader__cut">
                            <div class="pswp__preloader__donut"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                <div class="pswp__share-tooltip"></div>
            </div><button class="pswp__button pswp__button--arrow--left"
                title="Previous (arrow left)"></button><button class="pswp__button pswp__button--arrow--right"
                title="Next (arrow right)"></button>
            <div class="pswp__caption">
                <div class="pswp__caption__center"></div>
            </div>
        </div>
    </div>
</div>


<script>
    function formatDate(date) {
        const options = {
            weekday: 'short',
            month: 'short',
            day: 'numeric'
        };
        return date.toLocaleDateString('en-US', options);
    }

    const today = new Date();
    const fromDate = new Date(today);
    fromDate.setDate(fromDate.getDate() + 3);

    const toDate = new Date(today);
    toDate.setDate(toDate.getDate() + 7);

    document.getElementById('fromDate').innerText = formatDate(fromDate);
    document.getElementById('toDate').innerText = formatDate(toDate);
</script>
<script>
    const freeShippingThreshold = 1000;

    const freeShipMsg = document.getElementById('freeShipMsg');
    const freeShipAmountSpan = freeShipMsg.querySelector('.freeShip .money');

    // Get current product price from data attribute
    const productPrice = parseFloat(freeShipMsg.dataset.price) || 0;

    if (productPrice >= freeShippingThreshold) {
        freeShipMsg.innerHTML = '<i class="fa fa-truck" aria-hidden="true"></i> You qualify for <b>FREE SHIPPING!</b>';
    } else {
        const amountLeft = freeShippingThreshold - productPrice;
        freeShipAmountSpan.innerText = `₹${amountLeft.toFixed(2)}`;
    }
</script>