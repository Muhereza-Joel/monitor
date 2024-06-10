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

                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">
                                        <a href="/{{$appName}}" class="logo d-flex align-items-center w-auto mb-4">
                                            <img src="/{{$appName}}/assets/img/logo2.png" style="width: 100px; object-fit:contain;" alt="logo">
                                        </a>
                                        <h5 class="card-title pb-0 fs-4">{{$appNameFull}} Account Recovery</h5>
                                        <p class="mt-3">We're sorry that you've lost access to your account. Please enter your username or email address below. We will look up your account to proceed to account recovery and send you a one-time password to reset your account.</p>
                                        <p>If you encounter any issues, feel free to contact our support team for assistance.</p>
                                    </div>
                                    <!-- Right Column -->
                                    <div class="col-md-6 d-flex flex-column align-items-center justify-content-center p-4">

                                        <form id="recovery-form" class="row g-3 needs-validation" novalidate>
                                            <div class="col-12">
                                                <label for="yourIdentifier" class="form-label fw-bold">Please provide username or email you used when creating your account</label>
                                                <div class="input-group has-validation">
                                                    <input type="text" name="identifier" placeholder="Enter username or email here" class="form-control" id="yourIdentifier" required>
                                                    <div class="invalid-feedback">Please enter your username or email address.</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <button id="recovery-button" class="btn btn-secondary btn-sm w-100" type="submit">Lookup Account Details</button>
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

                Toastify({
                    text: 'Looking Up Your Account Please Wait...',
                    duration: 6000, // Adjust duration as needed
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#444', // Use your desired color
                }).showToast();

                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/accounts/check-identifier/',
                    data: formData,
                    success: function(response) {
                        if (response.exists && response.emailConfirmed) {
                            window.location.replace('/{{$appName}}/auth/accounts/reset/step-one/');
                        } else if (response.exists && !response.emailConfirmed) {
                            window.location.replace('/{{$appName}}/auth/accounts/reset/step-two/');
                        } else {

                            Toastify({
                                text: 'The provided username or email does not exist.',
                                duration: 6000,
                                gravity: 'bottom',
                                position: 'left',
                                backgroundColor: 'red',
                            }).showToast();
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