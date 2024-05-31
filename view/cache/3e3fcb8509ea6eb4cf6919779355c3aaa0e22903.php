<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-light">Tickets</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Tickets</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">All Tickets</h5>

            <!-- Default Table -->
            <table class="table datatable" id="tickets-table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Customer</th>
                  <th scope="col">Phone</th>
                  <th scope="col">Route</th>
                  <th scope="col">Added On</th>
                  <th scope="col">Ticket Price</th>
                  <th scope="col">Seat Number</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <th scope="row"><?php echo e($loop->iteration); ?></th>
                  <td><?php echo e($ticket['name']); ?></td>
                  <td><?php echo e($ticket['phone']); ?></td>
                  <td><?php echo e($ticket['route']); ?></td>
                  <td><?php echo e($ticket['created_at']); ?></td>
                  <td>
                    <?php echo e($ticket['ticket_price']); ?>


                    <?php if($ticket['status'] == 'pending'): ?>
                    <span class="badge bg-danger">not-paid</span>
                    <?php elseif($ticket['status'] == 'cancelled'): ?>
                    <span class="badge bg-warning">ticket cancelled</span>
                    <?php else: ?>
                    <span class="badge bg-success">paid</span>
                    <?php endif; ?>

                  </td>
                  <td><?php echo e($ticket['seat_number']); ?></td>

                  <td>
                    <div class="dropdown">
                      <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Action
                      </button>
                      <?php if($currentUserId == $ticket['user_id']): ?>
                      <div class="dropdown-menu" aria-labelledby="actionDropdown">
                        <?php if($role == 'Administrator'): ?>

                        <?php if($ticket['status'] == 'paid'): ?>
                        <a class="dropdown-item" href="/<?php echo e($appName); ?>/routes/tickets/print/?id=<?php echo e($ticket['ticket_id']); ?>" id="print-btn">Print Out Ticket</a>
                        <?php endif; ?>

                        <?php if($ticket['status'] != 'paid' && $ticket['status'] != 'cancelled'): ?>
                        <a class="dropdown-item" href="/<?php echo e($appName); ?>/routes/tickets/pay/?id=<?php echo e($ticket['ticket_id']); ?>&amount=<?php echo e($ticket['ticket_price']); ?>" id="pay-btn">Pay Out Ticket</a>
                        <?php endif; ?>

                        <?php if($ticket['status'] == 'pending'): ?>
                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">Cancel Ticket</a>

                        <?php endif; ?>
                        <?php endif; ?>

                        <?php if($role == 'Customer'): ?>
                        <?php if($ticket['status'] == 'paid'): ?>
                        <a class="dropdown-item" href="/<?php echo e($appName); ?>/routes/tickets/print/?id=<?php echo e($ticket['ticket_id']); ?>" id="print-btn">Print Out Ticket</a>
                        <?php endif; ?>

                        <?php if($ticket['status'] != 'paid' && $ticket['status'] != 'cancelled'): ?>
                        <a class="dropdown-item" href="/<?php echo e($appName); ?>/routes/tickets/pay/?id=<?php echo e($ticket['ticket_id']); ?>&amount=<?php echo e($ticket['ticket_price']); ?>" id="pay-btn">Pay Out Ticket</a>
                        <?php endif; ?>

                        <?php if($ticket['status'] == 'pending'): ?>
                        <a class="dropdown-item text-danger" href="/<?php echo e($appName); ?>/routes/tickets/cancel/?id=<?php echo e($ticket['ticket_id']); ?>" id="cancel-ticket-btn">Cancel Ticket</a>

                        <?php endif; ?>
                        <?php endif; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                  </td>

                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              </tbody>
            </table>
            <!-- End Default Table Example -->
          </div>
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
          <div class="text-danger  p-1 mt-2">Note that this action will cancel your ticket and you will not book a ticket again today on the same route. Continue with caution because the action is undoable..</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Cancel My Ticket</button>
        </div>
      </div>
    </div>
  </div>

</main><!-- End #main -->

<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pdfModalLabel">PDF Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <iframe id="pdfIframe" width="100%" height="500px" frameborder="0"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Pay Confirmation Modal -->
<div class="modal fade" id="payConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="payConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="payConfirmationModalLabel">Proceed To Payment</h5>

      </div>
      <div class="modal-body">
        <p class="alert alert-warning text-dark">Are you sure you want to proceed with the payment? The money will not be refunded after payment.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="cancel-btn" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary" id="confirmPayBtn">Yes</button>
      </div>
    </div>
  </div>
</div>
<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




<script>
  $(document).ready(function() {
    var payUrl = '';

    $(document).on('click', '#pay-btn', function(event) {
      event.preventDefault();
      payUrl = $(this).attr('href');
      $('#payConfirmationModal').modal('show');
    });

    $('#confirmPayBtn').click(function() {
      window.location.href = payUrl;
    });

    $('#cancel-btn').click(function() {
      $('#payConfirmationModal').modal('hide');

    })

    $('#tickets-table').on('click', '#print-btn', function(event) {
      event.preventDefault();

      var printUrl = $(this).attr('href');

      $.ajax({
        url: printUrl,
        method: 'post',
        processData: false,
        contentType: false,
        success: function(response) {

          var pdfData = response;

          $("#pdfIframe").attr("src", "data:application/pdf;base64," + pdfData);

          // Open the Bootstrap modal
          $("#pdfModal").modal("show");
        },
        error: function(xhr, status, error) {
          console.error("Error:", error);
        }
      });

    })

    $('#tickets-table').on('click', '#cancel-ticket-btn', function(event) {
        event.preventDefault();

        var removeUrl = $(this).attr('href');

        $('#confirmDeleteModal').modal('show');
        $('#cancel-btn').click(function() {
            $('#confirmDeleteModal').modal('hide');

        })

        $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
            $.post(removeUrl, function(response) {
                Toastify({
                    text: response.message || 'Ticket Cancelled successfully',
                    duration: 2000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: 'green',
                }).showToast();

                setTimeout(function() {
                    window.location.reload();

                }, 3000)
            });
        });
    })
  });
</script>