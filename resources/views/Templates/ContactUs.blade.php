<div id="page-content">
    <!-- Page Title -->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Contact Us</h1>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="mapouter">
    <div class="gmap_canvas"><iframe class="gmap_iframe" width="100%" frameborder="0" scrolling="no" marginheight="0"
            marginwidth="0"
            src="https://maps.google.com/maps?width=1022&amp;height=400&amp;hl=en&amp;q={{ $contact->address }}{{ $contact->city }}{{ $contact->state }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a
            href="https://embed-googlemap.com">google maps embed</a></div>
    <style>
        .mapouter {
            position: relative;
            text-align: right;
            width: 100%;
            height: 400px;
        }

        .gmap_canvas {
            overflow: hidden;
            background: none !important;
            width: 100%;
            height: 400px;
        }

        .gmap_iframe {
            height: 400px !important;
        }
    </style>
</div>

<!-- Breadcrumb -->
<div class="bredcrumbWrap">
    <div class="container breadcrumbs">
        <a href="{{ url('/') }}" title="Back to home">Home</a>
        <span aria-hidden="true">›</span>
        <span>Contact Us</span>
    </div>
</div>

<!-- Contact Form -->
<div class="container my-5">
    <div class="row">
        <!-- Form Section -->
        <div class="col-md-8 mb-4">
            <h2>Drop Us A Line</h2>
            <p>We'd love to hear from you! Please fill out the form below and we'll get back to you shortly.</p>

            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('contactus.form') }}" method="POST" class="contact-form">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="name" placeholder="Name" class="form-control"
                            value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="email" name="email" placeholder="Email" class="form-control"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="tel" name="number" placeholder="Phone Number" class="form-control"
                            value="{{ old('number') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" name="subject" placeholder="Subject" class="form-control"
                            value="{{ old('subject') }}" required>
                    </div>
                    <div class="col-12 mb-3">
                        <textarea name="message" rows="6" placeholder="Your Message" class="form-control" required>{{ old('message') }}</textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Contact Info -->
        <div class="col-md-4">
            <div class="open-hours">
                <strong>Opening Hours</strong><br>
                Mon - Sat: 9am - 11pm<br>
                Sunday: 11am - 5pm
            </div>
            <hr>
            <ul class="list-unstyled">
                <li style="margin-top: 10px;"><i class="icon anm anm-map-marker-al"></i> {{ $contact->address }}{{ $contact->city }}{{ $contact->state }}</li>
                <li style="margin-top: 10px;"><i class="icon anm anm-phone-s"></i> +91 {{ $contact->phone }}</li>
                @if(isset($contact->alternate_phone))
                <li style="margin-top: 10px;"><i class="icon anm anm-phone-s"></i> +91 {{ $contact->alternate_phone }}</li>
                @endif
                <li style="margin-top: 10px;"><i class="icon anm anm-envelope-l"></i> {{ $contact->email }}</li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.querySelector('.contact-form').addEventListener('submit', function(e) {
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
                if (obj.status === 200) {
                    // Redirect to thank you page
                    window.location.href = "{{ route('form.save') }}";
                } else {
                    // Show error message
                    alert(obj.body.message);
                }
            })
            .catch(err => console.error(err));
    });
</script>