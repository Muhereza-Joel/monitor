<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<main id="main" class="main">
  <div class="d-flex align-items-center px-3">
    <div class="pagetitle p-2 order-0 w-50">
      <h1 class="py-1 text-light">Your Profile Information</h1>
      <nav>
        <ol class="breadcrumb text-light">
          <?php if($role == 'Administrator'): ?>
          <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
          <?php endif; ?>
          <li class="breadcrumb-item text-light">Users</li>
          <li class="breadcrumb-item active">My Profile</li><br>
          <div style="width: 10px;"></div>
          <div id="last-update-timestamp" class="d-none"><?php echo e($userDetails['updated_at']); ?></div>
          <span id="last-update" class="badge bg-secondary ml-3"></span>
        </ol>
      </nav>
    </div>
    <div style="width: 30px;"></div>
    <div id="alert-success" class="alert alert-success alert-dismissible py-1 px-2  fade d-none w-50" role="alert">
      <i class="bi bi-check-circle me-1"></i>
      <span></span>
    </div>


  </div>

  <section class="section profile">

    <div class="row">
      <div class="col-xl-4">
        <div class="text-center">
          <img src="<?php echo e($avator); ?>" alt="Profile" class="rounded-circle" class="rounded-circle" alt="Profile" width="300px" height="300px" style="border: 3px solid #999; object-fit: cover;">
          <h2><?php echo e($userDetails['name']); ?></h2>
          <span class="text-info"><strong>Your Role : </strong> <?php echo e($role); ?></span>
          <div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#basicModal">
              Change Photo
            </button>

          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="">
          <div class="pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered bg-light">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>


              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">

                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">About</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['about']); ?></div>
                </div>

                <h5 class="card-title fw-bold text-light">Biography</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Full Name</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['name']); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">NIN Number</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['nin']); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Date of Birth</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['dob']); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Gender</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['gender']); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Company</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['company']); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Job</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['job']); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">NIN Number</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['nin']); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Email</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['email']); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Country</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['country']); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">District</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['district']); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Village</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['village']); ?></div>
                </div>



                <div class="row">
                  <div class="col-lg-3 col-md-4 label fw-bold text-light">Phone</div>
                  <div class="col-lg-9 col-md-8 text-light"><?php echo e($userDetails['phone']); ?></div>
                </div>


              </div>

              <div class="tab-pane fade profile-edit" id="profile-edit">

                <!-- Profile Edit Form -->
                <form id="edit-profile-form" class="needs-validation" novalidate>

                  <div class="col-xl-12">
                    <div class="alert alert-info d-none" id="alert-profile-upadte-success"></div>
                    <div class="">
                      <div class=" pt-3">
                        <div class="row mb-3">
                          <label for="fullName" class="col-md-4 col-lg-3 col-form-label text-light">Full Name</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['name']); ?>" oninput="capitalizeEveryWord(this)" name="fullName" type="text" class="form-control" id="fullName" placeholder="Enter your full name here" required>
                            <div class="invalid-feedback">Please enter your full name.</div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="about" class="col-md-4 col-lg-3 col-form-label text-light">About (Optional)</label>
                          <div class="col-md-8 col-lg-9">
                            <textarea id="about-textarea" name="about" class="form-control" id="about" style="height: 150px" placeholder="Brief info about your self"><?php echo e($userDetails['about']); ?></textarea>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="company" class="col-md-4 col-lg-3 col-form-label text-light">Company (Optional)</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['company']); ?>" name="company" type="text" class="form-control" id="company" placeholder="What company do you work for (Optional)">
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Job" class="col-md-4 col-lg-3 col-form-label text-light">Job Title</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['job']); ?>" name="job" type="text" class="form-control" id="Job" placeholder="Enter your Job title like manager, doctor" required>
                            <div class="invalid-feedback">Please provide your Job Title</div>
                          </div>
                        </div>


                        <div class="row mb-3">
                          <label for="nin" class="col-md-4 col-lg-3 col-form-label text-light">NIN Number</label>
                          <div class="col-md-8 col-lg-9">

                            <input value="<?php echo e($userDetails['nin']); ?>" pattern="[A-Z0-9]{14}" min="14" name="nin" type="text" class="form-control" id="nin" placeholder="Enter your nin number" required>
                            <div class="invalid-feedback">Please enter a valid NIN number with digits, letters, no spaces and 14 characters long.</div>
                            <small id="nin-status" class="text-success fw-bold"></small>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="email" class="col-md-4 col-lg-3 col-form-label text-light">Email</label>
                          <div class="col-md-8 col-lg-9">
                            <input name="email" type="text" class="form-control" id="email" placeholder="Enter your email address" required value="<?php echo e($userDetails['email']); ?>">
                            <div class="invalid-feedback">Please enter your email address.</div>
                            <small id="email-status" class="text-success fw-bold"></small>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="gender" class="col-md-4 col-lg-3 col-form-label text-light">Gender</label>
                          <div class="col-md-8 col-lg-9">
                            <select name="gender" id="gender" class="form-control" required>
                              <option value="">Select Gender</option>
                              <option value="male" <?php echo e($userDetails['gender'] === 'male' ? 'selected' : ''); ?>>Male</option>
                              <option value="female" <?php echo e($userDetails['gender'] === 'female' ? 'selected' : ''); ?>>Female</option>
                            </select>

                            <div class="invalid-feedback">Please select gender.</div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="dob" class="col-md-4 col-lg-3 col-form-label text-light">Date of Birth</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['dob']); ?>" name="dob" type="date" class="form-control" id="Country" placeholder="Enter your home Country" required>
                            <div class="invalid-feedback">Please choose date of birth.</div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Country" class="col-md-4 col-lg-3 col-form-label text-light">Country</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['country']); ?>" oninput="capitalizeFirstLetter(this)" name="country" type="text" class="form-control" id="Country" placeholder="Enter your home Country" required>
                            <div class="invalid-feedback">Please enter your home coutry.</div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Home District" class="col-md-4 col-lg-3 col-form-label text-light">Home District</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['district']); ?>" oninput="capitalizeFirstLetter(this)" name="district" type="text" class="form-control" id="Home District" placeholder="Enter your home district" required>
                            <div class="invalid-feedback">Please enter your home district.</div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="village" class="col-md-4 col-lg-3 col-form-label text-light">Village</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['village']); ?>" oninput="capitalizeFirstLetter(this)" name="village" type="text" class="form-control" id="village" placeholder="Enter the village you come from" required>
                            <div class="invalid-feedback">Please enter the village you come from.</div>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <label for="Phone" class="col-md-4 col-lg-3 col-form-label text-light">Phone</label>
                          <div class="col-md-8 col-lg-9">
                            <input value="<?php echo e($userDetails['phone']); ?>" pattern="[+]?[0-9]+" name="phone" type="text" class="form-control" id="Phone" placeholder="Enter your phone number" required>
                            <div class="invalid-feedback">Please enter a valid phone number.</div>

                          </div>
                        </div>




                      </div>
                    </div>

                  </div>

                  <div class="text-left">
                    <button id="edit-profile-submit-button" class="btn btn-dark btn-sm">Update Profile</button>

                  </div>

              </div>
              </form>

            </div>



            <div class="tab-pane fade pt-3" id="profile-change-password">
              <!-- Change Password Form -->
              <div class="alert alert-warning p-2">
                After successfully changing your password, your account will be loged out and
                then you have to log in again. You will be redirected to the login page automatically!
              </div>
              <form class="needs-validation" id="password-change-form" novalidate>

                <div class="alert alert-success p-1 d-none" id="alert-password-change-success">
                  <span></span>
                </div>

                <div class="row mb-3">
                  <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label text-light">Current Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="password" type="password" class="form-control" id="currentPassword" required>
                    <div class="invalid-feedback">Please enter your current password.</div>
                    <div class="text-danger" id="password-error"></div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="newPassword" class="col-md-4 col-lg-3 col-form-label text-light">New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="newpassword" type="password" class="form-control" id="newPassword" required disabled>
                    <div class="invalid-feedback">Please enter new password.</div>
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label text-light">Re-enter New Password</label>
                  <div class="col-md-8 col-lg-9">
                    <input name="renewpassword" type="password" class="form-control" id="renewPassword" required disabled>
                    <div class="invalid-feedback">Please re enter the new password.</div>
                    <div class="renewPassword-feedback" id="renewPassword-feedback">
                      <span class="text-danger"></span>
                    </div>
                  </div>
                </div>

                <div class="text-left">
                  <button type="submit" class="btn btn-primary btn-sm" id="change-password-btn" disabled>Change Password</button>
                </div>
              </form><!-- End Change Password Form -->

            </div>

          </div><!-- End Bordered Tabs -->

        </div>
      </div>

    </div>
    </div>
  </section>

</main>

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="modal fade" id="basicModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
        <div id="alert-number-error" class="alert alert-danger alert-dismissible py-1 px-2 fade d-none" role="alert">
          <i class="bi bi-exclamation-octagon me-0"></i>
          <span></span>

        </div>

        <form id="change-profile-pic-form" class="">
          <div id="edit-photo-alert-success" class="alert alert-success alert-dismissible py-1 px-2  fade w-100" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            <span></span>
          </div>
          <img id="profile-photo" src="<?php echo e($avator); ?>" width="100%" height="300px" alt="Profile" style="object-fit: contain;">
          <br><br><br>
          <input data-parsley-error-message="Please choose an image" id="image" type="file" accept="image/jpeg" title="Choose Image" required>
          <input type="hidden" name="image_url" id="image_url">
          <button id="save-new-profile-pic-btn" type="submit" class="btn btn-primary btn-sm">Save Photo</button>
          <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        </form>
      </div>

    </div>
  </div>
</div><!-- End Basic Modal-->


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



<script>
  $(document).ready(function() {
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

    $('#change-profile-pic-form').submit(function(event) {
      event.preventDefault();

      let formData = new FormData(this);
      $.ajax({
        method: "POST",
        url: "/<?php echo e($appName); ?>/auth/user/profile/update-photo/",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          $("#edit-photo-alert-success").removeClass('d-none');
          $("#edit-photo-alert-success").addClass('show');
          $('#edit-photo-alert-success span').text(response.message);
          $('#save-new-profile-pic-btn').prop('disabled', true);

          setTimeout(function() {
            $("#edit-photo-alert-success").addClass('d-none');
            window.location.reload();
          }, 1000);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#save-new-profile-pic-btn').prop('disabled', false);
        }
      })
    })


    $('#currentPassword').on('input', function() {
      let password = $(this).val();

      $.ajax({
        url: '/<?php echo e($appName); ?>/auth/check-password/',
        method: 'GET',
        data: {
          password: password
        },
        success: function(response) {
          $('#password-error').removeClass('text-danger');
          $('#password-error').addClass('text-success');
          $('#password-error').text(response.message);

          $('#newPassword').removeAttr('disabled');
          $('#renewPassword').removeAttr('disabled');
          $('#change-password-btn').removeAttr('disabled');

        },
        error: function(jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 401) {
            $('#password-error').removeClass('text-success');
            $('#password-error').addClass('text-danger');
            $('#password-error').text(jqXHR.responseJSON.message);

            $('#newPassword').attr('disabled', true);
            $('#renewPassword').attr('disabled', true);
            $('#change-password-btn').attr('disabled', true);
          }
        }
      })
    })



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


    $('#edit-profile-form').submit(function(e) {
      e.preventDefault();

      if (this.checkValidity() === true) {

        let formData = $(this).serialize();

        $.ajax({
          method: 'post',
          url: '/<?php echo e($appName); ?>/auth/update-profile/',
          data: formData,
          success: function(response) {
            $('#alert-profile-upadte-success').removeClass('d-none');
            $('#alert-profile-upadte-success').addClass('show');
            $('#alert-profile-upadte-success').text(response.message);

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function(jqXHR, textStatus, errorThrown) {
            if (jqXHR.status === 401) {
              alert('An Error Occured, Failled to update your profile data...');
            }
          }
        })
      }
    })

    $('#password-change-form').submit(function(event) {
      var newPassword = $('#newPassword').val();
      var renewPassword = $('#renewPassword').val();

      if (newPassword !== renewPassword) {

        $('#renewPassword-feedback span').text('Passwords do not match.');
        event.preventDefault();


      } else {
        event.preventDefault()

        if (this.checkValidity() === true) {

          let formData = $(this).serialize();

          $.ajax({
            method: 'post',
            url: '/<?php echo e($appName); ?>/auth/change-password/',
            data: formData,
            success: function(response) {
              $('#alert-password-change-success').removeClass('d-none');
              $('#alert-password-change-success').addClass('show');
              $('#alert-password-change-success span').text(response.message);

              setTimeout(function() {
                window.location.replace("http://localhost/<?php echo e($appName); ?>/auth/login/");
              }, 3000)
            },
            error: function(jqXHR, textStatus, errorThrown) {
              if (jqXHR.status === 401) {
                alert('An Error Occured, Failled to change your password');
              }
            }
          })
        }
      }
    });

    let profileUpdateTimestamp = $("#last-update-timestamp").text();
    const momentTimestamp = moment(profileUpdateTimestamp);
    const relativeTime = momentTimestamp.fromNow();
    $("#last-update").text("updated " + relativeTime)

  })
</script>


</body>

</html>