<div class="container py-5">

    <div class="alert alert-success text-center">
        <h2>🎉 Your Order is Successfully Completed!</h2>
        <p>Thank you for your purchase.</p>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h4>Order Summary</h4>
        </div>
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Order Total:</strong> ₹{{ number_format($order->net_total, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $order->payment_type }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h4>Your Login Information</h4>
        </div>
        <div class="card-body">
            <p>Your account has been created automatically.</p>
            <p><strong>Email (Username):</strong> {{ $customer->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>

            <p class="text-muted">Use these credentials to login to your account.</p>

            <a href="{{ route('login') }}" class="btn btn-success">Login Now</a>
        </div>
    </div>
</div>