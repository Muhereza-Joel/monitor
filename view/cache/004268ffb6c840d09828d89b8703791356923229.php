<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Payments</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item active">Orders</li>
        <li class="breadcrumb-item active">Payments</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="card pt-4 mx-2">
        <div class="alert alert-info p-2"><strong>This table shows payments from recent to earlier and only 100 recent payments </strong></div>
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-bordered">
            <thead>
              <tr>
                <th>
                  SNo.
                </th>
                <th>Customer</th>
                <th>Contact</th>
                <th>Product</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Mode</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($payment['name']); ?></td>
                <td><?php echo e($payment['phone']); ?></td>
                <td><?php echo e($payment['title']); ?></td>
                <td><?php echo e($payment['amount']); ?></td>
                <td><?php echo e($payment['status']); ?></td>
                <td><?php echo e($payment['paymentMethod']); ?></td>
                <td><?php echo e($payment['createdAt']); ?></td>

                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      <?php if($role == 'Administrator'): ?>


                      <?php endif; ?>
                    </div>
                  </div>
                </td>
              </tr>

              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>