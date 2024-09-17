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
                                    <div style="border-right: 2px solid #999;" class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">
                                        <a href="/" class="logo d-flex align-items-center w-auto mb-4">
                                            <img src="{{ asset('img/logo_yellow.png') }}" style="width: 300px; object-fit:contain;" alt="logo">
                                        </a>
                                        <h5 class="card-title pb-0 fs-4">{{$appNameFull}} Account Recovery</h5>
                                        <p class="mt-3">We're sorry that you've lost access to your account. Please enter your email address on the right to request a one-time password (OTP) for account recovery.</p>
                                        <p>If you encounter any issues, feel free to contact our support team for assistance.</p>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">
                                        <form action="" id="otp-request-form" class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="yourEmail" class="form-label fw-bold">Confirmed Email Address</label>
                                                <div class="input-group has-validation">
                                                    <input type="email" name="email" value="{{$email}}" placeholder="Enter your email address" class="form-control" id="yourEmail" required>
                                                    <div class="invalid-feedback">Please enter your email address.</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button id="otp-request-button" class="btn btn-secondary btn-sm w-100" type="submit">Request OTP</button>
                                            </div>
                                            <div id="invalid-request" class="alert alert-danger alert-dismissible fade d-none p-1 mt-3" role="alert">
                                                <span class="text-center"></span>
                                            </div>
                                        </form>

                                        <form action="" id="otp-verify-form" class="row g-3 needs-validation d-none mt-4" novalidate>
                                            <div class="col-12">
                                                <label for="otp" class="form-label fw-bold">Enter OTP</label>
                                                <div class="input-group has-validation">
                                                    <input type="text" name="otp" placeholder="Enter the OTP sent to your email" class="form-control" id="otp" required>
                                                    <div class="invalid-feedback">Please enter the OTP.</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button id="otp-verify-button" class="btn btn-secondary btn-sm w-100" type="submit">Verify OTP</button>
                                            </div>
                                            <div id="invalid-otp" class="alert alert-danger alert-dismissible fade d-none p-1 mt-3" role="alert">
                                                <span class="text-center"></span>
                                            </div>
                                        </form>

                                        <form id="password-reset-form" class="row g-3 needs-validation d-none mt-4" novalidate>
                                            <div class="col-12">
                                                <label for="newPassword" class="form-label fw-bold">New Password</label>
                                                <input type="password" name="newPassword" class="form-control" id="newPassword" required>
                                            </div>
                                            <div class="col-12">
                                                <label for="confirmPassword" class="form-label fw-bold">Confirm Password</label>
                                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" required>
                                                <div class="invalid-feedback">Passwords do not match.</div>
                                            </div>
                                            <div class="col-12">
                                                <button id="password-reset-button" class="btn btn-secondary btn-sm w-100" type="submit">Reset Password</button>
                                            </div>
                                            <div id="invalid-login" class="alert alert-danger alert-dismissible fade d-none p-1 mt-3" role="alert">
                                                <span class="text-center"></span>
                                            </div>
                                        </form>

                                        <div class="col-12 mt-3">
                                            <a href="{{ route('login') }} " class="btn btn-sm btn-danger w-100">Cancel Password Reset</a>
                                        </div>
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

            $('#otp-request-form').submit(function(e) {

                e.preventDefault();
                let formData = $(this).serialize();

                // Show toast message
                Toastify({
                    text: 'Requesting OTP, please wait...',
                    duration: 6000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#444',
                }).showToast();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/accounts/request-otp/',
                    data: formData,
                    success: function(response) {
                        if (response.status == 200) {

                            Toastify({
                                text: 'Please Check Your Inbox, OTP sent successfully!',
                                duration: 6000,
                                gravity: 'bottom',
                                position: 'left',
                                backgroundColor: 'green',
                            }).showToast();

                            $('#otp-request-form').addClass('d-none');
                            $('#otp-verify-form').removeClass('d-none');
                        }
                    },
                    error: function(jqXHR) {
                        Toastify({
                            text: jqXHR.responseJSON.message,
                            duration: 6000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'red',
                        }).showToast();
                    }
                });
            });

            $('#otp-verify-form').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                // Show toast message
                Toastify({
                    text: 'Verifying OTP, please wait...',
                    duration: 6000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#444',
                }).showToast();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/accounts/confirm-password-otp/',
                    data: formData,
                    success: function(response) {

                        if (response.status == 200) {

                            Toastify({
                                text: 'OTP verified successfully!',
                                duration: 6000,
                                gravity: 'bottom',
                                position: 'left',
                                backgroundColor: 'green',
                            }).showToast();

                            $('#otp-verify-form').addClass('d-none');
                            $('#password-reset-form').removeClass('d-none');
                        }
                    },
                    error: function(jqXHR) {
                        Toastify({
                            text: jqXHR.responseJSON.message,
                            duration: 6000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'red',
                        }).showToast();
                    }
                });
            });

            $('#password-reset-form').submit(function(e) {
                e.preventDefault();

                $('#confirmPassword').removeClass('is-invalid');

                let newPassword = $('#newPassword').val();
                let confirmPassword = $('#confirmPassword').val();

                if (!newPassword || !confirmPassword) {
                    if (!newPassword) {
                        $('#newPassword').addClass('is-invalid');
                    }
                    if (!confirmPassword) {
                        $('#confirmPassword').addClass('is-invalid');
                    }
                    return;
                }

                if (newPassword !== confirmPassword) {
                    $('#confirmPassword').addClass('is-invalid');
                    return;
                }

                Toastify({
                    text: 'Processing your request, please wait...',
                    duration: 6000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#444',
                }).showToast();

                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/accounts/reset-password/',
                    data: formData,
                    success: function(response) {
                        if (response.status == 200) {
                            Toastify({
                                text: 'Password reset successfully!',
                                duration: 6000,
                                gravity: 'bottom',
                                position: 'left',
                                backgroundColor: 'green',
                            }).showToast();
                            setTimeout(function() {
                                window.location.replace('/{{$appName}}/auth/login/');

                            }, 3000)
                        }
                    },
                    error: function(jqXHR) {
                        Toastify({
                            text: jqXHR.responseJSON.message,
                            duration: 6000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'red',
                        }).showToast();
                    }
                });
            });
        });
    </script>