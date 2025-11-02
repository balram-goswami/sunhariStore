<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thank You for Contacting Us 💬</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background-color: #10b981;
            color: #ffffff;
            text-align: center;
            padding: 25px 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .content {
            padding: 35px 25px;
            text-align: left;
            color: #444;
        }

        .content p {
            line-height: 1.6;
            margin: 12px 0;
            font-size: 15px;
        }

        .button {
            display: inline-block;
            background-color: #10b981;
            color: #fff;
            padding: 10px 20px;
            margin-top: 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #eee;
        }

        .footer a {
            color: #10b981;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .content {
                padding: 25px 15px;
            }
            .header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    @php $data = siteSetting(); @endphp

    <div class="container">
        <div class="header">
            <h2>Hi {{ $name }}, 👋</h2>
        </div>

        <div class="content">
            <p>Thank you for contacting <strong>{{ config('app.name') }}</strong>!</p>
            <p>We’ve received your message and our support team will get back to you as soon as possible.</p>

            <p>In the meantime, feel free to visit our website for the latest collections, offers, and updates.</p>

            <p>
                <a href="{{ url('/') }}" class="button">Visit Our Website</a>
            </p>

            <p>Warm regards,<br>
                <strong>The {{ config('app.name') }} Support Team</strong>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
        </div>
    </div>
</body>
</html>
