<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<body>

  <main>
    <div class="container">

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
            <div class="col-lg-4 col-md-4 d-flex flex-column align-items-center justify-content-center">


              <div class="card mb-3">

                <div class="card-body">
                  <div class="row">
                    <div class="col">

                      <div class="pt-4 pb-2">
                        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                        <p class="text-center small">Enter your personal details to create account</p>
                      </div>

                      <div id="invalid-registration" class="alert alert-danger alert-dismissible fade d-none p-1" role="alert">
                        <span class="text-center"></span>
                      </div>
                      <form id="registration-form" class="row g-3 needs-validation" novalidate>

                        <div class="col-12">
                          <label for="yourEmail" class="form-label">Your Email</label>
                          <input type="email" name="email" class="form-control" id="yourEmail" required placeholder="Enter your email address here">
                          <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                        </div>

                        <div class="col-12">
                          <label for="yourUsername" class="form-label">Username</label>
                          <div class="input-group has-validation">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            <input type="text" name="username" class="form-control" id="yourUsername" required placeholder="Enter a login username to use">
                            <div class="invalid-feedback">Please choose a username.</div>
                          </div>
                        </div>

                        <div class="col-12">
                          <label for="yourPassword" class="form-label">Password</label>
                          <input type="password" name="password" class="form-control" id="yourPassword" required placeholder="Enter your password here">
                          <div class="invalid-feedback">Please enter your password!</div>
                        </div>


                        <div class="col-12">
                          <button id="submit-button" class="btn btn-primary w-100" type="submit">Create Account</button>
                        </div>
                        <div class="col-12">
                          <p class="small mb-0">If you have an account already? <a href="/<?php echo e($appName); ?>/auth/login/">Click here</a> to login</p>
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

    </div>
  </main><!-- End #main -->

  <?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <script>
    $(document).ready(function() {
      $('#registration-form').submit(function(e) {
        e.preventDefault();

        if (this.checkValidity() === true) {

          $("#submit-button").attr('disabled', 'true')
          $("#submit-button").text("Please wait...")

          let formData = $(this).serialize();

          $.ajax({
            method: 'post',
            url: '/<?php echo e($appName); ?>/auth/create-account/',
            data: formData,
            success: function(response) {

              $("#submit-button").attr('disabled', 'true')
              Toastify({
                  text: response.message,
                  duration: 4000,
                  gravity: 'top',
                  position: 'center',
                  backgroundColor: 'green',
                }).showToast();

              setTimeout(function() {
                window.location.replace("/<?php echo e($appName); ?>/")
              }, 3000)


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

                $('#submit-button').attr('disabled', false);
                $("#submit-button").text("Create Account")

              }
            }
          })
        }

      })
    })
  </script>