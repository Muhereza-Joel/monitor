<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <form class="needs-validation card p-4" novalidate id="check-in-form" enctype="multipart/form-data">
        <div class="pagetitle">
            <h1>Users in the library</h1>
            <div class="d-flex">
                <nav class="w-50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/users/">Users</a></li>
                        <li class="breadcrumb-item active">Check In</li>
                    </ol>
                </nav>
                <div class="buttons-container align-self-center w-50 text-end">

                </div>
            </div>
        </div><!-- End Page Title -->
        <hr>
        <section class="section dashboard">
            <div class="row">
                <div class="col-sm-4 p-3" style="border: 1px solid #ccc;">
                    <div class="d-flex align-items-center">
                        <div class="form-group">
                            <label for="search-query-two">Username or Email</label>
                            <input autocomplete="off" class="form-control" placeholder="Username or email" type="text" id="search-query-two" required>
                            <div class="invalid-feedback">Please provide username or email</div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm mx-2 mt-4" id="search-user-btn">Search</button>
                        </div>

                    </div>

                    <div class="d-flex flex-column justify-content-center my-3">
                        <div class="text-center">
                            <img id="user-avator" src="http://localhost/<?php echo e($appName); ?>/assets/img/avatar.png" alt="avator" width="150" height="150" class="rounded-circle mt-3">

                        </div>
                        <div class="form-group">
                            <label for="">Full Name</label>
                            <input id="fullname" type="text" class="form-control" readonly required>
                            <div class="invalid-feedback">Please search user to get the name</div>
                            <input id="user-id" name="user-id" type="hidden">

                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input id="email" type="text" class="form-control" readonly required>
                            <div class="invalid-feedback">Please search user to get the email</div>
                        </div>
                    </div>
                    <?php if($role == 'Administrator'): ?>
                    <input class="btn btn-primary btn-sm" type="submit" value="Check In User" />
                    <?php endif; ?>
                </div>

                <div class="col-sm-8">
                    <div class="">
                        <div class="card-body">
                            <h5 class="card-title">Users In the library</h5>

                            <!-- Table with stripped rows -->
                            <table class="table table-striped datatable" id="users-table">
                                <thead>
                                    <tr>
                                        <th scope="col">SNo.</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Checked</th>
                                        <th scope="col">Class</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e($loop->iteration); ?></th>
                                        <td><?php echo e($user['fullname']); ?></td>
                                        <td><?php echo e($user['checkin_moment']); ?></td>
                                        <td>
                                            <?php if($user['class'] == null): ?>
                                            <span class="badge bg-info">Not a student</span>
                                            <?php else: ?>
                                            <?php echo e($user['class']); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><a class="btn btn-primary btn-sm p-1" id="checkout-btn" href="/<?php echo e($appName); ?>/users/checkout/?id=<?php echo e($user['checkin_id']); ?>">Check Out</a></td>
                                    </tr>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <div>

                            </div>
                        </div>
                        <div class="col-sm-7 mt-3">

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </form>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Your Action</h5>

                </div>
                <div class="modal-body">
                    <h6 class="text-dark">Are you sure you want to execute this action?</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDeleteBtn" class="btn btn-success btn-sm">Yes, Checkout User</button>
                </div>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {


        $('#check-in-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity()) {

                var formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/<?php echo e($appName); ?>/users/checkin/',
                    data: formData,
                    success: function(response) {
                        Toastify({
                            text: response.message,
                            duration: 2000,
                            gravity: 'bottom',
                            backgroundColor: '#161b22',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload()
                        }, 3000)
                    },
                    error: function(response) {
                        const errorMessage = response.message || 'User already checked in, cannot check in user again...';

                        Toastify({
                            text: errorMessage,
                            duration: 4000,
                            gravity: 'bottom',
                            backgroundColor: 'red',
                        }).showToast();

                    }
                })
            }

        })

        $("#search-user-btn").click(function() {

            $.ajax({
                method: 'post',
                url: '/<?php echo e($appName); ?>/books/lend/search-user/?search_term=' + $("#search-query-two").val(),
                success: function(response) {
                    if (response == null) {
                        Toastify({
                            text: "User Details Not Found",
                            duration: 2000,
                            gravity: 'bottom',
                            backgroundColor: '#161b22',
                        }).showToast();

                    }

                    if (response != null) {

                        $('#fullname').val(response.fullname);
                        $('#email').val(response.email);
                        $('#user-id').val(response.user_id);
                        $('#user-avator').attr('src', response.image_url);
                    }

                },

            })
        })

        $('#users-table').on('click', '#checkout-btn', function(event) {
            event.preventDefault();

            var removeUrl = $(this).attr('href');

            $('#confirmDeleteModal').modal('show');
            $('#cancel-btn').click(function() {
                $('#confirmDeleteModal').modal('hide');

            })

            $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
                $.post(removeUrl, function(response) {
                    Toastify({
                        text: response.message || 'User checked out successfully',
                        duration: 2000,
                        gravity: 'bottom',
                        backgroundColor: 'green',
                    }).showToast();

                    setTimeout(function() {
                        window.location.reload();

                    }, 2500)
                });
            });
        })
    })
</script>