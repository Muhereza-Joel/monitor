<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<body>
    <main>
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 p-5 col-md-4 d-flex flex-column align-items-center justify-content-center">
                        <div class="d-flex flex-column justify-content-center py-4">
                            <a href="/<?php echo e($appName); ?>" class="logo d-flex align-items-center w-auto">
                                <img src="/<?php echo e($appName); ?>/assets/img/torodev.png" style="width: 400px; object-fit:contain;" alt="logo">
                            </a>
                            <br>
                        </div>
                        <!-- End Logo -->
                        <div class="card">
                            <div class="card-body">
                                <div class="pt-4 text-center">
                                    <h5 class="card-title pb-0 fs-4"><?php echo e($appNameFull); ?></h5>
                                    <p class="small">Enter your username & password to login</p>
                                </div>

                                <div id="invalid-login" class="alert alert-danger alert-dismissible fade d-none p-1" role="alert">
                                    <span class="text-center"></span>
                                </div>

                                <form id="login-form" class="row g-3 needs-validation" novalidate>
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username or Email</label>
                                        <div class="input-group has-validation">
                                            <input type="text" name="username" class="form-control" id="yourUsername" required>
                                            <div class="invalid-feedback">Please enter your username.</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                                        <div class="invalid-feedback">Please enter your password!</div>
                                    </div>

                                    <div class="col-12">
                                        <button id="login-button" class="btn btn-secondary w-100" type="submit">Sign in</button>
                                    </div>
                                    <div class="card-footer p-0">
                                        <div class="col-12 text-center">
                                            <p>
                                                <a href="/<?php echo e($appName); ?>/auth/organizations/choose/">Create an account</a>|
                                                <a href="/<?php echo e($appName); ?>/auth/accounts/reset/" class="text-danger ms-2">Forgot Password</a>
                                            </p>

                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- End #main -->
    <?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script>
        $(document).ready(function() {
            $('#login-form').submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/<?php echo e($appName); ?>/auth/login/sign-in/',
                    data: formData,
                    success: function(response) {
                        if (response.profileCreated == true) {
                            $("#login-button").text("Please wait...").attr('disabled', 'true').text("Authentication Successful, redirecting...");
                            window.location.replace("/<?php echo e($appName); ?>/dashboard/organizations/choose/");
                        } else if (response.profileCreated == false) {
                            window.location.replace("/<?php echo e($appName); ?>/auth/create-profile/");
                        }
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 401) {
                            Toastify({
                                text: jqXHR.responseJSON.message,
                                duration: 4000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: 'red',
                            }).showToast();
                        }
                    }
                });
            });
        });
    </script>
</body>