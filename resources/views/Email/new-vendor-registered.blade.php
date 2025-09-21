<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Vendor Registration</title>
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
            background-color: #4f46e5;
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

        .details p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .label {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Vendor Registered</h2>
        </div>
        <div class="content">
            <p>Hello Admin,</p>
            <p>A new vendor has registered on your platform. Here are the details:</p>

            <div class="details">
                <p><span class="label">Name:</span> {{ $vendor->name }}</p>
                <p><span class="label">Email:</span> {{ $vendor->email }}</p>
                
                @if (!empty($vendor->created_at))
                    <p><span class="label">Registered On:</span> {{ $vendor->created_at->format('d M, Y h:i A') }}</p>
                @endif
            </div>

            <p>You can review and manage this vendor from the admin panel.</p>

            <p>Thanks,<br>Your Team</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
