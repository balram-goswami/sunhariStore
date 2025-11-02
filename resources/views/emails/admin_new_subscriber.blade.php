<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Subscriber Alert 🚀</title>
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
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .header {
            background-color: #10b981;
            color: #ffffff;
            text-align: center;
            padding: 25px 15px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.3px;
        }

        .content {
            padding: 30px;
            text-align: left;
        }

        .content p {
            line-height: 1.6;
            margin: 10px 0;
            font-size: 15px;
        }

        .highlight {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 12px 18px;
            border-radius: 5px;
            font-size: 15px;
            margin: 15px 0;
            word-break: break-all;
        }

        .footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 15px;
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
                padding: 20px;
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
            <h2>New Subscriber Alert 🚀</h2>
        </div>

        <div class="content">
            <p>Hey Admin,</p>

            <p>Great news! A new user has just subscribed to your <strong>{{ config('app.name') }}</strong> newsletter.</p>

            <div class="highlight">
                <strong>Email:</strong> {{ $email }}
            </div>

            <p>Head to your admin panel to view and manage your subscriber list.</p>

            <p>Keep growing your audience 🌱 and spreading the word!</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
        </div>
    </div>
</body>
</html>
