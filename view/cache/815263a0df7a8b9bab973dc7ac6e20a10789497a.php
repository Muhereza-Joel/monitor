<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">


  <section class="section dashboard">
    <div class="row m-2">

      <div class="card">
        <div class="pagetitle">
          <div class="d-flex">
            <nav class="w-50">
              <h1>Books</h1>
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Books</li>
              </ol>
            </nav>
            <div class="buttons-container align-self-center w-50 text-end">
              <a href="/<?php echo e($appName); ?>/books/grid-view/" title="Grid View">
                <div class="icon" style="font-size: 30px;">
                  <i class="bi bi-grid-3x3-gap"></i>

                </div>
              </a>
              <?php if($role == 'Administrator'): ?>


              <?php endif; ?>
            </div>
          </div>

        </div>
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-bordered table-striped">
            <thead>
              <tr>
                <th>
                  Title
                </th>
                <th>Author</th>
                <th>Edition</th>
                <th>Subject</th>
                <th>Level</th>
                <th>Shelf</th>
                <th>Stock</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($book['title']); ?></td>
                <td><?php echo e($book['author']); ?></td>
                <td><?php echo e($book['edition']); ?></td>
                <td><?php echo e($book['subject']); ?></td>
                <td>Senior <?php echo e($book['class_level']); ?></td>
                <td><?php echo e($book['shelf_number']); ?></td>
                <td>
                  <span class="badge bg-success"><?php echo e($book['total'] - $book['borrowed']); ?> in </span>
                  <span class="badge bg-warning"><?php echo e($book['borrowed']); ?> out</span>
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      <?php if($role == 'Administrator'): ?>
                      <a class="dropdown-item" href="/<?php echo e($appName); ?>/books/edit/?id=<?php echo e($book['id']); ?>">Edit Book</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item" href="/<?php echo e($appName); ?>/books/view/?id=<?php echo e($book['id']); ?>">View Book Details</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item" href="/<?php echo e($appName); ?>/books/lend/?id=<?php echo e($book['id']); ?>">Lend Book</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">Delete Book</a>
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