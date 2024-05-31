<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1><?php echo e($category); ?> Books Catalog</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Category</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

        <?php if(empty($catalog)): ?>
      <div class="alert alert-warning" role="alert">
        No books available.
      </div>
      <?php else: ?>
      <?php $__currentLoopData = $catalog; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="col-sm-3">
        <a href="/<?php echo e($appName); ?>/books/view/?id=<?php echo e($item['id']); ?>" class="card" style="text-decoration: none; color: inherit;">
          <div style="width: 100%; height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; overflow: hidden;">
            <img src="<?php echo e($item['cover']); ?>" class="card-img-top" alt="book image" style="object-fit: cover; width: 100%; height: 100%;">
          </div>
          <div class="card-body">
            <h5 class="card-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item['title']); ?> </h5>
            <h6 class="span" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong>Author: </strong><?php echo e($item['author']); ?></h6>
            <h6 class="span" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><strong>Edition: </strong><?php echo e($item['edition']); ?></h6>
            <h6 class="badge bg-success" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo e($item['total']); ?> in stock</h6>
            
          </div>

          
        </a>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

      <?php endif; ?>


        </div>
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>