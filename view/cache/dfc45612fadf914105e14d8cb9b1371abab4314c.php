<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Routes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Routes</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All Bus Routes/ Journeys</h5>

                        <!-- Default Table -->
                        <table class="table" id="routes-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">From</th>
                                    <th scope="col">Destination</th>
                                    <th scope="col">Depature</th>
                                    <th scope="col">Ticket Price</th>
                                    <?php if($role == 'Administrator'): ?>
                                    <th scope="col">Threshold Time</th>
                                    <?php endif; ?>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $routes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <th scope="row"><?php echo e($loop->iteration); ?></th>
                                    <td><?php echo e($route['origin']); ?></td>
                                    <td><?php echo e($route['destination']); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::createFromFormat('H:i:s.u', $route['depature_time'])->format('h:i A')); ?></td>
                                    <td><?php echo e($route['ticket_price']); ?></td>
                                    <?php if($role == 'Administrator'): ?>
                                    <td><?php echo e($route['threshold']); ?> hours</td>
                                    <?php endif; ?>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Select Action
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="actionDropdown">
                                                <a href="/<?php echo e($appName); ?>/dashboard/routes/tickets/book-now?id=<?php echo e($route['id']); ?>" class="dropdown-item">Book Ticket</a>
                                                <?php if($role == 'Administrator'): ?>

                                                <a href="/<?php echo e($appName); ?>/dashboard/routes/?action=edit&id=<?php echo e($route['id']); ?>" class="dropdown-item">Edit Route/ Journey</a>
                                                <a href="/<?php echo e($appName); ?>/routes/delete/?id=<?php echo e($route['id']); ?>" id="delete-route-btn" class="dropdown-item text-danger">Delete Route</a>

                                                <?php endif; ?>
                                            </div>
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

            <?php if($role == 'Administrator'): ?>
            <div class="col-sm-4">

                <?php if($action == 'edit'): ?>
                <div class="card p-2">
                    <div class="card-title ms-2">Edit Route / Journey Details
                    </div>
                    <div class="card-body">
                        <form action="" class="needs-validation" id="edit-route-form" novalidate>
                            <div class="form-group">
                                <label for="from">From</label>
                                <input type="hidden" name="route-id" value="<?php echo e($routeDetails['id']); ?>">
                                <input value="<?php echo e($routeDetails['origin']); ?>" placeholder="For example Kabarole" required autocomplete="off" type="text" class="form-control" id="from" name="from">
                                <div class="invalid-feedback">Provide starting location</div>
                            </div>
                            <div class="form-group">
                                <label for="destination">Destination</label>
                                <input value="<?php echo e($routeDetails['destination']); ?>" placeholder="For example kampala" required autocomplete="off" type="text" class="form-control" id="destination" name="destination">
                                <div class="invalid-feedback">Provide final destination</div>
                            </div>
                            <div class="form-group">
                                <label for="price">Ticket Price</label>
                                <input value="<?php echo e($routeDetails['ticket_price']); ?>" placeholder="For example Ugx1000" required autocomplete="off" type="text" class="form-control" id="price" name="price">
                                <div class="invalid-feedback">Provide price for a single ticket</div>
                            </div>
                            <div class="form-group">
                                <label for="threshold">Threshold Time in hours</label>
                                <input value="<?php echo e($routeDetails['threshold']); ?>" required autocomplete="off" min="1" max="48" type="number" class="form-control" id="threshold-time" name="threshold">
                                <small class="my-3 text-success">This is the time a traveller is required to book a ticket before the journey</small>
                                <div class="invalid-feedback">Provide allowed time before booking a ticket, it should be between 1 hour and 3 hours.</div>
                            </div>
                            <div class="form-group mt-3">

                                <span>Current Depature Time: <?php echo e($routeDetails['depature_time']); ?></span>
                                <input value="<?php echo e($routeDetails['depature_time']); ?>" required autocomplete="off" type="time" class="form-control" id="depature-time" name="depature">
                                <div class="invalid-feedback">Provide depature time for the bus</div>
                            </div>

                            <div class="text-start mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                <a href="/<?php echo e($appName); ?>/dashboard/routes/" class="btn btn-danger btn-sm">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
                <div class="card p-2">
                    <div class="card-title ms-2">Create New Route
                    </div>
                    <div class="card-body">
                        <form action="" class="needs-validation" id="create-route-form" novalidate>
                            <div class="form-group">
                                <label for="from">From</label>
                                <input placeholder="For example Kabarole" required autocomplete="off" type="text" class="form-control" id="from" name="from">
                                <div class="invalid-feedback">Provide starting location</div>
                            </div>
                            <div class="form-group">
                                <label for="destination">Destination</label>
                                <input placeholder="For example kampala" required autocomplete="off" type="text" class="form-control" id="destination" name="destination">
                                <div class="invalid-feedback">Provide final destination</div>
                            </div>
                            <div class="form-group">
                                <label for="price">Ticket Price</label>
                                <input placeholder="For example Ugx1000" required autocomplete="off" type="text" class="form-control" id="price" name="price">
                                <div class="invalid-feedback">Provide price for a single ticket</div>
                            </div>
                            <div class="form-group">
                                <label for="threshold">Threshold Time in hours</label>
                                <input required autocomplete="off" min="1" max="48" type="number" class="form-control" id="threshold-time" name="threshold">
                                <small class="my-3 text-success">This is the time a traveller is required to book a ticket before the journey</small>
                                <div class="invalid-feedback">Provide allowed time before booking a ticket, it should be between 1 hour and 3 hours.</div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="depature-time">Depature Time</label>
                                <input required autocomplete="off" type="time" class="form-control" id="depature-time" name="depature">
                                <div class="invalid-feedback">Provide depature time for the bus</div>
                            </div>

                            <div class="text-start mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

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
                    <div class="text-danger fw-bold p-1 mt-2">Note that this action will delete this route and all tickets booked for this route. Continue with caution because the action is undoable..</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Delete Route</button>
                </div>
            </div>
        </div>
    </div>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#create-route-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() == true) {

                let formData = new FormData(this);

                $.ajax({
                    method: "post",
                    url: "/<?php echo e($appName); ?>/routes/create/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Route Saved Successfully",
                            duration: 3000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#32a852',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload()
                        }, 3500)
                    },

                    error: function(jqXHR, textStatus, errorThrow) {
                        if (jqXHR.status === 401) {

                            Toastify({
                                text: jqXHR.responseJSON.message,
                                duration: 4000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: 'red',
                            }).showToast();

                        }
                    }
                })
            }
        })

        $('#edit-route-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() == true) {

                let formData = new FormData(this);

                $.ajax({
                    method: "post",
                    url: "/<?php echo e($appName); ?>/routes/update/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Route Updated Successfully",
                            duration: 3000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#32a852',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload()
                        }, 3500)
                    },

                    error: function(jqXHR, textStatus, errorThrow) {
                        if (jqXHR.status === 401) {

                            Toastify({
                                text: jqXHR.responseJSON.message,
                                duration: 4000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: 'red',
                            }).showToast();

                        }
                    }
                })
            }
        })
    })

    $('#routes-table').on('click', '#delete-route-btn', function(event) {
        event.preventDefault();

        var removeUrl = $(this).attr('href');

        $('#confirmDeleteModal').modal('show');
        $('#cancel-btn').click(function() {
            $('#confirmDeleteModal').modal('hide');

        })

        $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
            $.post(removeUrl, function(response) {
                Toastify({
                    text: response.message || 'Route Deleted successfully',
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
</script>