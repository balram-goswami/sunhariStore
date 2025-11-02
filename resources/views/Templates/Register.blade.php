<style>
    .form-control {
    border-radius: 8px;
    padding: 10px 14px;
}
.btn-primary {
    border-radius: 8px;
}
</style>

<div id="page-content">
    <!-- Page Title -->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Create Account</h1>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card shadow-sm p-4 rounded-3 border-0">
                    <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="formAuthentication">
                        @csrf
                        <div class="row">
                            <!-- Name -->
                            <div class="col-12 mb-3">
                                <label for="CustomerName" class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" id="CustomerName" class="form-control"
                                       value="{{ old('name') }}" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-12 mb-3">
                                <label for="CustomerEmail" class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" id="CustomerEmail" class="form-control"
                                       value="{{ old('email') }}" required>
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-12 mb-3">
                                <label for="CustomerPhone" class="form-label fw-semibold">Phone</label>
                                <input type="text" name="phone" id="CustomerPhone" class="form-control"
                                       value="{{ old('phone') }}" required pattern="[0-9]{10}" maxlength="10">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="col-12 mb-3">
                                <label for="CustomerPassword" class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" id="CustomerPassword" class="form-control" required>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-12 mb-3">
                                <label for="CustomerPasswordConfirmation" class="form-label fw-semibold">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="CustomerPasswordConfirmation" class="form-control" required>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                    Register
                                </button>
                            </div>

                            <!-- Links -->
                            <div class="col-12 text-center mt-3">
                                <p class="mb-0">
                                    Already have an account? 
                                    <a href="{{ route('login') }}" class="text-decoration-underline">Login here</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
