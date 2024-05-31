<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<body>

    <main>
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8" style="border-right: 2px dotted #333;">
                        <div class="d-flex flex-column justify-content-center py-4">
                            <a href="/<?php echo e($appName); ?>" class="logo d-flex align-items-center w-auto">
                                <img src="/<?php echo e($appName); ?>/assets/img/logo2.png" style="width: 150px; object-fit:contain;" alt="logo">
                                <br />
                                <span class=" text-dark">Blue Spring Dry cleaners and Laundry Services</span>
                                <span class="d-none d-lg-block mt-3 text-center  text-dark"><?php echo e($appNameFull); ?></span>
                            </a>
                            <hr>
                        </div><!-- End Logo -->
                        <ul>
                            <li>
                                Blue Spring Laundry services extended its services to Fort Portal Tourism city offering dry cleaning and laundry services that provides all kinds of cleaning solutions such as curtain cleaning, wash and fold, duvet and carpet cleaning.
                            </li>
                            <li>
                                It is a registered laundry and cleaning facility that was established to serve the people of Fort Portal Tourism City. Blue Spring Laundry and cleaning services is located in the heart of Fort Portal City, on plot No. 20, Ruhandiika Street.
                            </li>
                        </ul>


                        <p></p>

                    </div>
                    <div class="col-lg-4 p-5 col-md-4 d-flex flex-column align-items-center justify-content-center">



                        <div class="card mb-3">

                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                    <p class="text-center small">Enter your username & password to login</p>
                                </div>

                                <div id="invalid-login" class="alert alert-danger alert-dismissible fade d-none p-1" role="alert">
                                    <span class="text-center"></span>
                                </div>
                                <form id="login-form" class="row g-3 needs-validation" novalidate>
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Username or Email</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
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
                                        <button id="login-button" class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>
                                    <div class="col-12">

                                        <p class="small mb-0">If you don't have account? <a href="/<?php echo e($appName); ?>/auth/register/">click here to</a> create an register</p>
                                    </div>
                                </form>


                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </section>

    </main><!-- End #main -->
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

                            if (response.role == 'Administrator') {
                                window.location.replace("/<?php echo e($appName); ?>/dashboard/");

                                $("#login-button").text("Please wait...");
                                $("#login-button").attr('disabled', 'true');
                                $("#login-button").text("Authentication Successful, redirecting...");

                            } else if (response.role == 'Customer') {
                                window.location.replace("/<?php echo e($appName); ?>/dashboard/");

                                $("#login-button").text("Please wait...");
                                $("#login-button").attr('disabled', 'true');
                                $("#login-button").text("Authentication Successful, redirecting...");
                            }


                        } else if (response.profileCreated == false) {
                            window.location.replace("/<?php echo e($appName); ?>/auth/create-profile/");
                        }

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
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
                })
            })
        })
    </script>