<style>
    /* Namespace to avoid conflicts */
    #thankyou-page {
        position: relative;
        width: 100%;
        height: 100vh;
        font-family: 'Inter', sans-serif;
        overflow: hidden;
    }

    /* Background image with blur */
    #thankyou-page::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('{{ publicPath('themeAssets/demo/10.jpg') }}') no-repeat center center/cover;
        filter: blur(8px) brightness(0.6);
        z-index: 0;
    }

    /* Centered thank you card */
    #thankyou-page .thankyou-box {
        position: relative;
        z-index: 1;
        max-width: 500px;
        margin: 0 auto;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        padding: 50px 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(5px);
    }

    #thankyou-page .thankyou-box h1 {
        color: #28a745;
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    #thankyou-page .thankyou-box p {
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 30px;
    }

    #thankyou-page .thankyou-box a {
        display: inline-block;
        padding: 12px 30px;
        font-size: 1rem;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    #thankyou-page .thankyou-box a.btn-primary {
        background: #28a745;
        color: #fff;
    }

    #thankyou-page .thankyou-box a.btn-primary:hover {
        background: #218838;
        color: #fff;
    }
</style>

<div id="thankyou-page">
    <div class="thankyou-box">
        <h1>Thank You!</h1>
        <p>Your message has been successfully submitted. We will get back to you shortly.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Go to Home</a>
    </div>
</div>
