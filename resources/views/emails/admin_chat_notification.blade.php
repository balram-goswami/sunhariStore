<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Chat Message</title>
    <style>
        body {
            background-color: #f8f9fb;
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .email-header {
            background: #f2b705;
            color: #fff;
            text-align: center;
            padding: 20px 10px;
        }
        .email-header h2 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 0.5px;
        }
        .email-body {
            padding: 25px 30px;
        }
        .email-body p {
            margin: 8px 0;
            font-size: 15px;
            line-height: 1.5;
        }
        .email-body strong {
            color: #000;
        }
        .message-box {
            background: #f7f7f7;
            border-left: 4px solid #f2b705;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
        }
        .footer {
            background: #f9f9f9;
            text-align: center;
            font-size: 13px;
            color: #777;
            padding: 15px;
        }
        a {
            color: #f2b705;
            text-decoration: none;
        }
        @media only screen and (max-width: 600px) {
            .email-body { padding: 20px; }
            .email-header h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

    <div class="email-wrapper">
        <div class="email-header">
            <h2>📩 New Chat Message Received</h2>
        </div>

        <div class="email-body">
            <p><strong>Name:</strong> {{ $data['name'] ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $data['email'] ?? 'N/A' }}</p>
            <p><strong>Number:</strong> {{ $data['number'] ?? 'N/A' }}</p>

            <div class="message-box">
                <p><strong>Message:</strong></p>
                <p>{{ $data['message'] ?? 'No message provided.' }}</p>
            </div>
        </div>

        <div class="footer">
            <p>You're receiving this notification because a user sent a new chat message on <strong>{{ config('app.name') }}</strong>.</p>
            <p><a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>
        </div>
    </div>

</body>
</html>
