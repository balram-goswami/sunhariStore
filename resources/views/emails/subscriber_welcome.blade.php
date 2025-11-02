<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Newsletter 🎉</title>
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
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background-color: #10b981;
            color: #ffffff;
            text-align: center;
            padding: 25px 20px;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 10px;
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

        .highlight {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            border-radius: 6px;
            color: #065f46;
            margin: 20px 0;
        }

        .button {
            display: inline-block;
            background-color: #10b981;
            color: #fff;
            padding: 12px 25px;
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

        .social-links {
            margin-top: 10px;
        }

        .social-links a {
            margin: 0 5px;
            display: inline-block;
        }

        .social-links img {
            width: 24px;
            height: 24px;
            vertical-align: middle;
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
    @php
        $data = siteSetting();
        $socialLinks = is_array($data?->social_links) ? $data->social_links : [];
        $social = [];
        foreach ($socialLinks as $link) {
            if (!empty($link['icon']) && !empty($link['url'])) {
                $social[strtolower($link['icon'])] = $link['url'];
            }
        }
    @endphp

    <div class="container">
        <div class="header">
            <img src="{{ $data && $data->logo ? asset('storage/' . $data->logo) : asset('assets/img/icons/1.png') }}"
                alt="{{ config('app.name') }} Logo" height="60">
            <h2>Welcome to Our Newsletter 🎉</h2>
        </div>

        <div class="content">
            <p>Hi there!</p>

            <p>Thank you for subscribing to the <strong>{{ config('app.name') }}</strong> newsletter. You’re now part of our growing community that loves great offers, style updates, and fresh arrivals.</p>

            <div class="highlight">
                💛 <strong>Stay tuned!</strong> We’ll send you exclusive deals, early product launches, and insider tips straight to your inbox.
            </div>

            <p>
                <a href="{{ url('/') }}" class="button">Visit Our Website</a>
            </p>

            <p>Cheers,<br>
                <strong>The {{ config('app.name') }} Team</strong>
            </p>
        </div>

        <div class="footer">
            <p>Follow us on</p>
            <div class="social-links">
                @foreach (['facebook', 'instagram', 'whatsapp', 'youtube', 'snapchat'] as $key)
                    @if (!empty($social[$key]))
                        <a href="{{ $social[$key] }}" target="_blank">
                            <img src="{{ asset('themeAssets/images/social/' . $key . '.png') }}" alt="{{ ucfirst($key) }}">
                        </a>
                    @endif
                @endforeach
            </div>

            <p style="margin-top: 10px;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
                <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
            </p>
        </div>
    </div>
</body>
</html>
