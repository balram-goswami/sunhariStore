@php
$data = siteSetting();
@endphp
@include('Model.ChatBot')
<footer id="footer">
    <div class="newsletter-section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-7 w-100 d-flex justify-content-start align-items-center">
                    <div class="display-table">
                        <div class="display-table-cell footer-newsletter">
                            <div class="section-header text-center">
                                <label class="h2"><span>sign up for </span>newsletter</label>
                            </div>
                            <form action="{{ route('subscribe.form') }}" method="POST" id="subscribeForm">
                                @csrf
                                <div class="input-group">
                                    <input type="email" class="input-group__field newsletter__input" name="email"
                                        placeholder="Email address" required>
                                    <span class="input-group__btn">
                                        <button type="submit" class="btn newsletter__submit" name="commit"
                                            id="Subscribe">
                                            <span class="newsletter__submit-text--large">Subscribe</span>
                                        </button>
                                    </span>
                                </div>
                            </form>
                            <div id="subscribeMessage"></div>
                        </div>
                    </div>
                </div>
                @php
                $socialLinks = is_array($data?->social_links) ? $data->social_links : [];

                $social = [];
                foreach ($socialLinks as $link) {
                if (!empty($link['icon']) && !empty($link['url'])) {
                $social[strtolower($link['icon'])] = $link['url'];
                }
                }

                $iconClassMap = [
                'facebook' => 'bi-facebook',
                'instagram' => 'bi-instagram',
                'youtube' => 'bi-youtube',
                'whatsapp' => 'bi-whatsapp',
                'snapchat' => 'bi-snapchat',
                ];
                @endphp


                <div class="col-12 col-sm-12 col-md-12 col-lg-5 d-flex justify-content-end align-items-center">
                    <div class="footer-social">
                        <ul class="list--inline site-footer__social-icons social-icons">
                            @foreach ($social as $key => $url)
                            @if (!empty($url) && isset($iconClassMap[$key]))
                            <li>
                                <a class="social-icons__link" href="{{ $url }}" target="_blank" title="{{ ucfirst($key) }}">
                                    <i class="bi {{ $iconClassMap[$key] }}"></i>
                                    <span class="icon__fallback-text">{{ ucfirst($key) }}</span>
                                </a>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="site-footer">
        <div class="container">
            <!--Footer Links-->
            <div class="footer-top">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 contact-box">
                        <h4 class="h4">Contact Us</h4>
                        <ul class="addressFooter">
                            <li>
                                <i class="icon anm anm-map-marker-al"></i>
                                <p>{{ $data->address ?? '' }} {{ $data->city ?? '' }} {{ $data->state ?? '' }}</p>
                            </li>

                            <li class="phone">
                                <i class="icon anm anm-phone-s"></i>
                                <p>
                                    <a href="tel:{{ $data->phone ?? '' }}" style="color: white;">
                                        {{ $data->phone ?? '' }}
                                    </a>
                                </p>
                            </li>

                            @if(isset($data->alternate_phone))
                            <li class="phone">
                                <i class="icon anm anm-phone-s"></i>
                                <p>
                                    <a href="tel:{{ $data->alternate_phone }}" style="color: white;">
                                        {{ $data->alternate_phone }}
                                    </a>
                                </p>
                            </li>
                            @endif

                            <li class="email">
                                <i class="icon anm anm-envelope-l"></i>
                                <p>
                                    <a href="mailto:{{ $data->email ?? '' }}" style="color: white;">
                                        {{ $data->email ?? '' }}
                                    </a>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                        <h4 class="h4">Useful Links</h4>
                        <ul>
                            <li><a href="{{ route('contuct-us') }}">Contact Us</a></li>
                            <li><a href="{{ route('about-us') }}">About Us</a></li>
                            <li><a href="{{ route('products') }}">Shop</a></li>

                            @auth
                            @if(auth()->user()->isAdmin())
                            <li><a href="{{ url('/admin/admin-dashboard') }}">Admin Dashboard</a></li>
                            @elseif(auth()->user()->isManager())
                            <li><a href="{{ url('/admin/dashboard') }}">Manager Dashboard</a></li>
                            @elseif(auth()->user()->isUser())
                            <li><a href="{{ route('profile') }}">My Profile</a></li>
                            @endif
                            @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Create Account</a></li>
                            @endauth
                        </ul>
                    </div>

                    @php
                    $socialLinks = is_array($data?->social_links) ? $data->social_links : [];
                    $social = [];

                    foreach ($socialLinks as $link) {
                    if (!empty($link['icon']) && !empty($link['url'])) {
                    $social[strtolower($link['icon'])] = $link['url'];
                    }
                    }
                    @endphp

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                        <h4 class="h4">Social Links</h4>
                        <ul>
                            @foreach (['facebook','whatsapp','instagram','youtube','snapchat'] as $key)
                            @if (!empty($social[$key]))
                            <li><a href="{{ $social[$key] }}" target="_blank">{{ ucfirst($key) }}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                        <h4 class="h4">Policies</h4>
                        <ul>
                            <li><a href="{{ route('policies') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('shipping') }}">Shipping & Delivery</a></li>
                            <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('return.refund') }}">Return & Refund Policy</a></li>
                        </ul>
                    </div>


                    <!-- <div class="footer-facebook">
                        <div id="fb-root"></div>
                        <script async defer crossorigin="anonymous"
                            src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v17.0"></script>

                        <div class="fb-page"
                            data-href="https://www.facebook.com/profile.php?id=61579472553589"
                            data-tabs="timeline"
                            data-width="300"
                            data-height="300"
                            data-small-header="false"
                            data-adapt-container-width="false"
                            data-hide-cover="false"
                            data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/profile.php?id=61579472553589" class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/profile.php?id=61579472553589">Facebook Page</a>
                            </blockquote>
                        </div>
                    </div> -->
                </div>
            </div>

            <hr>
            <div class="footer-bottom">
                <div class="row">
                    <!--Footer Copyright-->
                    <div
                        class="col-12 col-sm-12 col-md-6 col-lg-6 order-1 order-md-0 order-lg-0 order-sm-1 copyright text-sm-center text-md-left text-lg-left">
                        <span></span> <a href="{{ route('homePage') }}">All Rights Reserved</a>
                    </div>
                    <!--End Footer Copyright-->
                    <!--Footer Payment Icon-->
                    <div
                        class="col-12 col-sm-12 col-md-6 col-lg-6 order-0 order-md-1 order-lg-1 order-sm-0 payment-icons text-right text-md-center">
                        <ul class="payment-icons list--inline">
                            <li><i class="bi bi-credit-card-2-front"></i></li>
                            <li><i class="bi bi-credit-card"></i></li>
                            <li><i class="bi bi-paypal"></i></li>
                            <li><i class="bi bi-bank"></i></li>
                        </ul>
                    </div>
                    <!--End Footer Payment Icon-->
                </div>
            </div>
        </div>
    </div>
</footer>

<span id="site-scroll"><i class="icon anm anm-angle-up-r"></i></span>

<script>
    document.getElementById('subscribeForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json().then(data => ({
                status: response.status,
                body: data
            })))
            .then(obj => {
                const messageDiv = document.getElementById('subscribeMessage');
                if (obj.status === 200) {
                    messageDiv.innerHTML = `<p style="color:green;">${obj.body.message}</p>`;
                    this.reset();
                } else {
                    messageDiv.innerHTML = `<p style="color:red;">${obj.body.message}</p>`;
                }
            })
            .catch(error => console.error('Error:', error));
    });
</script>

@include('Include.Script')
</div>
</body>


</html>