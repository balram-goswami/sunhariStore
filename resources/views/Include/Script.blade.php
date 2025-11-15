<!-- Including Jquery -->
<script src="{{ publicPath('/themeAssets/js/vendor/jquery-3.3.1.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/vendor/jquery.cookie.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/vendor/wow.min.js') }}"></script>
<!-- Including Javascript -->
<script src="{{ publicPath('/themeAssets/js/bootstrap.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/plugins.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/popper.min.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/lazysizes.js') }}"></script>
<script src="{{ publicPath('/themeAssets/js/main.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script>
    window.csrfToken = "{{ csrf_token() }}";
    window.addToCartUrl = "{{ route('cart.add') }}";
    window.cartUpdateUrl = "{{ route('cart.updateQuantity') }}";
    window.cartRemoveUrl = "{{ route('cart.removeItem') }}";
    window.cartHeaderUrl = "{{ route('cart.header') }}";
    window.cart = "{{ route('cart') }}";
    window.checkout = "{{ route('cart.checkout') }}";
    window.storageUrl = "{{ asset('storage') }}/";
</script>

<script src="{{ asset('cart.js') }}"></script>
<script src="{{ asset('product-detail.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Add/Remove wishlist
        $(document).on('click', '.wishlist-toggle', function(e) {
            e.preventDefault();

            var productId = $(this).data('product-id');
            var rowId = $(this).data('row-id');
            var $btn = $(this);

            if (rowId) {
                // Remove from wishlist
                $.post("{{ route('wishlist.remove') }}", {
                    _token: "{{ csrf_token() }}",
                    rowId: rowId
                }, function(res) {
                    if (res.success) {
                        $btn.find("img").attr("src", "{{ publicPath('themeData/img/icon/heart.png') }}");
                        $btn.data("row-id", "");
                        Swal.fire({
                            icon: 'success',
                            title: 'Removed!',
                            text: 'Product removed from wishlist',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            } else {
                // Add to wishlist
                $.post("{{ route('wishlist.add') }}", {
                    _token: "{{ csrf_token() }}",
                    product_id: productId
                }, function(res) {
                    if (res.success) {
                        $btn.find("img").attr("src", "{{ publicPath('themeData/img/icon/redheart.png') }}");
                        $btn.data("row-id", res.rowId);
                        Swal.fire({
                            icon: 'success',
                            title: 'Added!',
                            text: 'Product added to wishlist',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });
</script>
