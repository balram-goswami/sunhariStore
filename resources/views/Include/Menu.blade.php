<div class="top-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 col-sm-8 col-md-5 col-lg-4">
                <!-- <div class="currency-picker">
                    <span class="selected-currency">USD</span>
                    <ul id="currencies">
                        <li data-currency="INR" class="">INR</li>
                        <li data-currency="GBP" class="">GBP</li>
                        <li data-currency="CAD" class="">CAD</li>
                        <li data-currency="USD" class="selected">USD</li>
                        <li data-currency="AUD" class="">AUD</li>
                        <li data-currency="EUR" class="">EUR</li>
                        <li data-currency="JPY" class="">JPY</li>
                    </ul>
                </div>
                <div class="language-dropdown">
                    <span class="language-dd">English</span>
                    <ul id="language">
                        <li class="">German</li>
                        <li class="">French</li>
                    </ul>
                </div>  -->
                <p class="phone-no"><i class="anm anm-phone-s"></i><a href="tel:{{ $data->phone ?? '' }}">
                        {{ $data->phone ?? '' }}</a></p>
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 d-none d-lg-none d-md-block d-lg-block">
                <div class="text-center">
                    <p class="top-header_middle-text"> Worldwide Express Shipping</p>
                </div>
            </div>
            <div class="col-2 col-sm-4 col-md-3 col-lg-4 text-right">
                <span class="user-menu d-block d-lg-none"><i class="anm anm-user-al" aria-hidden="true"></i></span>
                <ul class="customer-links list-inline">
                    <ul class="customer-links list-inline">
                        @auth
                        @if(auth()->user()->isAdmin())
                        <li><a href="{{ url('/admin/admin-dashboard') }}">Admin Dashboard</a></li>
                        @elseif(auth()->user()->isManager())
                        <li><a href="{{ url('/admin/dashboard') }}">Manager Dashboard</a></li>
                        @elseif(auth()->user()->isUser())
                        <li><a href="">My Profile</a></li>
                        @endif
                        @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Create Account</a></li>
                        @endauth
                    </ul>

                </ul>
            </div>
        </div>
    </div>
</div>

@if (request()->is('/'))
<div class="header-wrap classicHeader animated d-flex">
    @else
    <div class="header-wrap animated d-flex border-bottom">
        @endif
        <div class="container-fluid" style="background-color: #dcdcdc73">
            <div class="row align-items-center">
                <!--Desktop Logo-->
                <div class="logo col-md-2 col-lg-2 d-none d-lg-block">
                    <a href="{{ route('homePage') }}">
                        <img src="{{ $data && $data->logo ? asset('storage/' . $data->logo) : asset('assets/img/icons/1.png') }}"
                            height="90px" alt="{{ $data->tagline ?? '' }}" title="{{ $data->tagline ?? '' }}" />
                    </a>
                </div>
                <!--End Desktop Logo-->
                <div class="col-2 col-sm-3 col-md-3 col-lg-8">
                    <div class="d-block d-lg-none">
                        <button type="button" class="btn--link site-header__menu js-mobile-nav-toggle mobile-nav--open">
                            <i class="icon anm anm-times-l"></i>
                            <i class="anm anm-bars-r"></i>
                        </button>
                    </div>
                    <!--Desktop Menu-->
                    <nav class="grid__item" id="AccessibleNav"><!-- for mobile -->

                        <ul id="siteNav" class="site-nav medium center hidearrow">
                            <li class="lvl1 parent megamenu"><a href="{{ route('homePage') }}">Home<i
                                        class="anm anm-angle-down-l"></i></a>
                            </li>
                            <li class="lvl1 parent megamenu"><a href="{{ route('products') }}">Shop<i
                                        class="anm anm-angle-down-l"></i></a>
                            </li>
                            <li class="lvl1 parent megamenu"><a href="{{ route('contuct-us') }}">Contact Us<i
                                        class="anm anm-angle-down-l"></i></a>
                            </li>
                            <li class="lvl1 parent megamenu"><a href="{{ route('about-us') }}">About Us<i
                                        class="anm anm-angle-down-l"></i></a>
                            </li>
                        </ul>
                    </nav>
                    <!--End Desktop Menu-->
                </div>
                <!--Mobile Logo-->
                <div class="col-6 col-sm-6 col-md-6 col-lg-2 d-block d-lg-none mobile-logo">
                    <div class="logo">
                        <a href="{{ route('homePage') }}">
                            <img src="{{ $data && $data->logo ? asset('storage/' . $data->logo) : asset('assets/img/icons/1.png') }}" width="90px"
                                alt="{{ $data->tagline ?? '' }}" title="{{ $data->tagline ?? '' }}" />
                        </a>
                    </div>
                </div>
                <!--Mobile Logo-->
                <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                    <div class="site-cart">
                        <a href="#;" class="site-header__cart" title="Cart">
                            <i class="icon anm anm-bag-l"></i>
                            <span id="CartCount" class="site-header__cart-count" data-cart-render="item_count">2</span>
                        </a>
                        <!--Minicart Popup-->
                        <div id="header-cart" class="block block-cart">
                            <ul class="mini-products-list">

                                <li class="item">
                                    <a class="product-image" href="#">
                                        <img src="themeAssets/images/product-images/cape-dress-1.jpg"
                                            alt="3/4 Sleeve Kimono Dress" title="" />
                                    </a>
                                    <div class="product-details">
                                        <a href="#" class="remove"><i class="anm anm-times-l"
                                                aria-hidden="true"></i></a>
                                        <a href="#" class="edit-i remove"><i class="anm anm-edit"
                                                aria-hidden="true"></i></a>
                                        <a class="pName" href="cart.html">Sleeve Kimono Dress</a>
                                        <div class="variant-cart">Black / XL</div>
                                        <div class="wrapQtyBtn">
                                            <div class="qtyField">
                                                <span class="label">Qty:</span>
                                                <a class="qtyBtn minus" href="javascript:void(0);"><i
                                                        class="fa anm anm-minus-r" aria-hidden="true"></i></a>
                                                <input type="text" id="Quantity" name="quantity" value="1"
                                                    class="product-form__input qty">
                                                <a class="qtyBtn plus" href="javascript:void(0);"><i
                                                        class="fa anm anm-plus-r" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <div class="priceRow">
                                            <div class="product-price">
                                                <span class="money">$59.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                            <div class="total">
                                <div class="total-in">
                                    <span class="label">Cart Subtotal:</span><span class="product-price"><span
                                            class="money">748.00</span></span>
                                </div>
                                <div class="buttonSet text-center">
                                    <a href="{{ route('cart.index') }}" class="btn btn-secondary btn--small">View Cart</a>
                                    <a href="{{ route('cart.checkout') }}" class="btn btn-secondary btn--small">Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="site-header__search">
                        <button type="button" class="search-trigger"><i class="icon anm anm-search-l"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Header-->
    <!--Mobile Menu-->
    <div class="mobile-nav-wrapper" role="navigation">
        <div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Close Menu</div>
        <ul id="MobileNav" class="mobile-nav">
            <li class="lvl1 parent megamenu"><a href="{{ route('homePage') }}">Home<i class="anm anm-plus-l"></i></a>
            </li>
            <li class="lvl1 parent megamenu">
                <a href="">Sub Menu <i class="anm anm-plus-l"></i></a>
            </li>

            <ul class="customer-links list-inline">
                @auth
                @if(auth()->user()->isAdmin())
                <li><a href="{{ url('/admin/admin-dashboard') }}">Admin Dashboard</a></li>
                @elseif(auth()->user()->isManager())
                <li><a href="{{ url('/admin/dashboard') }}">Manager Dashboard</a></li>
                @elseif(auth()->user()->isUser())
                <li><a href="">My Profile</a></li>
                @endif
                @else
                <li><a href="{{ route('login') }}">Login</a></li>
                <li><a href="{{ route('register') }}">Create Account</a></li>
                @endauth
            </ul>
        </ul>
    </div>
    <!--End Mobile Menu-->