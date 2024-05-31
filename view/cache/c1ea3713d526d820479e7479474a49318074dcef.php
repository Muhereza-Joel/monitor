<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="">Products Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Inventory</li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-2">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Table with stripped rows -->
                        <table class="table table-striped datatable" id="products-table">
                            <thead>
                                <tr>
                                    <th scope="col">SNo.</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Status</th>
                                    <?php if($role == 'Administrator' || $role == 'Staff'): ?>
                                    <th scope="col">Action</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                                    <td><?php echo e($item['title']); ?></td>
                                    <td><?php echo e($item['description']); ?></td>
                                    <td>
                                        <?php if($item['status'] == 'available'): ?>
                                        <span class="badge bg-success">Available</span>
                                        <?php else: ?>
                                        <span class="badge bg-success">Not Available</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                <?php if($role == 'Administrator' || $role == 'Staff'): ?>
                                                <a class="dropdown-item" href="/<?php echo e($appName); ?>/dashboard/inventory/products/?action=edit&id=<?php echo e($item['id']); ?>">Edit Product Details</a>
                                                <?php if($role == 'Administrator'): ?>
                                                <a class="dropdown-item text-danger" id="delete-product-btn" href="/<?php echo e($appName); ?>/dashboard/products/delete/?id=<?php echo e($item['id']); ?>">Delete Product</a>
                                                <?php endif; ?>
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

            <div class="col-sm-4">
                <?php if($role == 'Administrator' || $role == 'Staff'): ?>
                <?php if($action == 'edit'): ?>
                <div class="card p-2">
                    <div class="card-title">Edit Product Details</div>
                    <div class="card-body">
                        <form class="form needs-validation" novalidate id="update-product-form">

                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo e($product['id']); ?>">
                                <label for="product-name">Product Name</label>
                                <input value="<?php echo e($product['title']); ?>" type="text" name="title" required class="form-control" autocomplete="off">
                                <div class="invalid-feedback">Please provide product title.</div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="description">Product Description</label>
                                <textarea name="description" id="" class="form-control" required><?php echo e($product['description']); ?></textarea>
                                <div class="invalid-feedback">Please provide product description.</div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="status">Product Status</label>
                                <select name="status" id="" class="form-control" required>
                                    <option value=""></option>
                                    <option value="available" <?php echo e($product['status'] == 'available' ? 'selected' : ''); ?>>Available</option>
                                    <option value="not-available" <?php echo e($product['status'] == 'not-available' ? 'selected' : ''); ?>>Not Available</option>
                                </select>
                                <div class="invalid-feedback">Please provide product status...</div>
                            </div>

                            <div class="mt-2 text-start">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <a href="/<?php echo e($appName); ?>/dashboard/inventory/products/" class="btn btn-danger btn-sm">Cancel</a>
                            </div>
                        </form>

                    </div>
                </div>
                <?php endif; ?>

                <?php if($role == 'Administrator'): ?>
                <div class="card p-2">
                    <div class="card-title">Create New Product</div>
                    <div class="card-body">
                        <form class="needs-validation" id="create-product-form" novalidate>

                            <div class="form-group">
                                <label for="product-name">Product Name</label>
                                <input type="text" name="title" required class="form-control" autocomplete="off">
                                <div class="invalid-feedback">Please provide product title.</div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="description">Product Description</label>
                                <textarea name="description" id="" class="form-control" required></textarea>
                                <div class="invalid-feedback">Please provide product description.</div>
                            </div>

                            <div class="form-group mt-2">
                                <label for="status">Product Status</label>
                                <select name="status" id="" class="form-control" required>
                                    <option value=""></option>
                                    <option value="available">Available</option>
                                    <option value="not-available">Not Available</option>
                                </select>
                                <div class="invalid-feedback">Please provide product status...</div>
                            </div>

                            <div class="mt-2 text-start">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>

                    </div>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>
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
                    <div class="alert alert-danger p-1 mt-2">Note that this action will delete this product and will also delete all inventory data related to this product. Continue with caution because this action is undoable..</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Delete Product</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {

        $('#create-product-form').submit(function(event) {

            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: '/<?php echo e($appName); ?>/dashboard/products/add/',
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Product Saved Successfully...",
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

        $('#update-product-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "/<?php echo e($appName); ?>/dashboard/products/edit/",
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Product Updated Successfully...",
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

        $('#products-table').on('click', '#delete-product-btn', function(event) {
            event.preventDefault();

            var removeUrl = $(this).attr('href');

            $('#confirmDeleteModal').modal('show');
            $('#confirmDeleteBtn').on('click', function(event) {
                $('#confirmDeleteModal').modal('hide');

                $.ajax({
                    method: 'POST',
                    url: removeUrl,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Product Deleted Successfully...",
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

            $('#cancel-btn').on('click', function(event) {
                $('#confirmDeleteModal').modal('hide');
            })
        })
    })
</script>