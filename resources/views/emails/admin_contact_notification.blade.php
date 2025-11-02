<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact Form Submission</title>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 650px;
            background-color: #ffffff;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.05);
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
        }

        .content p {
            margin: 10px 0;
            line-height: 1.5;
            font-size: 15px;
        }

        .content strong {
            color: #000;
        }

        .message-box {
            background-color: #f9fafb;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .footer {
            background-color: #f9f9f9;
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
    <div class="container">
        <div class="header">
            <h2>📨 New Contact Form Submission</h2>
        </div>

        <div class="content">
            <p><strong>Name:</strong> {{ $data['name'] ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $data['email'] ?? 'N/A' }}</p>
            <p><strong>Number:</strong> {{ $data['number'] ?? 'N/A' }}</p>
            <p><strong>Subject:</strong> {{ $data['subject'] ?? 'N/A' }}</p>

            <div class="message-box">
                <p><strong>Message:</strong></p>
                <p>{{ $data['message'] ?? 'No message provided.' }}</p>
            </div>
        </div>

        <div class="footer">
            <p>You received this email because someone submitted a message via the contact form on <strong>{{ config('app.name') }}</strong>.</p>
            <p><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
        </div>
    </div>
</body>
</html>
