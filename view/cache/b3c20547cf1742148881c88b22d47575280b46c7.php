<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <div class="col-sm-7">
        <div class="alert alert-light">
          <h2 class="fw-bold">Kyebambe Girls <?php echo e($appName); ?></h2>
          <hr>
          <h5>Welcome back, <?php echo e($username); ?></h5>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">All <span>| Users</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo e($users_total); ?></h6>


                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">All <span>| Books</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo e($books_total); ?></h6>


                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-sm-6">
            <div class="card info-card customers-card">
              <div class="card-body">
                <h5 class="card-title">All <span>| Borrowed Books</span></h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo e($borrowed_books_total); ?></h6>


                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-5"></div>

    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>