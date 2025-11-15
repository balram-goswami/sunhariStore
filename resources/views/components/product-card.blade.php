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
    @if ($items->qty > 0)
        @if($items->has_variants)
            <div class="variants add">
                <a href="{{ route('product', $items->slug) }}" class="btn"
                    style="letter-spacing: 0;">Select Options</a>
            </div>
            @else
            <!-- <div class="variants add">
                <button class="btn add-to-cart"
                    data-product-id="{{ $items->id }}"
                    data-variant-id="null"
                    data-qty="1"
                    data-product="{{ json_encode([
                                'id' => $items->id,
                                'variant_id' => null,
                            ]) }}" 
                    style="letter-spacing: 0;">
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
            @include('Model.WAButton')
        @endif
        @else
        <div class="variants add">
            <button class="btn">
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