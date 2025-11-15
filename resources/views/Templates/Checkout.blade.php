<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Checkout</h1>
            </div>
        </div>
    </div>
    <!--End Page Title-->

    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                @if(auth()->check() &&
                (auth()->user()->isUser() || auth()->user()->isAdmin() || auth()->user()->isManager()))
                <div class="customer-box returning-customer">
                    <h3><i class="icon anm anm-user-al"></i> Hi {{ auth()->user()->name }}</h3>
                </div>
                @else
                <div class="customer-box returning-customer">
                    <h3><i class="icon anm anm-user-al"></i> Returning customer? <a href="#customer-login" id="customer" class="text-white text-decoration-underline" data-toggle="collapse">Click here to login</a></h3>
                    <div id="customer-login" class="collapse customer-content">
                        <div class="customer-info">
                            <p class="coupon-text">If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed to the Billing &amp; Shipping section.</p>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label for="email">Email address <span class="required-f">*</span></label>
                                        <input type="email" name="email" class="no-margin">
                                    </div>
                                    <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                        <label for="password">Password <span class="required-f">*</span></label>
                                        <input type="password" name="password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check width-100 margin-20px-bottom">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" value=""> Remember me!
                                            </label>
                                            <a href="#" class="float-right">Forgot your password?</a>
                                        </div>
                                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-3">
                <div class="customer-box customer-coupon">
                    <h3 class="font-15 xs-font-13"><i class="icon anm anm-gift-l"></i> Have a coupon? <a href="#have-coupon" class="text-white text-decoration-underline" data-toggle="collapse">Click here to enter your code</a></h3>
                    <div id="have-coupon" class="collapse coupon-checkout-content">
                        <div class="discount-coupon">
                            <div id="coupon" class="coupon-dec tab-pane active">
                                <p class="margin-10px-bottom">Enter your coupon code if you have one.</p>
                                <label class="required get" for="coupon-code"><span class="required-f">*</span> Coupon</label>
                                <input id="coupon-code" required="" type="text" class="mb-3">
                                <button class="coupon-btn btn" type="submit">Apply Coupon</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row billing-fields">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 sm-margin-30px-bottom">
                <div class="create-ac-content bg-light-gray padding-20px-all">
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        @if(auth()->check() &&
                        (auth()->user()->isUser() || auth()->user()->isAdmin() || auth()->user()->isManager()))
                        <h2 class="login-title mb-3">Select Address</h2>
                        <div class="row">
                            @forelse($address as $addr)
                            <style>
                                .address-card {
                                    cursor: pointer;
                                }

                                .address-card .card {
                                    transition: all 0.25s ease-in-out;
                                    border: 1px solid #ddd !important;
                                    background: #ffffff;
                                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
                                    min-height: 180px;
                                }

                                .address-card:hover .card {
                                    transform: translateY(-5px);
                                    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
                                    border-color: #007bff !important;
                                }

                                .address-card input[type="radio"] {
                                    display: none;
                                }

                                .address-card input[type="radio"]:checked+.card {
                                    border: 2px solid #007bff !important;
                                    background: #e9f5ff;
                                    box-shadow: 0 6px 18px rgba(0, 123, 255, 0.30);
                                }

                                .address-type-badge {
                                    display: inline-block;
                                    padding: 3px 8px;
                                    font-size: 12px;
                                    border-radius: 6px;
                                    background: #007bff;
                                    color: #fff;
                                    margin-bottom: 8px;
                                }

                                @media(max-width: 768px) {
                                    .address-card .card {
                                        min-height: auto;
                                    }
                                }
                            </style>

                            <div class="col-md-6 col-sm-12 mb-3">
                                <label class="address-card w-100">
                                    <input type="radio" name="address_id" value="{{ $addr->id }}" required>

                                    <div class="card p-3 rounded">
                                        <span class="address-type-badge">{{ ucfirst($addr->type) }}</span><br>

                                        <strong>{{ $addr->fname }} {{ $addr->lname }}</strong><br>
                                        {{ $addr->line1 }}<br>
                                        @if($addr->line2) {{ $addr->line2 }}<br> @endif

                                        {{ $addr->city }}, {{ $addr->state }}<br>
                                        {{ $addr->postal_code }}<br>
                                        <small class="text-muted">{{ $addr->country }}</small>
                                    </div>
                                </label>
                            </div>

                            @empty
                            <p>No saved addresses found.</p>
                            @endforelse

                            <div class="col-md-12 mt-3">
                                <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addAddressModal">
                                    + Add New Address
                                </button>
                            </div>

                        </div>
                        </fieldset>

                        @else
                        <fieldset>
                            <h2 class="login-title mb-3">Billing details</h2>
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-fname">First Name <span class="required-f">*</span></label>
                                    <input name="fname" value="" id="input-fname" type="text">
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-lname">Last Name <span class="required-f">*</span></label>
                                    <input name="lname" value="" id="input-lname" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-email">E-Mail <span class="required-f">*</span></label>
                                    <input name="email" value="" id="input-email" type="email">
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label>Phone Number <span class="required-f">*</span></label>
                                    <input name="phone" value="" type="tel">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6">
                                    <label for="line1">Address Line 1</label>
                                    <input name="line1" value="" id="line1" type="text">
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="line2">Address Line 2 <span class="required-f">*</span></label>
                                    <input name="line2" value="" id="line2" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-city">City <span class="required-f">*</span></label>
                                    <input name="city" value="" id="input-city" type="text">
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label>State <span class="required-f">*</span></label>
                                    <input name="state" value="" type="text">
                                </div>
                                <!-- <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="input-zone">Region / State <span class="required-f">*</span></label>
                                    <select name="zone_id" id="input-zone">
                                        <option value=""> --- Please Select --- </option>
                                        <option value="3513">Aberdeen</option>
                                    </select>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label for="postal_code">Post Code <span class="required-f">*</span></label>
                                    <input name="postal_code" value="" id="postal_code" type="text">
                                </div>
                                <div class="form-group col-md-6 col-lg-6 col-xl-6 required">
                                    <label>Country <span class="required-f">*</span></label>
                                    <input name="country" value="" type="text">
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-xl-12">
                                    <label for="note">Order Notes <span class="required-f">*</span></label>
                                    <textarea name="note" class="form-control resize-both" rows="3"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        @endif
                </div>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="your-order-payment">
                    <div class="your-order">
                        <h2 class="order-title mb-4">Your Order</h2>

                        <div class="table-responsive-sm order-table">
                            <table class="bg-white table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th class="text-left">Product Name</th>
                                        <th></th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $items)
                                    <tr>
                                        <td class="text-left">{{$items->name}}</td>
                                        <td></td>
                                        <td>₹ {{ $items->price }}</td>
                                        <td>{{ $items->qty }}</td>
                                        <td>₹ {{ $items->qty*$items->price }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="font-weight-600">
                                    <tr>
                                        <td colspan="4" class="text-right">Total</td>
                                        <td>₹ {{$total}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <hr />

                    <div class="your-payment">
                        <h2 class="payment-title mb-3">Payment Method</h2>
                        <div class="payment-method">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="onlinePayment" value="online" required>
                                <label class="form-check-label" for="onlinePayment">
                                    Online Payment
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod" required>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery
                                </label>
                            </div>

                            <div class="order-button-payment">
                                <button class="btn" type="submit">Place Order</button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            </form>
        </div>
    </div>

</div>