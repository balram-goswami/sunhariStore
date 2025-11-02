<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome to Sunhari</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f7;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 650px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .header {
            background-color: #ffffff;
            padding: 25px 20px;
            text-align: center;
            border-bottom: 3px solid #10b981;
        }

        .header img {
            max-height: 90px;
        }

        .content {
            padding: 35px 25px;
            text-align: left;
            color: #444;
        }

        .content h2 {
            color: #10b981;
            margin-bottom: 10px;
        }

        .content p {
            line-height: 1.6;
            margin: 10px 0;
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

        .promo {
            background-color: #f0fdf4;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            margin-top: 25px;
            border-radius: 6px;
            color: #065f46;
        }

        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
            border-top: 1px solid #eee;
        }

        .social-links {
            margin-top: 10px;
        }

        .social-links a {
            margin: 0 6px;
            display: inline-block;
            text-decoration: none;
        }

        .social-links img {
            width: 26px;
            height: 26px;
            vertical-align: middle;
            border-radius: 50%;
            transition: opacity 0.2s;
        }

        .social-links img:hover {
            opacity: 0.8;
        }

        @media (max-width: 600px) {
            .content {
                padding: 25px 15px;
            }

            .button {
                width: 100%;
                text-align: center;
                display: block;
            }
        }
    </style>
</head>

<body>
    @php
    $data = siteSetting();
    // Prepare dynamic social media links
    $socialLinks = is_array($data?->social_links) ? $data->social_links : [];
    $social = [];
    foreach ($socialLinks as $link) {
    if (!empty($link['icon']) && !empty($link['url'])) {
    $social[strtolower($link['icon'])] = $link['url'];
    }
    }

    // Absolute asset URL for emails
    $baseUrl = config('app.url');
    @endphp

    <div class="container">
        <div class="header">
            <img src="{{ $data && $data->logo ? $baseUrl . '/storage/' . $data->logo : $baseUrl . '/assets/img/icons/1.png' }}"
                height="90px"
                alt="{{ $data->tagline ?? config('app.name') }}"
                title="{{ $data->tagline ?? config('app.name') }}">
        </div>

        <div class="content">
            <h2>Welcome to {{ config('app.name') }}, {{ $user->name }}!</h2>

            <p>We’re thrilled to have you with us! You’ve joined a growing community that values style, trust, and quality.</p>

            <p>Start exploring exclusive collections, enjoy amazing offers, and experience a smooth shopping journey — crafted just for you.</p>

            <p>
                <a href="{{ url('/products') }}" class="button">Start Shopping Now</a>
            </p>

            <!-- <div class="promo">
                🎁 <strong>Welcome Gift for You!</strong><br>
                Use code <strong>WELCOME10</strong> at checkout to get <strong>10% OFF</strong> on your first purchase.
            </div> -->

            <p>Need help? Our support team is always here for you — reach us at
                <a href="mailto:{{ $data->email ?? 'support@sunhari.in' }}">{{ $data->email ?? 'support@sunhari.in' }}</a>.
            </p>

            <p>With love,<br>
                <strong>The {{ config('app.name') }} Team</strong> 💛
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            <!-- <div class="social-links">
                @foreach (['facebook', 'whatsapp', 'instagram', 'youtube', 'snapchat'] as $key)
                @if (!empty($social[$key]))
                <a href="{{ $social[$key] }}" target="_blank">
                    <img src="{{ url('themeAssets/images/social/' . $key . '.png') }}"
                        alt="{{ ucfirst($key) }}"
                        style="width:26px;height:26px;margin:0 4px;border-radius:50%;">
                </a>
                @endif
                @endforeach
            </div> -->
        </div>
    </div>
</body>

</html>