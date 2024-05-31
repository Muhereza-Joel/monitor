<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <!-- <h1>Books Catalog</h1> -->
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Catalog</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <?php $__currentLoopData = $catalog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-sm-3">
        <a href="/<?php echo e($appName); ?>/catalog/view?category=<?php echo e($category['subject']); ?>" class="col-sm-3">
          <div class="alert info-card sales-card alert-secondary">
            <div class="card-body">
              <h5 class="card-title"><?php echo e($category['subject']); ?> <span>| Total Books</span></h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-book"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo e($category['total_for_subject']); ?></h6>


                </div>
              </div>
            </div>

          </div>
        </a>

      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>