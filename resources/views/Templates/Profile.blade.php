<style>
    .user-profile-page * {
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    .user-profile-page {
        display: flex;
        flex-direction: row;
        min-height: 100vh;
        background-color: #f4f6f8;
    }

    .user-profile-page .sidebar {
        width: 250px;
        background-color: #dbdbdb;
        color: #000;
        padding: 20px;
        flex-shrink: 0;
    }

    .user-profile-page .sidebar h2 {
        margin-bottom: 20px;
        font-size: 1.5rem;
        text-align: center;
    }

    .user-profile-page .menu {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .user-profile-page .menu li {
        padding: 12px 15px;
        margin-bottom: 10px;
        background-color: #434a55;
        color: white;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
        font-size: 1rem;
    }

    .user-profile-page .menu li:hover {
        background-color: #475569;
    }

    .user-profile-page .content {
        flex: 1;
        padding: 30px;
        overflow-x: hidden;
    }

    .user-profile-page .content h1 {
        margin-bottom: 20px;
        font-size: 1.75rem;
    }

    .user-profile-page .card {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .user-profile-page .user-section {
        display: none;
    }

    .user-profile-page .user-section.active {
        display: block;
    }

    /* Wishlist table styles */
    .wishlist-table-container {
        overflow-x: auto;
    }

    .wishlist-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .wishlist-table th,
    .wishlist-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .wishlist-table th {
        background-color: #dbdbdb;
        color: #000;
        font-weight: 600;
    }

    .wishlist-table td img {
        max-width: 50px;
        border-radius: 4px;
    }

    .wishlist-table button {
        padding: 6px 10px;
        background-color: #434a55;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    /* Responsive layout */
    @media (max-width: 1024px) {
        .user-profile-page {
            flex-direction: column;
        }

        .user-profile-page .sidebar {
            width: 100%;
            padding: 15px;
        }

        .user-profile-page .content {
            padding: 20px;
        }

        .user-profile-page .menu li {
            font-size: 0.95rem;
        }

        .user-profile-page .content h1 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 600px) {
        .user-profile-page .sidebar h2 {
            font-size: 1.25rem;
        }

        .user-profile-page .menu li {
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        .user-profile-page .card {
            padding: 15px;
        }

        .user-profile-page .content h1 {
            font-size: 1.25rem;
        }
    }
</style>
<style>
    .credit-card {
        position: relative;
        background: linear-gradient(135deg, rgb(78, 176, 200), #8f94fb);
        border-radius: 16px;
        height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-family: 'Inter', sans-serif;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        transition: transform 0.3s ease;
        overflow: hidden;
    }

    .credit-card:hover {
        transform: scale(1.02);
    }

    .card-chip {
        width: 40px;
        height: 30px;
        background-color: #d4d4d4;
        border-radius: 4px;
    }

    .card-number {
        letter-spacing: 2px;
    }

    .card-holder-name {
        font-size: 0.9rem;
        font-weight: 600;
    }

    .card-expiry {
        font-size: 0.85rem;
        opacity: 0.85;
    }

    .delete-btn-wrapper {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 10;
    }

    .delete-btn-wrapper form {
        margin: 0;
    }

    .delete-btn-wrapper button {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="user-profile-page">
    <div class="sidebar">
        <h2>👋 Hello, {{ $userData->name }}</h2>
        <ul class="menu">
            <li onclick="showUserSection('orders')">Orders</li>
            <li onclick="showUserSection('profile')">Profile</li>
            <li onclick="showUserSection('cards')">Cards</li>
            <li onclick="showUserSection('address')">Addresses</li>
            <li onclick="showUserSection('tickets')">Tickets</li>
            <li onclick="showUserSection('cart')">Cart</li>
            <li onclick="showUserSection('wishlist')">Wishlist</li>
            <li onclick="showUserSection('logout')">Logout</li>
        </ul>
    </div>

    <div class="content">
        <div id="profile" class="card user-section active">
            <h1>Profile</h1>

            <div class="row g-4">
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Orders</h5>
                            <p class="display-6 fw-semibold text-primary">{{ count($customerOrders->orders) }}</p>
                            <a href="javascript:void(0)" onclick="showUserSection('orders')"
                                class="btn btn-sm btn-outline-primary">View Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Cart Items</h5>
                            <p class="display-6 fw-semibold text-success">{{ count($cart) }}</p>
                            <a href="javascript:void(0)" onclick="showUserSection('cart')"
                                class="btn btn-sm btn-outline-success">View Cart</a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Addresses</h5>
                            <p class="display-6 fw-semibold text-warning">{{ count($address) }}</p>
                            <a href="javascript:void(0)" onclick="showUserSection('address')"
                                class="btn btn-sm btn-outline-warning">View Addresses</a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Saved Cards</h5>
                            <p class="display-6 fw-semibold text-danger">{{ count($cards) }}</p>
                            <a href="javascript:void(0)" onclick="showUserSection('cards')"
                                class="btn btn-sm btn-outline-danger">View Cards</a>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 text-center">
                        <div class="card-body">
                            <h5 class="card-title">Wishlist Items</h5>
                            <p class="display-6 fw-semibold text-success">{{ count($wishlistItems) }}</p>
                            <a href="javascript:void(0)" onclick="showUserSection('wishlist')"
                                class="btn btn-sm btn-outline-success">View Wishlist</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="orders" class="card user-section">
            <h1>Orders</h1>
            <div class="wishlist-table-container">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customerOrders->orders as $order)
                            @foreach ($order->products as $product)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ dateOnly($product->created_at) }}</td>
                                    <td>${{ number_format($product->total, 2) }}</td>
                                    <td><button class="btn btn-sm btn-outline-primary"
                                            onclick="loadOrderBill({{ $order->id }})">
                                            View Bill
                                        </button></td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        <div id="bill" class="card user-section">
            <h1>Order Bill Details</h1>

        </div>

        <div id="cart" class="card user-section">
            <h1>Cart</h1>
            <div class="wishlist-table-container">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>SKU</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $cartItems)
                            @php
                                $cartimage = adminImageUrl($cartItems->image);
                            @endphp
                            <tr>
                                <td><img src="{{ $cartimage }}" alt="Product 1"></td>
                                <td>{{ $cartItems->name }}</td>
                                <td>{{ $cartItems->price }}</td>
                                <td>{{ $cartItems->sku }}</td>
                                <td>
                                    <button class="btn btn-danger btn-sm delete-cart-item"
                                        data-id="{{ $cartItems->id }}">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="wishlist" class="card user-section">
            <h1>Wishlist</h1>
            <div class="wishlist-table-container">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>SKU</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wishlistItems as $item)
                            @php
                                $wishlistimage = adminImageUrl($item->image);
                            @endphp
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->product->price }}</td>
                                <td>{{ $item->product->sku }}</td>
                                <td>
                                    <button class="remove-wishlist-btn" data-product-id="{{ $item->product_id }}">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="tickets" class="card user-section">
            <h1>Tickets</h1>
            <div class="wishlist-table-container">
                <table class="wishlist-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Response</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    @php
                        $statusLabels = [
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'resolved' => 'Resolved',
                            'closed' => 'Closed',
                        ];
                    @endphp
                    <tbody>
                        @foreach ($tickets as $item)
                            <tr>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->message }}</td>
                                <td>{{ $item->response ?? 'NA' }} </td>
                                <td>{{ $statusLabels[$item->status] ?? ucfirst($item->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="address" class="card user-section p-4 bg-white rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Addresses</h2>
                <a onclick="showUserSection('addAddress')" class="btn btn-sm btn-outline-success">+ Add Address</a>
            </div>

            @forelse ($address as $add)
                <div class="card mb-3 border p-3 shadow-sm">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-2">{{ $add->type }}</h5>
                            @if ($add->is_default)
                                <span class="badge bg-success">Default</span>
                            @endif
                        </div>
                        <form method="POST" action="{{ route('deleteAddress', $add->id) }}"
                            onsubmit="return confirm('Are you sure you want to delete this address?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                    <p><strong>Name:</strong> {{ $add->fname }} {{ $add->lname }}</p>
                    <p><strong>Phone:</strong> {{ $add->phone }}</p>
                    <p><strong>Address:</strong> {{ $add->line1 }}, {{ $add->line2 }}</p>
                    <p><strong>Location:</strong> {{ $add->city }}, {{ $add->state }}, {{ $add->country }}</p>
                    <p><strong>Postal Code:</strong> {{ $add->postal_code }}</p>
                </div>
            @empty
                <p class="text-muted">No addresses found.</p>
            @endforelse
        </div>

        <div id="addAddress" class="card user-section p-4 bg-white rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Addresses</h2>
                <a onclick="showUserSection('address')" class="btn btn-sm btn-outline-success">Cancel</a>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="contact__form">
                        @if (session('success'))
                            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('addAddress') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="type"
                                        placeholder="Address Type (e.g. Home, Office)" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="name" placeholder="Full Name" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="phone" placeholder="Phone Number">
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="line1" placeholder="Address Line 1" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="line2" placeholder="Address Line 2" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="city" placeholder="City" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="state" placeholder="State" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="postal_code" placeholder="Postal Code" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <input type="text" name="country" placeholder="Country" required>
                                </div>

                                <div class="col-lg-6 mb-3">
                                    <label>
                                        <input type="checkbox" name="is_default" value="1"> Set as default
                                        address
                                    </label>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="site-btn">Save Address</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>

        <div id="savedCards" class="card user-section p-4 bg-white rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">💳 Saved Payment Cards</h2>
                <a onclick="showUserSection('addCard')" class="btn btn-sm btn-outline-success">+ Add Card</a>
            </div>

            @if (session('card_success'))
                <div class="alert alert-success mb-4">{{ session('card_success') }}</div>
            @endif

            <div class="row">
                @forelse ($cards as $card)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="credit-card p-4 text-white bg-primary rounded shadow-sm position-relative">
                            <!-- Delete Button -->
                            <form method="POST" action="{{ route('deleteCard', $card->id) }}"
                                class="position-absolute top-2 end-2" onsubmit="return confirm('Delete this card?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle"
                                    title="Delete Card">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>

                            <!-- Card Number (masked) -->
                            <div class="card-number fs-5 mb-2">
                                **** **** **** {{ substr($card->card_number, -4) }}
                            </div>

                            <!-- Cardholder Name and Expiry -->
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-holder-name text-uppercase">{{ $card->card_name }}</div>
                                    <div class="card-expiry">Exp: {{ $card->exp_date }}</div>
                                </div>
                                <div class="text-end">
                                    <small class="text-light">{{ ucfirst($card->card_id) }}</small>
                                    <i class="bi bi-credit-card fs-4 d-block"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No saved cards found.</p>
                @endforelse
            </div>
        </div>




        <div id="cards" class="card user-section p-4 bg-white rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="h4 mb-2 mb-md-0">💳 Saved Cards</h2>
                <a onclick="showUserSection('addCard')" class="btn btn-sm btn-outline-success">+ Add Card</a>
            </div>

            <div class="row">
                @forelse ($cards as $card)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="credit-card p-4 text-white position-relative rounded shadow"
                            style="background: linear-gradient(135deg, #3a6186, #89253e);">

                            <!-- Delete Button -->
                            <form method="POST" action="{{ route('deleteCard', $card->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this card?');"
                                class="position-absolute top-0 end-0 m-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger rounded-circle shadow-sm">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>

                            <!-- Card Details -->
                            <div class="card-chip mb-3"
                                style="width: 40px; height: 30px; background-color: rgba(255,255,255,0.3); border-radius: 4px;">
                            </div>

                            <div class="card-number fs-5 mb-3">
                                **** **** **** {{ substr($card->card_number ?? 'XXXX', -4) }}
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="card-holder-name text-uppercase fw-bold">{{ $card->card_name }}</div>
                                    <div class="card-expiry small">Exp: {{ $card->exp_date ?? 'N/A' }}</div>
                                </div>
                                <div class="text-end">
                                    <small class="text-light">{{ ucfirst($card->card_id) }}</small>
                                    <i class="bi bi-credit-card fs-4 d-block"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No saved cards.</p>
                    </div>
                @endforelse
            </div>
        </div>


        {{-- This Section Hidden Only Show when to add cards --}}
        <div id="addCard" class="card user-section p-4 bg-white rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="h4 mb-2 mb-md-0">💳 Add New Cards</h2>
                <a onclick="showUserSection('cards')" class="btn btn-sm btn-outline-success">Cancel</a>
            </div>
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <script src="https://js.stripe.com/v3/"></script>

                        <div class="card shadow-lg">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Add New Payment Card</h5>
                            </div>
                            <div class="card-body">
                                <form id="card-form">
                                    <div class="mb-3">
                                        <label for="card_name" class="form-label">Name on Card</label>
                                        <input type="text" class="form-control" id="card_name" name="card_name"
                                            placeholder="e.g. John Doe" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="card-element" class="form-label">Card Details</label>
                                        <div class="form-control" id="card-element" style="height: 45px;"></div>
                                        <div id="card-errors" class="text-danger mt-2" role="alert"></div>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100">Save Card</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const stripe = Stripe('{{ config('services.stripe.key') }}');
                const elements = stripe.elements();
                const cardElement = elements.create('card', {
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#495057',
                            '::placeholder': {
                                color: '#6c757d',
                            },
                        },
                        invalid: {
                            color: '#dc3545',
                        }
                    }
                });

                cardElement.mount('#card-element');

                const cardForm = document.getElementById('card-form');
                const cardErrors = document.getElementById('card-errors');

                cardForm.addEventListener('submit', async (e) => {
                    e.preventDefault();

                    const {
                        token,
                        error
                    } = await stripe.createToken(cardElement);

                    if (error) {
                        cardErrors.textContent = error.message;
                    } else {
                        cardErrors.textContent = '';
                        const formData = new FormData();
                        formData.append('card_name', document.getElementById('card_name').value);
                        formData.append('card_id', token.id);

                        fetch('{{ route('addCards') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                },
                                body: formData,
                            })
                            .then(res => res.json())
                            .then(data => {
                                alert(data.message);
                                location.reload();
                            })
                            .catch(() => {
                                alert('Failed to save card. Please try again.');
                            });
                    }
                });
            </script>
        </div>



        <div id="logout" class="card user-section border-0 shadow-sm p-4 bg-danger text-white">
            <div class="text-center">
                <h1 class="h4 mb-3">
                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                </h1>
                <p>See you again soon!</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-light fw-semibold">
                        👋 Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function showUserSection(id) {
        const sections = document.querySelectorAll('.user-section');
        sections.forEach(section => section.classList.remove('active'));
        const selected = document.getElementById(id);
        if (selected) selected.classList.add('active');
    }
</script>

<script>
    $(document).ready(function() {
        $('.remove-wishlist-btn').on('click', function() {
            const button = $(this);
            const productId = button.data('product-id');

            $.ajax({
                url: '{{ route('wishlist.remove') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    product_id: productId
                },

                success: function(response) {
                    // Remove the table row
                    button.closest('tr').remove();

                    // Optional: show toast or alert
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Failed to remove item.');
                }
            });
        });
    });
</script>
<script>
    $(document).on('click', '.delete-cart-item', function() {
        let button = $(this);
        let cartItemId = button.data('id');

        $.ajax({
            url: '/cart/' + cartItemId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Remove the row from the table
                    button.closest('tr').fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            },
            error: function(xhr) {
                alert('Error removing item from cart.');
            }
        });
    });
</script>

<script>
    function loadOrderBill(orderId) {
        fetch(`/customer/orders/${orderId}/bill`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('bill').innerHTML = html;
                showUserSection('bill'); // Show the bill tab
            })
            .catch(error => {
                alert('Failed to load bill: ' + error);
            });
    }
</script>
