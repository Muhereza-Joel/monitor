<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Update Product Sale Price</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Change Sale Price</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard p-2">
        <div class="row">
            <div class="col-sm-8">
                <div class="card p-2">
                    <div class="card-title">Current Product Inventory Details</div>
                    <div class="card-body">
                        <div class="row my-2">
                            <div class="col-sm-3 fw-bold">Branch Name</div>
                            <div class="col-sm-6"><?php echo e($stockDetails['branch_name']); ?></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-sm-3 fw-bold">Store Name</div>
                            <div class="col-sm-6"><?php echo e($stockDetails['zone_name']); ?></div>
                        </div>
                        <div class="row my-2">
                            <div class="col-sm-3 fw-bold">Product Title</div>
                            <div class="col-sm-6"><?php echo e($stockDetails['title']); ?></div>
                        </div>

                        <div class="row my-2">
                            <div class="col-sm-3 fw-bold">Available Stock</div>
                            <div class="col-sm-6"><?php echo e($stockDetails['available_stock']); ?> <?php echo e($stockDetails['units']); ?></div>
                        </div>

                        <div class="row my-2">
                            <div class="col-sm-3 fw-bold">Unit Cost</div>
                            <div class="col-sm-6">Ugx <?php echo e($stockDetails['selling_price']); ?></div>
                        </div>
                        <form action="" class="needs-validation my-2" novalidate id="update-sale-price-form">

                            <hr>
                            <div class="form-group">
                                <label for="">New Sale Price</label>
                                <input type="hidden" name="stock-id" value="<?php echo e($stockDetails['id']); ?>">
                                <input type="number" required class="form-control" name="new-sale-price">
                                <div class="invalid-feedback">Please provide new sale price</div>
                            </div>

                            <div class="text-start my-2">
                                <button class="btn btn-primary btn-sm" type="submit">Update Sale Price</button>
                                <a href="/<?php echo e($appName); ?>/dashboard/inventory/" class="btn btn-danger btn-sm">Cancel Price Change</a>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {

        $('#update-sale-price-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "/<?php echo e($appName); ?>/dashboard/stock/change-sale-price/",
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Product Sale Price Updated Successfully...",
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
            }
        })

    })
</script>