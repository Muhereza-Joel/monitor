<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-dark">Manage Products Inventory</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Inventory</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-2">
            <?php if($role == 'Administrator'): ?>
            <div class="col-sm-3">
                <form action="" class="form needs-validation" novalidate id="create-inventory-form">
                    <?php echo $__env->make('selectBranchAndStore', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <div class="card p-2">
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select name="product-id" id="product-select" class="form-control" required>
                                <option value="">Select Product</option>
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($product['id']); ?>"><?php echo e($product['title']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="invalid-feedback">Please select the product.</div>
                        </div>

                        <div class="form-group">
                            <input required type="number" name="buying-price" class="form-control my-2" placeholder="Unit Buying Price in Ugx">
                            <div class="invalid-feedback">Please provide the buying price</div>
                        </div>
                        <div class="form-group">
                            <input required type="number" name="selling-price" class="form-control my-2" placeholder="Unit Selling Price in Ugx">
                            <div class="invalid-feedback">Please provide the selling price</div>
                        </div>
                        <div class="form-group">
                            <div class="row g-1">
                                <div class="col-sm-7">
                                    <input required type="number" name="quantity" class="form-control my-2" placeholder="Quantity">
                                </div>
                                <div class="col-sm-5">
                                    <select name="units" id="units" class="form-control my-2">
                                        <option value="">Select Units</option>
                                        <option value="Litres">Litres</option>
                                        <option value="Kilograms">Kilograms</option>
                                        <option value="Items">Items</option>
                                        <option value="Sheets">Sheets</option>
                                        <option value="Bags">Bags</option>
                                        <option value="Jerrycans">Jerrycans</option>
                                        <option value="Tins">Tins</option>
                                        <option value="Boxes">Boxes</option>
                                        <option value="Pieces">Pieces</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="invalid-feedback">Please provide product quantity</div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" value="Save Record">
                        </div>

                    </div>
                </form>
            </div>
            <?php endif; ?>


            <div class="col-sm-9">
                <?php if($role == 'Administrator'): ?>
                <div class="alert alert-info p-2 mt-2">
                    <strong>Please use the middle section to add new inventory to the current list. Use the Action dropdown to restock products on existing inventory.</strong>
                    This is a list of all current inventory levels of all products for all branches and stores.
                </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">

                        <!-- Table with stripped rows -->
                        <table class="table table-striped datatable" id="inventory-table">
                            <thead>
                                <tr>
                                    <th scope="">SNo.</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Store</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Sale Price</th>
                                    <th scope="col">Available</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $stock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th><?php echo e($loop->iteration); ?></th>
                                    <td><?php echo e($item['branch_name']); ?></td>
                                    <td><?php echo e($item['zone_name']); ?></td>
                                    <td><?php echo e($item['title']); ?></td>
                                    <td>Ugx <?php echo e($item['selling_price']); ?></td>
                                    <td><?php echo e($item['available_stock']); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                <?php if($role == 'Administrator' || $role == 'Staff'): ?>
                                                <a class="dropdown-item" href="/<?php echo e($appName); ?>/dashboard/inventory/re-stock?id=<?php echo e($item['id']); ?>">Re-Stock Product</a>
                                                <?php if($role == 'Administrator'): ?>
                                                <a class="dropdown-item" href="/<?php echo e($appName); ?>/dashboard/inventory/chage-price?id=<?php echo e($item['id']); ?>">Update Sale Price</a>
                                                <a class="dropdown-item text-danger" id="delete-stock-btn" href="/<?php echo e($appName); ?>/dashboard/stock/delete/?id=<?php echo e($item['id']); ?>">Delete Row</a>

                                                <?php endif; ?>
                                                <?php endif; ?>

                                                <a class="dropdown-item" href="/<?php echo e($appName); ?>/dashboard/inventory/create-order?id=<?php echo e($item['id']); ?>">Create New Order</a>
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
                    <div class="alert alert-danger p-1 mt-2">Note that this action will delete all inventory data including transactions related to this record. Continue with caution because this action is undoable..</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Delete Stock Record</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $('document').ready(function() {
        $('#parent-branch-drop-down').on('change', function() {

            var selectedBranch = $(this).val();

            $.ajax({
                url: '/<?php echo e($appName); ?>/dashboard/zones/get-zones-by-id/',
                method: 'GET',
                data: {
                    branch_id: selectedBranch
                },
                success: function(data) {

                    $('#parent-store-drop-down').empty();
                    $('#parent-store-drop-down').append('<option value="" >Select Store</option>');


                    $.each(data.stores, function(key, value) {
                        $('#parent-store-drop-down').append('<option value="' + value.id + '">' + value.zone_name + '</option>');
                    });
                },
                error: function(error) {
                    console.log('Error fetching data:', error);
                }
            });
        });

        $('#create-inventory-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "/<?php echo e($appName); ?>/dashboard/stock/add/",
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Record Saved Successfully...",
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

        $('#inventory-table').on('click', '#delete-stock-btn', function(event) {
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
                            text: response.message || "Stock Record Deleted Successfully...",
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