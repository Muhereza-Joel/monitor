@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Update Organization Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Update Organisation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-1">
            <div class="col-sm-5">
                <div class="card p-2">
                    <div class="card-title">Update Organisation Details</div>
                    <div class="card-body">
                        <small class="text-success">Organizations help to organize user accounts, profiles, indicators, and responses to their respective Organizations, and only members can modify but the rest only view.</small>
                        <hr>
                        <form id="organization-registration-form" class="row g-3 needs-validation" novalidate>
                            <div class="form-group my-2">
                                <label for="">Organization Logo</label>
                                <div class="text-center">
                                    <img id="profile-photo" src="{{$organisation['logo']}}" class="rounded-circle" alt="Profile" width="200px" height="200px" style="border: 3px solid #999; object-fit: cover;">
                                </div>
                                <div class="pt-2">
                                    <input type="hidden" name="image_url" id="image_url" value="{{$organisation['logo']}}">
                                    <input type="file" name="image" id="image" class="btn btn-outline btn-sm" accept="image/jpeg, image/png">
                                    <div class="invalid-feedback">Please choose organization logo</div>
                                </div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Organization Name</label>
                                <input type="hidden" name="organisation-id" value="{{$organisation['id']}}">
                                <input value="{{$organisation['name']}}" type="text" class="form-control" name="organization-name" id="organization-name" required>
                                <div class="invalid-feedback">Organization name is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Active</label>
                                <select name="active" id="" required class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="true" {{ $organisation['active'] == 'true' ? 'selected' : '' }} >Yes</option>
                                    <option value="false" {{ $organisation['active'] == 'false' ? 'selected' : '' }} >No</option>

                                </select>
                                <div class="invalid-feedback">This value is required</div>
                            </div>

                            <div class="text-start mt-3">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

</main><!-- End #main -->

@include('partials/footer')

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
                    url: '/{{$appName}}/organisations/update/',
                    data: formData,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Row Updated Successfully",
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
                url: '/{{$appName}}/image-upload/',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#image_url').val("{{$baseUrl}}/uploads/images/" + response);
                    $('#profile-photo').attr('src', "{{$baseUrl}}/uploads/images/" + response);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An Error occurred, failed to upload image');
                }
            })
        });
    });
</script>
