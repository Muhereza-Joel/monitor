@include('partials/header')

<body>
    <main>
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-start py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card mt-5">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6 d-flex flex-column align-items-start justify-content-center p-4">
                                        <h5 class="card-title pb-0 fs-4">{{$appNameFull}} Account Recovery</h5>
                                        <hr>
                                        <h3 class="text-danger">We have noticed that you did not confirm your email.</h3>
                                        <hr>
                                        <h2 class="text-success">We've sent a one-time password (OTP) to your email address.</h2>
                                        <p class="mt-3"> Please enter the OTP below to confirm your email and proceed with account recovery.</p>
                                        <p>If you didn't receive the email, check your spam folder or contact our support team for assistance.</p>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">
                                        <a href="/{{$appName}}" class="logo d-flex align-items-center w-auto mb-4">
                                            <img src="/{{$appName}}/assets/img/logo2.png" style="width: 100px; object-fit:contain;" alt="logo">
                                        </a>
                                        <form id="otp-confirmation-form" class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="yourEmail" class="form-label fw-bold">This is your Email address you used to create your account</label>
                                                <div class="input-group has-validation">
                                                    <input type="email" name="email" class="form-control" id="yourEmail" value="{{$email}}" readonly>
                                                    <div class="invalid-feedback">Please enter your email address.</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="yourOtp" class="form-label">OTP</label>
                                                <div class="input-group has-validation">
                                                    <input type="text" name="otp" class="form-control" id="yourOtp" required>
                                                    <div class="invalid-feedback">Please enter the OTP sent to your email.</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button id="otp-confirmation-button" class="btn btn-secondary btn-sm w-100" type="submit">Confirm OTP</button>
                                            </div>
                                            <div class="col-12">
                                                <a href="/{{$appName}}/auth/login/" class="btn btn-sm btn-danger w-100">Cancel Password Reset</a>
                                            </div>

                                            <div id="invalid-otp" class="alert alert-danger alert-dismissible fade d-none p-1 mt-3" role="alert">
                                                <span class="text-center"></span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->
    @include('partials/footer')

    <script>
        $(document).ready(function() {
            $('#otp-confirmation-form').submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/accounts/confirm-otp/',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Toastify({
                                text: "OTP confirmed. You can now reset your password.",
                                duration: 4000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: 'green',
                            }).showToast();
                            window.location.replace('/{{$appName}}/auth/accounts/reset/step-three/');
                        } else {
                            $('#invalid-otp').removeClass('d-none').addClass('show').text('Invalid OTP. Please try again.');
                        }
                    },
                    error: function(jqXHR) {
                        $('#invalid-otp').removeClass('d-none').addClass('show').text(jqXHR.responseJSON.message);
                    }
                });
            });
        });
    </script>
</body>