<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create New Organizations</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Create Organizations</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-1">
            <div class="col-sm-4">
                <div class="card p-2">
                    <div class="card-title">Create Organization</div>
                    <div class="card-body">
                        <small class="text-success">Organizations help to organize user accounts, profiles, indicators, and responses to their respective Organizations, and only members can modify but the rest only view.</small>
                        <hr>
                        <form id="organization-registration-form" class="row g-3 needs-validation" novalidate>
                            <div class="form-group my-2">
                                <label for="">Organization Logo</label>
                                <div class="text-center">
                                    <img id="profile-photo" src="/<?php echo e($appName); ?>/assets/img/placeholder.png" class="rounded-circle" alt="Profile" width="200px" height="200px" style="border: 3px solid #999; object-fit: cover;">
                                </div>
                                <div class="pt-2">
                                    <input type="hidden" name="image_url" id="image_url">
                                    <input type="file" name="image" id="image" class="btn btn-outline btn-sm" required accept="image/jpeg, image/png">
                                    <div class="invalid-feedback">Please choose organization logo</div>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Organization Name</label>
                                <input type="text" class="form-control" name="organization-name" id="organization-name" required>
                                <div class="invalid-feedback">Organization name is required</div>
                            </div>

                            <div class="text-start mt-3">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="card p-2">
                    <h5 class="card-title">Current Registered Organizations</h5>

                    <div class="card-body">
                        <?php if(count($organisations) == 0): ?>
                        <div class="alert alert-warning text-center" role="alert">
                            <strong>No organizations found!</strong> Please register an organization to get started.
                        </div>
                        <?php else: ?>
                        <div class="row g-1" style="display: flex; flex-wrap: wrap;">
                            <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-sm-4 d-flex">
                                <div class="card p-2 flex-fill">
                                    <div class="card-title">
                                        <?php echo e($row['name']); ?>

                                        <?php if($row['active'] == 'true'): ?>
                                        <span class="badge bg-success text-light">Active</span>
                                        <?php else: ?>
                                        <span class="badge bg-danger text-light">Inactive</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="card-body text-center">
                                        <img style="width: 150px; object-fit: contain; border: 3px solid #999" src="<?php echo e($row['logo']); ?>" alt="logo" class="rounded-circle">
                                    </div>
                                    <a href="/<?php echo e($appName); ?>/dashboard/organizations/edit/<?php echo e($row['id']); ?>" class="btn btn-success btn-sm">Edit Organisation Details</a>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#organization-registration-form').submit(function(e) {
            e.preventDefault();

            if (this.checkValidity() === true) {
                let orgName = $('#organization-name').val().trim();

                if (orgName.toLowerCase() === 'administrator') {
                    Toastify({
                        text: "Organization name cannot be 'Administrator'",
                        duration: 4000,
                        gravity: 'bottom',
                        position: 'left',
                        backgroundColor: 'red',
                    }).showToast();
                    return false;
                }

                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/<?php echo e($appName); ?>/organisations/create/',
                    data: formData,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Row Created Successfully",
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
        });

        $('#image').on('change', function() {
            let formData = new FormData();
            formData.append('image', this.files[0]);

            $.ajax({
                method: 'post',
                url: '/<?php echo e($appName); ?>/image-upload/',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#image_url').val("<?php echo e($baseUrl); ?>/uploads/images/" + response);
                    $('#profile-photo').attr('src', "<?php echo e($baseUrl); ?>/uploads/images/" + response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An Error occurred, failed to upload image');
                }
            })
        });
    });
</script>