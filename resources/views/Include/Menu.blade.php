@php
$showTotal = Cart::instance('shopping')->total();
$cart = Cart::instance('shopping')->content();
$count = Cart::instance('shopping')->count();
@endphp

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
                    <p class="top-header_middle-text"> All India Delivery Available </p>
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
                        <li><a href="{{ route('profile') }}">My Profile</a></li>
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
        <div class="container-fluid" style="background-color: #000000ff">
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
                @include('components.cart-offcanvas')
            </div>
        </div>
    </div>
    <!--End Header-->
    <!--Mobile Menu-->
    <div class="mobile-nav-wrapper" role="navigation">
        <div class="closemobileMenu"><i class="icon anm anm-times-l pull-right"></i> Close Menu</div>
        <ul id="MobileNav" class="mobile-nav">

            <ul class="customer-links list-inline">
                <li><a href="{{ route('homePage') }}">Home</a></li>
                <li><a href="{{ route('contuct-us') }}">Contact Us</a></li>
                <li><a href="{{ route('about-us') }}">About Us</a></li>
                <li><a href="{{ route('products') }}">Shop</a></li>
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