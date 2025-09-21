<div id="page-content">
    <!--Page Title-->
    <div class="page section-header text-center">
        <div class="page-title">
            <div class="wrapper">
                <h1 class="page-width">Register</h1>
            </div>
        </div>
    </div>
    <!--End Page Title-->

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6 main-col offset-md-3">
                <div class="mb-4">
                    <form action="{{ route('register.store') }}" method="POST" enctype="multipart/form-data" class="login contact-form" id="formAuthentication">
                        @csrf
                        <div class="row">
                            <!-- Name -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="CustomerName">Full Name</label>
                                    <input type="text" name="name" id="CustomerName" class="form-control" required>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="CustomerEmail">Email</label>
                                    <input type="email" name="email" id="CustomerEmail" class="form-control" required>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="CustomerPhone">Phone</label>
                                    <input type="text" name="phone" id="CustomerPhone" class="form-control" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="CustomerPassword">Password</label>
                                    <input type="password" name="password" id="CustomerPassword" class="form-control" required>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="CustomerPasswordConfirmation">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="CustomerPasswordConfirmation" class="form-control" required>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-primary w-100">Register</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>