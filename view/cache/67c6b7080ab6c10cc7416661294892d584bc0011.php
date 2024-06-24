<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create New Monitor User.</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Create User</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-1">
            <div class="col-sm-5">
                <div class="card p-2">
                    <div class="card-title">Create New Organisation User</div>
                    
                    <div class="card-body">
                        <div id="invalid-registration" class="alert alert-danger alert-dismissible fade d-none p-1" role="alert">
                            <span class="text-center"></span>
                        </div>
                        <form id="registration-form" class="row g-3 needs-validation" novalidate>

                            <div class="col-12">
                                <label for="yourEmail" class="form-label">Email Address of User</label><br>
                                <small class="text-success">Note that the email should be valid, because its used during password resets.</small>
                                <input type="email" name="email" class="form-control" id="yourEmail" required placeholder="Please Enter Email adddress Here">
                                <div class="invalid-feedback">This value is required</div>
                            </div>

                            <div class="col-12">
                                <label for="yourUsername" class="form-label">Username</label><br>
                                <small class="text-success">Note that the username can also be used during logins.</small>
                                <div class="input-group has-validation">
                                    <input type="text" name="username" class="form-control" id="yourUsername" required placeholder="Enter a login username here">
                                    <div class="invalid-feedback">This value is required.</div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="yourPassword" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="yourPassword" required placeholder="Enter your password here">
                                <div class="invalid-feedback">This value is required.</div>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Select user role</option>
                                    <option value="Administrator">Administrator</option>
                                    <option value="Viewer">Viewer</option>
                                    <option value="User">User</option>

                                </select>
                                <div class="invalid-feedback">This value is required</div>
                            </div>
                            
                            <div class="form-group">
                                <label for="role">Organization</label>
                                <select name="organisation" id="role" class="form-control" required>
                                    <option value="">Select organisation</option>
                                    
                                    <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($row['id']); ?>"><?php echo e($row['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                                <div class="invalid-feedback">This value is required</div>
                            </div>


                            <div class="col-12">
                                <button id="submit-button" class="btn btn-primary btn-sm" type="submit">Create User</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="card p-2">
                    <div class="card-title">User Roles Explanation</div>
                    <div class="card-body">
                        <h5 class="card-title">Administrator</h5>
                        <p class="card-text">Administrators can add and manage indicators, manage responses, manage user accounts and roles, and have full access to all data and system settings.</p>
                        
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">Users can create indicators and responses as well, view all data (indicators, responses), modify there responses but cannot  delete any data.</p>

                        <h5 class="card-title">Viewers</h5>
                        <p class="card-text">Viewers can view all data (indicators, responses, user profiles) but cannot add, modify, or delete any data.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#registration-form').submit(function(e) {
            e.preventDefault();

            if (this.checkValidity() === true) {


                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/<?php echo e($appName); ?>/auth/organisation/create-account/',
                    data: formData,
                    success: function(response) {
                        Toastify({
                            text: response.message,
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'green',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload();
                        }, 3000)


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 401) {

                            Toastify({
                                text: jqXHR.responseJSON.message,
                                duration: 4000,
                                gravity: 'bottom',
                                position: 'left',
                                backgroundColor: 'red',
                            }).showToast();

                            $('#submit-button').attr('disabled', false);
                            $("#submit-button").text("Create Account")

                        }
                    }
                })
            }

        })
    })
</script>