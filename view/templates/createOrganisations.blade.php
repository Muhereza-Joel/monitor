@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create New Organizations.</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Create Organizations</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-1">
            <div class="col-sm-5">
                <div class="card p-2">
                    <div class="card-title">Create Organization</div>
                    <div class="card-body">
                        <small class="text-success">Organizations help to organise user account, profiles, indicators and responses to their respective Organizations, and only members can modify but the rest only view.</small>
                        <hr>
                        <form id="organization-registration-form" class="row g-3 needs-validation" novalidate>
                            <div class="form-group my-2">
                                <label for="">Organization Logo</label>
                                <div class="text-center">
                                    <img id="profile-photo" src="/{{$appName}}/assets/img/avatar.png" class="rounded-circle" alt="Profile" width="250px" height="250px" style="border: 3px solid #999; object-fit: cover;">
                                </div>
                                <div class="pt-2">
                                    <input type="hidden" name="image_url" id="image_url">
                                    <input type="file" name="image" id="image" class="btn btn-outline btn-sm" required accept="image/jpeg, image/png">
                                    <div class="invalid-feedback">Please organization logo</div>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Organization Name</label>
                                <input type="text" class="form-control" name="organization-name" required>
                                <div class="invalid-feedback">Organization name is required</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="card p-2">
                    <h5 class="card-title">Current Registered Organizations</h5>
                    
                    <div class="card-body">
                        <table class="table table-stripped">
                            <thead>
                                <tr>
                                    <th>SNo.</th>
                                    <th>Organization Logo.</th>
                                    <th>Organization Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {

        $('#image').on('change', function() {
        let formData = new FormData();
        formData.append('image', this.files[0]);

        $.ajax({
          method: 'post',
          url: '/{{$appName}}/image-upload/',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {

            $('#image_url').val("{{$baseUrl}}/{{$appName}}/uploads/images/" + response);
            $('#profile-photo').attr('src', "{{$baseUrl}}/{{$appName}}/uploads/images/" + response);

          },
          error: function(jqXHR, textStatus, errorThrown) {
            alert('An Error occurred, failed to upload image')
          }
        })
      })

        $('#organization-registration-form').submit(function(e) {
            e.preventDefault();

            if (this.checkValidity() === true) {


                let formData = $(this).serialize();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/create-account/',
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