<div id="page-content">
    <!--Page Title-->
    @if($count > 0)
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Your cart</h1>
            </div>
        </div>
    </div>
    <!--End Page Title-->

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-8 col-lg-8 main-col">
                <table>
                    <thead class="cart__row cart__header">
                        <tr>
                            <th colspan="2" class="text-center">Product</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Total</th>
                            <th class="action">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                        <tr class="cart__row border-bottom line1 cart-flex border-top" data-row-id="{{ $item->rowId }}">
                            <td class="cart__image-wrapper cart-flex-item">
                                <img class="cart__image"
                                    src="{{ asset('storage/' . ($item->options->image ?? '/themeAssets/images/images.jpg')) }}"
                                    alt="{{ $item->name }}">
                            </td>
                            <td class="cart__meta small--text-left cart-flex-item">
                                <div class="list-view-item__title">
                                    <a href="#">{{ $item->name }}</a>
                                </div>
                                <div class="cart__meta-text">
                                    SKU: {{ $item->options->sku ?? 'N/A' }}
                                </div>
                            </td>
                            <!-- <td class="cart__price-wrapper cart-flex-item">
                                <span class="money">Rs {{ $item->price }}</span>
                            </td> -->
                            <td class="cart__update-wrapper cart-flex-item text-right">
                                <div class="cart__qty text-center">
                                    <!-- <div class="qtyField">
                                        <a class="qtyBtn minus" href="javascript:void(0);"><i class="icon icon-minus"></i></a>
                                        <input class="cart__qty-input qty" type="text" value="{{ $item->qty }}" data-row-id="{{ $item->rowId }}">
                                        <a class="qtyBtn plus" href="javascript:void(0);"><i class="icon icon-plus"></i></a>
                                    </div> -->
                                    <div class="qtyField">
                                        <input readonly type="number" value="{{ $item->qty }}">
                                    </div>

                                </div>
                            </td>
                            <td class="text-right small--hide cart-price">
                                <div><span class="money item-total">Rs {{ $item->price * $item->qty }}</span></div>
                            </td>
                            <td class="text-center small--hide">
                                <a href="#" class="btn btn--secondary cart__remove delete-cart-item" data-row-id="{{ $item->rowId }}" title="Remove item">
                                    <i class="icon anm anm-times-l"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-left"><a href="{{ route('products')}}"
                                    class="btn--link cart-continue"><i class="icon icon-arrow-circle-left"></i>
                                    Continue shopping</a></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-4 cart__footer">

                <div class="solid-border">
                    <div class="row">
                        <span class="col-12 col-sm-6 cart__subtotal-title"><strong>Subtotal</strong></span>
                        <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-right"><span
                                class="money">Rs - {{$subtotal}}</span></span>
                    </div>
                    <div class="row">
                        <span class="col-12 col-sm-6 cart__subtotal-title"><strong>Discount</strong></span>
                        <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-right"><span
                                class="money">Rs - 0</span></span>
                    </div>
                    <div class="row">
                        <span class="col-12 col-sm-6 cart__subtotal-title"><strong>Total</strong></span>
                        <span class="col-12 col-sm-6 cart__subtotal-title cart__subtotal text-right"><span
                                class="money">Rs - {{$total}}</span></span>
                    </div>
                    <div class="cart__shipping">Shipping &amp; taxes calculated at checkout</div>

                    <button type="button"
                        id="cartCheckout"
                        class="btn btn--small-wide checkout"
                        style="width: 100%;"
                        onclick="window.location.href='{{ route('cart.checkout') }}'">
                        Checkout
                    </button>

                </div>
            </div>

        </div>
    </div>
    @else
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">No Item in Your cart</h1>
            </div>
        </div>
    </div>
    @endif
</div>