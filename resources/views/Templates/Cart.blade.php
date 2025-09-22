<div id="page-content">
    <!--Page Title-->
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
                        @foreach($cartItems as $items)
                        <tr class="cart__row border-bottom line1 cart-flex border-top">
                            <td class="cart__image-wrapper cart-flex-item">
                                <a href="#"><img class="cart__image"
                                        src="assets/images/product-images/product-image1.jpg"
                                        alt="Elastic Waist Dress - Navy / Small"></a>
                            </td>
                            <td class="cart__meta small--text-left cart-flex-item">
                                <div class="list-view-item__title">
                                    <a href="#">{{$items->name}} </a>
                                </div>

                                <div class="cart__meta-text">
                                    Color: Navy<br>Size: Small<br>
                                </div>
                            </td>
                            <td class="cart__price-wrapper cart-flex-item">
                                <span class="money">Rs {{$items->price}}</span>
                            </td>
                            <td class="cart__update-wrapper cart-flex-item text-right">
                                <div class="cart__qty text-center">
                                    <div class="qtyField">
                                        <a class="qtyBtn minus" href="javascript:void(0);"><i
                                                class="icon icon-minus"></i></a>
                                        <input class="cart__qty-input qty" type="text" name="updates[]"
                                            id="qty" value="{{$items->qty ?? 1}}" pattern="[0-9]*">
                                        <a class="qtyBtn plus" href="javascript:void(0);"><i
                                                class="icon icon-plus"></i></a>
                                    </div>
                                </div>
                            </td>
                            <td class="text-right small--hide cart-price">
                                <div><span class="money">Rs {{$items->price * $items->qty}}</span></div>
                            </td>
                            <td class="text-center small--hide"><a href="#"
                                    class="btn btn--secondary cart__remove" title="Remove tem"><i
                                        class="icon icon anm anm-times-l"></i></a></td>
                        </tr>
                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-left"><a href="http://annimexweb.com/"
                                    class="btn--link cart-continue"><i class="icon icon-arrow-circle-left"></i>
                                    Continue shopping</a></td>
                            <td colspan="3" class="text-right"><button type="submit" name="update"
                                    class="btn--link cart-update"><i class="fa fa-refresh"></i> Update</button>
                            </td>
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
</div>

</div>