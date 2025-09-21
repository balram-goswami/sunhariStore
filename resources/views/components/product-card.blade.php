<div class="col-6 col-sm-6 col-md-4 col-lg-4 item">
    <!-- start product image -->
    <div class="product-image">
        <!-- start product image -->
        <a
            href="{{ route('product', $items->slug) }}">
            <!-- image -->
            <img class="primary blur-up lazyload"
                data-src="{{ asset('storage/' . $items->image_array[0]) }}"
                src="{{ asset('storage/' . $items->image_array[0]) }}" alt="image" title="product">
            <!-- End image -->
            <!-- Hover image -->
            <img class="hover blur-up lazyload"
                data-src="{{ asset('storage/' . $items->image_array[1]) }}"
                src="{{ asset('storage/' . $items->image_array[1]) }}" alt="image" title="product">
            <!-- End hover image -->
            <!-- product label -->
            <div class="product-labels rectangular"><span
                    class="lbl on-sale">-16%</span>
                <span class="lbl pr-label1">new</span>
            </div>
            <!-- End product label -->
        </a>
        <!-- <button class="btn btn-addto-cart" type="button">Buy Now</button> -->
        <div class="button-set">
            <a href="javascript:void(0)" title="Quick View"
                class="quick-view-popup quick-view" data-toggle="modal"
                data-target="#content_quickview_{{ $items->slug }}">
                <i class="icon anm anm-search-plus-r"></i>
            </a>
            <div class="wishlist-btn">
                <a class="wishlist add-to-wishlist" href="#"
                    title="Add to Wishlist">
                    <i class="icon anm anm-heart-l"></i>
                </a>
            </div>
        </div>
        <div class="modal fade quick-view-popup"
            id="content_quickview_{{ $items->slug }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="ProductSection-product-template"
                            class="product-template__container prstyle1">
                            <div class="product-single">
                                <!-- Start model close -->
                                <a href="javascript:void()" data-dismiss="modal"
                                    class="model-close-btn pull-right"
                                    title="close"><span
                                        class="icon icon anm anm-times-l"></span></a>
                                <!-- End model close -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="product-details-img">
                                            <div class="pl-20">
                                                <img src="{{ asset('storage/' . $items->image_array[1]) }}"
                                                    alt="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="product-single__meta">
                                            <h2 class="product-single__title">
                                                {{ $items->name }}
                                            </h2>
                                            <div class="prInfoRow">
                                                <div class="product-stock"> <span
                                                        class="instock ">In
                                                        Stock</span>
                                                    <span
                                                        class="outstock hide">Unavailable</span>
                                                </div>
                                                <div class="product-sku">SKU: <span
                                                        class="variant-sku">{{ $items->sku }}</span>
                                                </div>
                                            </div>
                                            <p
                                                class="product-single__price product-single__price-product-template">
                                                <span class="visually-hidden">Regular
                                                    price</span>
                                                <s id="ComparePrice-product-template"><span
                                                        class="money">{{ $items->price }}</span></s>
                                                <span
                                                    class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                                    <span
                                                        id="ProductPrice-product-template"><span
                                                            class="money">{{ $items->sale_price }}</span></span>
                                                </span>
                                            </p>
                                            <div
                                                class="product-single__description rte">
                                                {{ $items->excerpt }}
                                            </div>

                                            <form method="post"
                                                action="http://annimexweb.com/cart/add"
                                                id="product_form_10508262282"
                                                accept-charset="UTF-8"
                                                class="product-form product-form-product-template hidedropdown"
                                                enctype="multipart/form-data">
                                                <div class="swatch clearfix swatch-0 option1"
                                                    data-option-index="0">
                                                    <div class="product-form__item">
                                                        <label class="header">Color:
                                                            <span
                                                                class="slVariant">Red</span></label>
                                                        <div data-value="Red"
                                                            class="swatch-element color red available">
                                                            <input class="swatchInput"
                                                                id="swatch-0-red"
                                                                type="radio"
                                                                name="option-0"
                                                                value="Red">
                                                            <label
                                                                class="swatchLbl color medium rectangle"
                                                                for="swatch-0-red"
                                                                style="background-image:url({ publicPath('themeAssets/images/product-detail-page/variant1-1.jpg') }});"
                                                                title="Red"></label>
                                                        </div>
                                                        <div data-value="Blue"
                                                            class="swatch-element color blue available">
                                                            <input class="swatchInput"
                                                                id="swatch-0-blue"
                                                                type="radio"
                                                                name="option-0"
                                                                value="Blue">
                                                            <label
                                                                class="swatchLbl color medium rectangle"
                                                                for="swatch-0-blue"
                                                                style="background-image:url({ publicPath('themeAssets/images/product-detail-page/variant1-2.jpg') }});"
                                                                title="Blue"></label>
                                                        </div>
                                                        <div data-value="Green"
                                                            class="swatch-element color green available">
                                                            <input class="swatchInput"
                                                                id="swatch-0-green"
                                                                type="radio"
                                                                name="option-0"
                                                                value="Green">
                                                            <label
                                                                class="swatchLbl color medium rectangle"
                                                                for="swatch-0-green"
                                                                style="background-image:url({ publicPath('themeAssets/images/product-detail-page/variant1-3.jpg') }});"
                                                                title="Green"></label>
                                                        </div>
                                                        <div data-value="Gray"
                                                            class="swatch-element color gray available">
                                                            <input class="swatchInput"
                                                                id="swatch-0-gray"
                                                                type="radio"
                                                                name="option-0"
                                                                value="Gray">
                                                            <label
                                                                class="swatchLbl color medium rectangle"
                                                                for="swatch-0-gray"
                                                                style="background-image:url({ publicPath('themeAssets/images/product-detail-page/variant1-4.jpg') }});"
                                                                title="Gray"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Product Action -->
                                                <div class="product-action clearfix">
                                                    <div
                                                        class="product-form__item--quantity">
                                                        <div class="wrapQtyBtn">
                                                            <div class="qtyField">
                                                                <a class="qtyBtn minus"
                                                                    href="javascript:void(0);"><i
                                                                        class="fa anm anm-minus-r"
                                                                        aria-hidden="true"></i></a>
                                                                <input type="text"
                                                                    id="Quantity"
                                                                    name="quantity"
                                                                    value="1"
                                                                    class="product-form__input qty">
                                                                <a class="qtyBtn plus"
                                                                    href="javascript:void(0);"><i
                                                                        class="fa anm anm-plus-r"
                                                                        aria-hidden="true"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="product-form__item--submit">
                                                        <button type="button"
                                                            name="add"
                                                            class="btn product-form__cart-submit">
                                                            <span>Add to cart</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- End Product Action -->
                                            </form>
                                            <div class="display-table shareRow">
                                                <div class="display-table-cell">
                                                    <div class="wishlist-btn">
                                                        <a class="wishlist add-to-wishlist"
                                                            href="#"
                                                            title="Add to Wishlist"><i
                                                                class="icon anm anm-heart-l"
                                                                aria-hidden="true"></i>
                                                            <span>Add to
                                                                Wishlist</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--End-product-single-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end product button -->
    </div>
    <!-- end product image -->

    <!--start product details -->
    <div class="product-details text-center">
        <!-- product name -->
        <div class="product-name">
            <a
                href="{{ route('product', $items->slug) }}">{{ $items->name }}</a>
        </div>
        <!-- End product name -->
        <!-- product price -->
        <div class="product-price">
            <span class="old-price">{{ $items->price }}</span>
            <span class="price">{{ $items->sale_price }}</span>
        </div>
        <!-- End product price -->

        <div class="product-review">
            <i class="font-13 fa fa-star"></i>
            <i class="font-13 fa fa-star"></i>
            <i class="font-13 fa fa-star"></i>
            <i class="font-13 fa fa-star-o"></i>
            <i class="font-13 fa fa-star-o"></i>
        </div>

    </div>
    <!-- End product details -->
</div>