<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>The page you are looking for doesn't exist.</h2>
        <a class="btn" href="/<?php echo e($appName); ?>/dashboard/">Back to home</a>
        <img src="/<?php echo e($appName); ?>/assets/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
        
      </section>

    </div>
  </main><!-- End #main -->

  <?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>