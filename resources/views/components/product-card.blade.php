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
            <span class="lbl on-sale">- {{ round($percent) }}%</span>
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
    <!-- <div class="variants add">
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
        </div> -->

    <div class="variants add">
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
        @for($i = 1; $i <= 5; $i++)
            <i class="font-13 fa {{ $i <= $items->rating ? 'fa-star text-warning' : 'fa-star-o' }}"></i>
            @endfor
    </div>
</div>
</div>