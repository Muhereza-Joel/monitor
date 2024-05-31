<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1>User Information</h1>
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

        <div class="text-center">
          <img id="profile-photo" src="<?php echo e($userDetails['image_url']); ?>" class="rounded-circle" alt="Profile" width="300px" height="300px" style="border: 3px solid #999; object-fit: cover;">

        </div>

        <div class="">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

            <small class="fw-bold text-info">Public Username</small>
            <h2> <?php echo e($userDetails['username']); ?></h2>




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

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="fw-bold card-title">Biography</h5>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['fullname']); ?></div>
                </div>
                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">NIN Number</div>
                  <?php if($userDetails['nin'] == null): ?>
                  <div class="col-lg-9 col-md-8">N/A</div>
                  <?php else: ?>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['nin']); ?></div>
                  <?php endif; ?>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">School ID</div>
                  <?php if($userDetails['school_id'] == null): ?>
                  <div class="col-lg-9 col-md-8">N/A</div>
                  <?php else: ?>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['school_id']); ?></div>
                  <?php endif; ?>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">Class</div>
                  <?php if($userDetails['class'] == null): ?>
                  <div class="col-lg-9 col-md-8">N/A</div>
                  <?php else: ?>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['class']); ?></div>
                  <?php endif; ?>
                </div>



                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['country']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">Home District</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['district']); ?></div>
                </div>


                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['phone']); ?></div>
                </div>

                <div class="row my-4">
                  <div class="col-lg-3 col-md-4 label">Email</div>
                  <div class="col-lg-9 col-md-8"><?php echo e($userDetails['email']); ?></div>
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