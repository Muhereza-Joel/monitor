<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Update User Information</h1>
        <div class="d-flex">
            <nav class="w-50">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>


        </div>
    </div><!-- End Page Title -->
    <section class="section profile">
        <!-- Profile Edit Form -->
        <form class="needs-validation" novalidate id="create-profile-form" enctype="multipart/form-data">
            <section class="section register min-vh-100">
                <div class="container">


                    <div class="row">
                        <div class="col-xl-1"></div>
                        <div class="col-xl-4">
                            <div class="text-center">
                                <img id="profile-photo" src="<?php echo e($userDetails['image_url']); ?>" class="rounded-circle" alt="Profile" width="300px" height="300px" style="border: 3px solid #999; object-fit: cover;">
                                <input value="<?php echo e($userDetails['image_url']); ?>" type="hidden" name="image_url" id="image_url">
                                <input type="file" name="image" id="image" class="btn btn-outline btn-sm" accept="image/jpeg">
                                <div class="invalid-feedback">Please choose a profile photo</div>
                            </div>

                        </div>

                        <div class="col-xl-6">

                            <div class="">
                                <div class="card-body pt-3">



                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input value="<?php echo e($userDetails['user_id']); ?>"  name="current-user-id" type="hidden">
                                            <input value="<?php echo e($userDetails['fullname']); ?>" oninput="capitalizeEveryWord(this)" name="fullName" type="text" class="form-control" id="fullName" placeholder="Enter your full name here" required>
                                            <div class="invalid-feedback">Please enter your full name.</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input value="<?php echo e($userDetails['email']); ?>" name="email" type="text" class="form-control" id="email" placeholder="Enter your full name here" required>
                                            <div class="invalid-feedback">Please enter your email address.</div>
                                            <small id="email-status" class="text-success fw-bold"></small>
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <label for="nin" class="col-md-4 col-lg-3 col-form-label">NIN Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <small class="text-danger">Optional</small>
                                            <input value="<?php echo e($userDetails['nin']); ?>" pattern="[A-Z0-9]{14}" min="14" name="nin" type="text" class="form-control" id="nin" placeholder="Enter your nin number">
                                            <div class="invalid-feedback">Please enter a valid NIN number with digits, letters, no spaces and 14 characters long.</div>
                                            <small id="nin-status" class="text-success fw-bold"></small>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="school-i" class="col-md-4 col-lg-3 col-form-label">School ID Number</label>
                                        <div class="col-md-8 col-lg-9">
                                            <small class="text-danger">Optional</small>
                                            <input value="<?php echo e($userDetails['school_id']); ?>" name="school-id" type="text" class="form-control" id="school-id" placeholder="Enter your school id">
                                            <div class="invalid-feedback">Please enter your school id number.</div>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="class_level" class="col-md-4 col-lg-3 col-form-label">Class</label>
                                        <div class="col-md-8 col-lg-9">

                                            <select class="form-control" name="class_level" id="class_level" required>
                                                <option value="">Select Class</option>
                                                <option value="Senior One" <?php echo e($userDetails['class'] == 'Senior One' ? 'selected' : ''); ?>>Senior One</option>
                                                <option value="Senior Two" <?php echo e($userDetails['class'] == 'Senior Two' ? 'selected' : ''); ?>>Senior Two</option>
                                                <option value="Senior Three" <?php echo e($userDetails['class'] == 'Senior Three' ? 'selected' : ''); ?>>Senior Three</option>
                                                <option value="Senior Four" <?php echo e($userDetails['class'] == 'Senior Four' ? 'selected' : ''); ?>>Senior Four</option>
                                                <option value="Senior Five" <?php echo e($userDetails['class'] == 'Senior Five' ? 'selected' : ''); ?>>Senior Five</option>
                                                <option value="Senior Six" <?php echo e($userDetails['class'] == 'Senior Six' ? 'selected' : ''); ?>>Senior Six</option>
                                                <option value="Other" <?php echo e($userDetails['class'] == 'Other' ? 'selected' : ''); ?>>Other</option>
                                            </select>


                                            <div class="invalid-feedback">Please select your class.</div>

                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input value="<?php echo e($userDetails['country']); ?>" oninput="capitalizeFirstLetter(this)" name="country" type="text" class="form-control" id="Country" placeholder="Enter your home Country" required>
                                            <div class="invalid-feedback">Please enter your home coutry.</div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Home District" class="col-md-4 col-lg-3 col-form-label">Home District</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input value="<?php echo e($userDetails['district']); ?>" oninput="capitalizeFirstLetter(this)" name="district" type="text" class="form-control" id="Home District" placeholder="Enter your home district" required>
                                            <div class="invalid-feedback">Please enter your home district.</div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="village" class="col-md-4 col-lg-3 col-form-label">Village</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input value="<?php echo e($userDetails['village']); ?>" oninput="capitalizeFirstLetter(this)" name="village" type="text" class="form-control" id="village" placeholder="Enter the village you come from" required>
                                            <div class="invalid-feedback">Please enter the village you come from.</div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input value="<?php echo e($userDetails['phone']); ?>" pattern="[+]?[0-9]+" name="phone" type="text" class="form-control" id="Phone" placeholder="Enter your phone number" required>
                                            <div class="invalid-feedback">Please enter a valid phone number.</div>

                                        </div>
                                    </div>

                                    <div class="text-left pt-3">
                                        <button id="save-profile-button" type="submit" class="btn btn-primary btn-sm">Update user details</button>

                                    </div>


                                </div>
                            </div>

                        </div>
                    </div>


                </div>


            </section>
        </form><!-- End Profile Edit Form -->
    </section>
</main><!-- End #main -->
<script>
    function capitalizeFirstLetter(input) {
        input.value = input.value.charAt(0).toUpperCase() + input.value.slice(1);
    }

    function capitalizeEveryWord(input) {
        var words = input.value.split(' ');

        for (var i = 0; i < words.length; i++) {
            words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1);
        }

        input.value = words.join(' ');
    }
</script>

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {

        $('#nin').on('input', function() {
            let ninValue = $(this).val();

            $.ajax({
                method: 'post',
                url: '/<?php echo e($appName); ?>/auth/check-nin/',
                data: {
                    nin: ninValue
                },
                success: function(response) {
                    $('#nin-status').text(response.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#nin-status').text(jqXHR.responseJSON.message);
                    if (jqXHR.responseJSON.status === 401) {
                        $('#nin-status').text(jqXHR.responseJSON.message);
                    }
                }
            })
        })

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

                    $('#image_url').val("http://localhost/<?php echo e($appName); ?>/uploads/images/" + response);
                    $('#profile-photo').attr('src', "http://localhost/<?php echo e($appName); ?>/uploads/images/" + response);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An Error occurred, failed to upload image')
                }
            })
        })

        $('#create-profile-form').submit(function(e) {
            e.preventDefault();

            if (this.checkValidity() === true) {

                // $("#save-profile-button").attr('disabled', true);
                // $("#save-profile-button").text('Please wait...');

                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/<?php echo e($appName); ?>/users/edit-user/',
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "User details updated successfully",
                            duration: 2000,
                            gravity: 'bottom',
                            backgroundColor: '#161b22',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload();
                        }, 3000)
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 401) {

                            $("#save-profile-button").text('Add User');
                            $("#save-profile-button").attr('disabled', false);

                            Toastify({
                                text: jqXHR.responseJSON.message || "An Error Occured, Failled to update user data...",
                                duration: 2000,
                                gravity: 'bottom',
                                backgroundColor: 'red',
                            }).showToast();

                        }
                    }
                })
            }

        })

        $('#email').on('input', function() {
            let emailValue = $(this).val();

            $.ajax({
                method: 'post',
                url: '/<?php echo e($appName); ?>/auth/check-email/',
                data: {
                    email: emailValue
                },
                success: function(response) {
                    $('#email-status').text(response.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#email-status').text(jqXHR.responseJSON.message);
                    if (jqXHR.responseJSON.status === 401) {
                        $('#email-status').text(jqXHR.responseJSON.message);
                    }
                }
            })
        })


    })
</script>