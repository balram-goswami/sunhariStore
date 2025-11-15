<style>
    .order-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
    }

    .order-title {
        font-weight: 700;
        font-size: 28px;
        color: #222;
    }

    .details-box {
        background: #f1f5f9;
        padding: 18px;
        border-radius: 12px;
        margin-top: 15px;
        border-left: 4px solid #007bff;
    }

    .address-card {
        background: #f8f9fa;
        padding: 18px;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        height: 100%;
    }

    .address-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .table-modern {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.05);
    }

    .table-modern thead {
        background: #007bff;
        color: white;
    }

    .badge-status {
        background: #28a745;
        padding: 8px 16px;
        border-radius: 25px;
        color: white;
        font-size: 14px;
    }

    .summary-box {
        background: #e9f4ff;
        padding: 25px;
        border-radius: 15px;
        font-size: 18px;
        border: 1px solid #cfe3ff;
        box-shadow: 0 2px 12px rgba(0, 123, 255, 0.15);
    }
</style>


<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="order-title">Order Details #{{ $order->id }}</h2>

        <a href="{{ route('order.invoice', $order->id) }}" class="btn btn-primary btn-lg">
            <i class="bi bi-download"></i> Download Invoice
        </a>
    </div>

    <!-- Order Status -->
    <div class="mb-3">
        <span class="badge-status">Order Placed</span>
    </div>

    <!-- Customer Info -->
    <div class="order-card">
        <h4 class="mb-3">Customer Details</h4>

        <div class="details-box mb-4">
            <strong>{{ $order->customer->name }}</strong> <br>
            {{ $order->customer->email }} <br>
            {{ $order->customer->phone ?? '' }}
        </div>

        <!-- Address Section -->
        @php
            $bill = $order->billing;
            $ship = $order->shipping;

            // check address equality
            $isSame = (
                $bill->line1 == $ship->line1 &&
                $bill->line2 == $ship->line2 &&
                $bill->city == $ship->city &&
                $bill->state == $ship->state &&
                $bill->postal_code == $ship->postal_code &&
                $bill->country == $ship->country &&
                $bill->phone == $ship->phone
            );
        @endphp

        <h4 class="mb-3">Address</h4>

        @if($isSame)
            <!-- SAME ADDRESS -->
            <div class="address-card">
                <div class="address-title">Billing & Shipping Address</div>
                <p>
                    {{ $bill->fname }} {{ $bill->lname }} <br>
                    {{ $bill->line1 }} <br>
                    {{ $bill->line2 }} <br>
                    {{ $bill->city }}, {{ $bill->state }} <br>
                    {{ $bill->postal_code }} <br>
                    {{ $bill->country }} <br>
                    Phone: {{ $bill->phone }}
                </p>
            </div>
        @else
            <!-- DIFFERENT ADDRESSES -->
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="address-card">
                        <div class="address-title">Billing Address</div>
                        <p>
                            {{ $bill->fname }} {{ $bill->lname }} <br>
                            {{ $bill->line1 }} <br>
                            {{ $bill->line2 }} <br>
                            {{ $bill->city }}, {{ $bill->state }} <br>
                            {{ $bill->postal_code }} <br>
                            {{ $bill->country }} <br>
                            Phone: {{ $bill->phone }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="address-card">
                        <div class="address-title">Shipping Address</div>
                        <p>
                            {{ $ship->fname }} {{ $ship->lname }} <br>
                            {{ $ship->line1 }} <br>
                            {{ $ship->line2 }} <br>
                            {{ $ship->city }}, {{ $ship->state }} <br>
                            {{ $ship->postal_code }} <br>
                            {{ $ship->country }} <br>
                            Phone: {{ $ship->phone }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <!-- Order Items -->
    <div class="order-card">
        <h4>Products</h4>

        <div class="table-modern mt-3">
            <table class="table table-bordered text-center mb-0">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price (₹)</th>
                        <th>Total (₹)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($order->products as $item)
                    <tr>
                        <td class="text-start">{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ number_format($item->price, 2) }}</td>
                        <td>{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Summary -->
    <div class="summary-box text-end mt-4">
        <h4>Subtotal: ₹{{ number_format($order->net_sub_total, 2) }}</h4>
        <h4>Shipping: ₹{{ number_format($order->net_shipping_amount, 2) }}</h4>
        <hr>
        <h3><strong>Total: ₹{{ number_format($order->net_total, 2) }}</strong></h3>
    </div>

</div>
