<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Reports Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard p-2">
        <div class="card">
            <div class="card-body pt-2">

                <!-- Pills Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered mb-3" id="borderedTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-inventory-tab" data-bs-toggle="pill" data-bs-target="#pills-inventory-report" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Inventory Report</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-orders-in-process-tab" data-bs-toggle="pill" data-bs-target="#pills-orders-in-process" type="button" role="tab" aria-controls="pills-profile" aria-selected="false" tabindex="-1">Orders In Process Report</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-orders-complete-tab" data-bs-toggle="pill" data-bs-target="#pills-orders-complete" type="button" role="tab" aria-controls="pills-contact" aria-selected="false" tabindex="-1">Complete Orders Report</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="pills-inventory-report" role="tabpanel" aria-labelledby="inventory-tab">
                        <div class="d-flex my-2">
                            <div class="btn btn-success btn-sm" id="export-inventory-pdf-report-btn">Export To PDF</div>

                        </div>
                        <div class="card">
                            <div class="card-body">

                                <!-- Table with stripped rows -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="">SNo.</th>
                                            <th scope="col">Branch</th>
                                            <th scope="col">Store</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Stock Price</th>
                                            <th scope="col">Sale Price</th>
                                            <th scope="col">Available</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $stock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <th><?php echo e($loop->iteration); ?></th>
                                            <td><?php echo e($item['branch_name']); ?></td>
                                            <td><?php echo e($item['zone_name']); ?></td>
                                            <td><?php echo e($item['title']); ?></td>
                                            <td>Ugx <?php echo e($item['buying_price']); ?></td>
                                            <td>Ugx <?php echo e($item['selling_price']); ?></td>
                                            <td><?php echo e($item['available_stock']); ?></td>

                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->

                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-orders-in-process" role="tabpanel" aria-labelledby="orders-in-process-tab">
                        <div class="d-flex my-2">
                            <div class="btn btn-success btn-sm" id="export-in-process-orders-pdf-report-btn">Export To PDF</div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <!-- Table with stripped rows -->
                                <table class="table table-striped" id="orders-table">
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


                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->

                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-orders-complete" role="tabpanel" aria-labelledby="orders-complete-tab">
                        <div class="d-flex my-2">
                            <div class="btn btn-success btn-sm" id="export-complete-orders-pdf-report-btn">Export To PDF</div>
                        </div>

                        <div class="card">
                            <div class="card-body">

                                <!-- Table with stripped rows -->
                                <table class="table table-striped" id="orders-table">
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

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $completeOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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


                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->

                            </div>
                        </div>
                    </div>
                </div><!-- End Pills Tabs -->

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

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {

        $("#export-inventory-pdf-report-btn").on("click", function() {

            $.ajax({
                url: '/<?php echo e($appName); ?>/dashboard/inventory/print',
                method: 'POST',
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
        });

        $("#export-in-process-orders-pdf-report-btn").on("click", function() {

            $.ajax({
                url: '/<?php echo e($appName); ?>/dashboard/orders/in-process/print',
                method: 'POST',
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
        });

        $("#export-complete-orders-pdf-report-btn").on("click", function() {

            $.ajax({
                url: '/<?php echo e($appName); ?>/dashboard/orders/complete/print',
                method: 'POST',
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
        });


    })
</script>