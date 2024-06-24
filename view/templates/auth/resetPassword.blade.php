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
                                        <a href="/{{$appName}}" class="logo d-flex align-items-center w-auto mb-4">
                                            <img src="/{{$appName}}/assets/img/torodev.png" style="width: 300px; object-fit:contain;" alt="logo">
                                        </a>
                                        <h5 class="card-title pb-0 fs-4">{{$appNameFull}} Account Recovery</h5>
                                        <p class="mt-3">Please create a new strong password that you will use to log in to your account again.</p>
                                        <p>If you encounter any issues, feel free to contact our support team for assistance.</p>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">
                                        <form id="recovery-form" class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="yourIdentifier" class="form-label fw-bold">Confirmed Email Address</label>
                                                <div class="input-group has-validation">
                                                    <input readonly type="text" name="identifier" value="{{$email}}" placeholder="Enter username or email here" class="form-control" id="yourIdentifier" required>
                                                    <div class="invalid-feedback">Please enter your username or email address.</div>
                                                </div>
                                            </div>
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
                                                <button id="recovery-button" class="btn btn-secondary btn-sm w-100" type="submit">Reset Password</button>
                                            </div>
                                            <div class="col-12">
                                                <a href="/{{$appName}}/auth/login/" class="btn btn-sm btn-danger w-100">Cancel Password Reset</a>
                                            </div>
                                            <div id="invalid-login" class="alert alert-danger alert-dismissible fade d-none p-1 mt-3" role="alert">
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
            $('#recovery-form').submit(function(e) {
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
</body>