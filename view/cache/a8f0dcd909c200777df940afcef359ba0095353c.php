<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Library Users</h1>
    <div class="d-flex">
      <nav class="w-50">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
          <li class="breadcrumb-item active">Users</li>
        </ol>
      </nav>

      <div class="buttons-container align-self-center w-50 text-end">
        <?php if($role == 'Administrator'): ?>
        
        <a href="/<?php echo e($appName); ?>/users/add/" class="btn btn-primary btn-sm mb-3">Add New User</a>

        <?php endif; ?>
      </div>

    </div>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row m-2">

      <div class="card">
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-bordered">
            <thead>
              <tr>
                <th>
                  Username
                </th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Home Country</th>
                <th>District</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($user['username']); ?></td>
                <td><?php echo e($user['fullname']); ?></td>
                <td><?php echo e($user['role']); ?></td>
                <td><?php echo e($user['email']); ?></td>
                <td><?php echo e($user['country']); ?></td>
                <td><?php echo e($user['district']); ?></td>

                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      <?php if($role == 'Administrator'): ?>

                      <a class="dropdown-item" href="/<?php echo e($appName); ?>/users/view/?id=<?php echo e($user['id']); ?>">View User Details</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item" href="/<?php echo e($appName); ?>/users/edit/?id=<?php echo e($user['id']); ?>">Edit User Details</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item text-danger" href="#">Delete User</a> <!-- Replace "1" with the actual book ID -->
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