<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Customer Information</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">User Details</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <img src="<?php echo e($userDetails['image_url']); ?>" alt="Profile" class="rounded-circle" width="350px">

          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>


            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview p-3" id="profile-overview">
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">About</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['about']); ?></div>
                </div>

                <h5 class="card-title fw-bold text-dark">Biography</h5>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Full Name</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['name']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">NIN Number</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['nin']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Date of Birth</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['dob']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Gender</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['gender']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Company</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['company']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Job</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['job']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">NIN Number</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['nin']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Email</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['email']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Country</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['country']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">District</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['district']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Village</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['village']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label fw-bold text-dark">Phone</div>
                  <div class="col-lg-9 col-md-8 text-dark"><?php echo e($userDetails['phone']); ?></div>
                </div>

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>