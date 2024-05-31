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

    <div class="alert alert-warning">
      <h3 class="fw-bold">Defense Forces Shop Uganda Ltd, Shop Management System.</h3>
      <hr>
      <h6 class="badge bg-primary">You are on the
        <?php if($role == 'Administrator'): ?>
        Administrator
        <?php elseif($role == 'Staff'): ?>
        Staff
        <?php else: ?>
        Customer
        <?php endif; ?>
        dashboard
      </h6>
    </div>

    <?php if($role == 'Administrator' || $role == 'Staff'): ?>
    <div class="row g-1">

      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Branches</div>
          <div class="card-body">
            <h2><?php echo e($branchesCount); ?></h2>
          </div>
          <div class="card-footer">
            <a class="text-success" href="/<?php echo e($appName); ?>/dashboard/branches/">View All Branches</a>
          </div>
        </div>
      </div>



      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Stores</div>
          <div class="card-body">
            <h2><?php echo e($storesCount); ?></h2>
          </div>
          <div class="card-footer">
            <a class="text-success" href="/<?php echo e($appName); ?>/dashboard/stores/">View All Stores</a>
          </div>
        </div>
      </div>


      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Products</div>
          <div class="card-body">
            <h2><?php echo e($productsCount); ?></h2>
          </div>
          <div class="card-footer">
            <a class="text-success" href="/<?php echo e($appName); ?>/dashboard/inventory/products/">View All Products</a>
          </div>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Customers</div>
          <div class="card-body">
            <h2><?php echo e($customersCount); ?></h2>
          </div>
          <div class="card-footer">
            <a class="text-success" href="/<?php echo e($appName); ?>/dashboard/customers/">View All Customers</a>
          </div>
        </div>
      </div>

      <div class="col-sm-3">
        <div class="card px-2">
          <div class="card-title">Revenue Today</div>
          <div class="card-body">
            <h2>Ugx <?php echo e($revenueToday); ?></h2>
          </div>

        </div>
      </div>

      <div class="col-sm-3">
        <div class="card px-2">
          <div class="card-title">Total Orders Today</div>
          <div class="card-body">
            <h2><?php echo e($ordersCount); ?></h2>
          </div>

        </div>
      </div>


    </div>
    <?php endif; ?>

    <?php if($role == 'Customer'): ?>
    <div class="row">
      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Branches</div>
          <div class="card-body">
            <h2><?php echo e($branchesCount); ?></h2>
          </div>
        </div>
      </div>



      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Stores</div>
          <div class="card-body">
            <h2><?php echo e($storesCount); ?></h2>
          </div>
        </div>
      </div>


      <div class="col-sm-4">
        <div class="card px-2">
          <div class="card-title">Total Products</div>
          <div class="card-body">
            <h2><?php echo e($productsCount); ?></h2>
          </div>
        </div>
      </div>

    </div>
    <?php endif; ?>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>