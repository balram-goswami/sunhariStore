<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f7;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            background-color: #10b981;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 30px 20px;
        }

        .footer {
            background-color: #f0f0f0;
            padding: 15px 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }

        .button {
            display: inline-block;
            background-color: #10b981;
            color: #fff;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .details p {
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to Our Vendor Platform</h2>
        </div>
        <div class="content">
            <p>Hello {{ $user->name }},</p>

            <p>Thank you for registering as a vendor on our platform. We’re thrilled to have you onboard!</p>

            @if (!empty($user->company_name))
                <p><strong>Company:</strong> {{ $user->company_name }}</p>
            @endif

            <p>You can now log in to your dashboard and start managing your products and orders:</p>

            <p>
                <a href="{{ route('login') }}" class="button">Login to Your Vendor Dashboard</a>
            </p>

            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>

            <p>Welcome aboard!<br>
                The {{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
