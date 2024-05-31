<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Lent Books</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/books/">Books</a></li>
        <li class="breadcrumb-item active">Lent</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row m-2">

      <div class="card">
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-bordered" id="books-table">
            <thead>
              <tr>
                <th>
                  Book Title
                </th>
                <th>Borrower</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Picked</th>
                <th>Return Status</th>

                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($book['title']); ?></td>
                <td><?php echo e($book['fullname']); ?></td>
                <td>
                  <?php if($book['class'] == null): ?>
                  N/A
                  <?php else: ?>
                  <?php echo e($book['class']); ?>

                  <?php endif; ?>
                </td>
                <td><?php echo e($book['subject']); ?></td>
                <td><?php echo e($book['pickup_date']); ?></td>
                <td>
                  <small>Agreed Return Date <?php echo e($book['return_date']); ?></small>
                  <?php if($book['return_status'] == 'Still Valid'): ?>
                  <span class="badge bg-info"><?php echo e($book['return_status']); ?></span>
                  <?php else: ?>
                  <span class="badge bg-warning"><?php echo e($book['return_status']); ?></span>
                  <?php endif; ?>
                </td>

                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      <?php if($role == 'Administrator'): ?>

                      <a class="dropdown-item" href="/<?php echo e($appName); ?>/books/edit/?id=<?php echo e($book['book_id']); ?>">View Book Details</a>
                      <a class="dropdown-item" id="return-btn" href="/<?php echo e($appName); ?>/books/return/?id=<?php echo e($book['record_id']); ?>">Return Book</a>
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

  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-success p-1 mt-2">Note that this action will return the book to inventory.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-success btn-sm">Yes, Return Book</button>
        </div>
      </div>
    </div>
  </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    $('#books-table').on('click', '#return-btn', function(event) {
      event.preventDefault();

      var removeUrl = $(this).attr('href');

      $('#confirmDeleteModal').modal('show');
      $('#cancel-btn').click(function() {
        $('#confirmDeleteModal').modal('hide');

      })

      $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
        $.post(removeUrl, function(response) {
          Toastify({
            text: response.message || 'Book returned successfully',
            duration: 2000,
            gravity: 'bottom',
            backgroundColor: 'green',
          }).showToast();

          setTimeout(function() {
            window.location.reload();

          }, 3000)
        });
      });
    })
  })
</script>