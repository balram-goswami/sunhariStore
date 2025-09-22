<style>
    /* ========= User Dashboard Scoped Styles ========= */
    .user-dashboard {
        display: flex;
        min-height: 100vh;
        background: #f9fafb;
        font-family: "Inter", sans-serif;
    }

    /* Sidebar */
    .user-dashboard .sidebar {
        width: 260px;
        background: #111827;
        color: #fff;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        padding: 24px 0;
        border-right: 1px solid #1f2937;
        justify-content: space-between;
    }

    .user-dashboard .sidebar h2 {
        text-align: center;
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 24px;
        color: #f3f4f6;
    }

    .user-dashboard .sidebar nav {
        flex: 1;
    }

    .user-dashboard .sidebar a {
        display: block;
        padding: 14px 24px;
        color: #d1d5db;
        font-size: 15px;
        text-decoration: none;
        border-left: 4px solid transparent;
        transition: all 0.25s ease;
    }

    .user-dashboard .sidebar a:hover {
        background: #1f2937;
        color: #ffffff;
    }

    .user-dashboard .sidebar a.active {
        background: #1f2937;
        color: #10b981;
        border-left-color: #10b981;
        font-weight: 600;
    }

    .user-dashboard .sidebar .logout {
        margin-top: auto;
        color: #ef4444;
    }

    .user-dashboard .sidebar .logout:hover {
        background: #991b1b;
        color: #fff;
    }

    /* Content */
    .user-dashboard .content {
        flex-grow: 1;
        padding: 30px;
    }

    .user-dashboard .section {
        display: none;
        animation: fadeIn 0.35s ease-in-out;
    }

    .user-dashboard .section.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .user-dashboard .card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .user-dashboard .card h3 {
        font-size: 18px;
        margin-bottom: 16px;
        color: #111827;
    }

    .user-dashboard .card p,
    .user-dashboard .card li {
        font-size: 15px;
        color: #374151;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    /* Address Boxes */
    .address-grid {
        display: grid;
        gap: 16px;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }

    .address-box {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        transition: 0.3s;
    }

    .address-box:hover {
        border-color: #10b981;
        transform: translateY(-2px);
    }

    /* Credit Cards */
    .credit-card {
        width: 320px;
        height: 180px;
        border-radius: 16px;
        padding: 20px;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
        margin-bottom: 20px;
        font-family: "Courier New", monospace;
    }

    .credit-card .number {
        font-size: 20px;
        letter-spacing: 3px;
    }

    .credit-card .bottom {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
    }

    .credit-card.visa {
        background: linear-gradient(135deg, #2563eb, #1e3a8a);
    }

    .credit-card.mastercard {
        background: linear-gradient(135deg, #f97316, #b91c1c);
    }

    /* Responsive */
    @media (max-width: 900px) {
        .user-dashboard {
            flex-direction: column;
        }

        .user-dashboard .sidebar {
            width: 100%;
            flex-direction: row;
            padding: 0;
            overflow-x: auto;
        }

        .user-dashboard .sidebar h2 {
            display: none;
        }

        .user-dashboard .sidebar nav {
            display: flex;
        }

        .user-dashboard .sidebar a {
            flex: 1;
            text-align: center;
            padding: 16px;
            font-size: 14px;
            border-left: none;
            border-bottom: 3px solid transparent;
        }

        .user-dashboard .sidebar a.active {
            border-bottom-color: #10b981;
            border-left: none;
        }

        .credit-card {
            width: 100%;
            max-width: 100%;
        }
    }
</style>

<div class="user-dashboard">
    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <h2>My Account</h2>
            <nav>
                <a href="#" class="active" onclick="showSection(event, 'profile')">Profile</a>
                <a href="#" onclick="showSection(event, 'address')">Addresses</a>
                <a href="#" onclick="showSection(event, 'cards')">Cards</a>
                <a href="#" onclick="showSection(event, 'orders')">Orders</a>
                <a href="#" onclick="showSection(event, 'wishlist')">Wishlist</a>
            </nav>
        </div>
        <a href="{{ route('profile.destroy') }}" class="logout">Logout</a>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Profile -->
        <div id="profile" class="section active">
            <div class="card">
                <h3>Profile Information</h3>
                <p><strong>Name:</strong> {{$userData->name}}</p>
                <p><strong>Email:</strong> {{$userData->email}}</p>
                <p><strong>Phone:</strong> {{$userData->phone}}</p>
            </div>
        </div>

        <!-- Address -->
        <div id="address" class="section">
            <div class="card">
                <h3>Saved Addresses</h3>
                <div class="address-grid">
                    <div class="address-box">
                        <strong>Home</strong>
                        <p>123 Main Street, Mumbai, India</p>
                    </div>
                    <div class="address-box">
                        <strong>Office</strong>
                        <p>45 Park Avenue, Pune, India</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards -->
        <div id="cards" class="section">
            <div class="card">
                <h3>Saved Cards</h3>
                <div class="credit-card visa">
                    <div class="number">**** **** **** 1234</div>
                    <div class="bottom">
                        <span>JOHN DOE</span>
                        <span>12/27</span>
                    </div>
                </div>
                <div class="credit-card mastercard">
                    <div class="number">**** **** **** 5678</div>
                    <div class="bottom">
                        <span>JOHN DOE</span>
                        <span>08/25</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div id="orders" class="section">
            <div class="card">
                <h3>Recent Orders</h3>
                <ul>
                    <li>#1234 – Delivered ✅</li>
                    <li>#1235 – Shipped 🚚</li>
                    <li>#1236 – Processing ⏳</li>
                </ul>
            </div>
        </div>

        <!-- Wishlist -->
        <div id="wishlist" class="section">
            <div class="card">
                <h3>Wishlist</h3>
                <ul>
                    <li>👗 Red Lehenga</li>
                    <li>💍 Gold Necklace</li>
                    <li>⌚ Smart Watch</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function showSection(event, id) {
        event.preventDefault();
        document.querySelectorAll('.user-dashboard .sidebar a').forEach(link => link.classList.remove('active'));
        document.querySelectorAll('.user-dashboard .section').forEach(sec => sec.classList.remove('active'));
        event.target.classList.add('active');
        document.getElementById(id).classList.add('active');
    }
</script>