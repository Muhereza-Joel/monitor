<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Orders / Requests</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row px-2">
            <div class="alert alert-info p-2 mt-2">
                <strong>Please note that only pending and orders in process are shown here. Complete orders are considered complete and are not shown here.
                    Please remeber to use the Action dropdown to complete orders when the customer presents his payment receipt to you.
                </strong>
                
            </div>
            <div class="card">
                <div class="card-body">

                    <?php if($role == 'Customer'): ?>
                    <div class="alert alert-warning mt-3">
                        Please note that you are currently viewing orders with a status of pending and processing. Orders with a status of complete are not shown here.
                    </div>
                    <?php endif; ?>

                    <!-- Table with stripped rows -->
                    <table class="table table-striped datatable" id="orders-table">
                        <thead>
                            <tr>
                                <th scope="col">SNo.</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Placed</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <th scope="row"><?php echo e($loop->iteration); ?></th>
                                <td><?php echo e($item['name']); ?></td>
                                <td><?php echo e($item['phone']); ?></td>
                                <td><?php echo e($item['title']); ?></td>
                                <td><?php echo e($item['order_quantity']); ?></td>
                                <td>Ugx <?php echo e($item['total_amount_due']); ?></td>
                                <td>
                                    <?php if($item['status'] == 'pending'): ?>
                                    <span class="badge bg-warning">order pending</span>
                                    <?php elseif($item['status'] == 'processing'): ?>
                                    <span class="badge bg-success">order in process</span>
                                    <?php else: ?>
                                    <span class="badge bg-dark">order complete</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($item['created_at']); ?></td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Select Action
                                        </button>

                                        <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                            <?php if($role == 'Administrator' || $role == 'Staff'): ?>
                                            <a class="dropdown-item" href="/<?php echo e($appName); ?>/dashboard/stock/orders/complete/?id=<?php echo e($item['id']); ?>" id="complete-order-btn">Complete Order</a>
                                            <?php endif; ?>

                                            <?php if($item['user_id'] == $current_user_id && $item['status'] != 'processing'): ?>
                                            <a class="dropdown-item text-success" href="/<?php echo e($appName); ?>/dashboard/orders/pay?id=<?php echo e($item['id']); ?>&amount=<?php echo e($item['total_amount_due']); ?>" id="pay-btn">Pay Out Order</a>
                                            <?php endif; ?>

                                            <?php if($item['user_id'] == $current_user_id && $item['status'] == 'processing'): ?>
                                            <a class="dropdown-item text-success" href="/<?php echo e($appName); ?>/dashboard/orders/receipt/print?id=<?php echo e($item['id']); ?>" id="print-btn">Print Receipt</a>
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
                    <p class="alert alert-warning text-dark">After completing this transaction, you will be required to print out your receipt. You have to come along with it at the store where placed your order for verification.
                        <br><strong>The reciept is required to pick your items</strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm" id="confirmPayBtn">Start Transaction</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmCompleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="confirmCompleteOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="CompleteOrderModalLabel">Confirm Your Action</h5>

                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Are you sure you want to execute this action?</h6>
                    <div class="alert alert-info p-1 mt-2">Note that this action will mark this order as complete and the customer will nologer print out his payment receipt.
                        <strong>Its better to complete orders only if the customer has received his order items</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-complete-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmCompleteOrderBtn" class="btn btn-success btn-sm">Yes, Complete Order</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {

        $("#orders-table").on('click', '#pay-btn', function(event) {
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

        $('#orders-table').on('click', '#print-btn', function(event) {
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

        $('#orders-table').on('click', '#complete-order-btn', function(event) {
            event.preventDefault();

            var completeUrl = $(this).attr('href');

            $('#confirmCompleteOrderModal').modal('show');
            $('#confirmCompleteOrderBtn').on('click', function(event) {
                $('#confirmCompleteOrderModal').modal('hide');

                $.ajax({
                    method: 'POST',
                    url: completeUrl,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Order Completed Successfully...",
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'green',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload();
                        }, 2000)
                    },
                    error: function() {}
                })
            })

            $('#cancel-complete-btn').on('click', function(event) {
                $('#confirmCompleteOrderModal').modal('hide');
            })
        })
    })
</script>