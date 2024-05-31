<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <form class="needs-validation card p-4" novalidate id="add-book-form" enctype="multipart/form-data">
        <div class="pagetitle">
            <h1>Books</h1>
            <div class="d-flex">
                <nav class="w-50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/books/">Books</a></li>
                        <li class="breadcrumb-item active">Add New</li>
                    </ol>
                </nav>
                <div class="buttons-container align-self-center w-50 text-end">
                    <?php if($role == 'Administrator'): ?>
                    <button class="btn btn-primary btn-sm" type="submit" id="save-book-button">Save Book Details</button>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <img id="book-image" src="http://localhost/<?php echo e($appName); ?>/assets/img/bookcover.png" alt="book image" style="object-fit: contain;  border-radius: 5px;" width="100%" height="400px">
                        <input type="hidden" name="image_url" id="image_url">
                    </div>
                    <div class="form-group">
                        <input name="image" class="btn btn-outline mt-2" type="file" id="image" accept="image/jpeg, image/png" required>
                        <div class="invalid-feedback">Please select an image</div>
                    </div>




                </div>

                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="title" class="pb-2 fw-bold">Book Title</label>
                        <input oninput="capitalizeEveryWord(this)" id="title" class="form-control" type="text" name="title" required placeholder="Enter book title">
                        <div class="invalid-feedback">Please enter book title</div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group">
                            <label for="author" class="py-2 fw-bold">Book Author</label>
                            <input oninput="capitalizeEveryWord(this)" class="form-control" type="text" name="author" id="author" required placeholder="Enter book author">
                            <div class="invalid-feedback">Please enter book author</div>
                        </div>
                        <div class="form-group mx-2">
                            <label for="isbn" class="py-2 fw-bold">ISBN Number</label>
                            <input oninput="capitalizeEveryWord(this)" class=" form-control" type="text" name="isbn" id="isbn" required placeholder="Enter book isbn">
                            <div class="invalid-feedback">Please enter isbn</div>
                        </div>

                    </div>

                    <div class="d-flex">
                        <div class="form-group">
                            <label for="edition" class="py-2 fw-bold">Book Edition</label>
                            <input oninput="capitalizeEveryWord(this)" class="form-control" type="text" name="edition" id="edition" required placeholder="Enter book edition">
                            <div class="invalid-feedback">Please enter book edition</div>
                        </div>

                        <div class="form-group mx-2">
                            <label for="shelf_number" class="py-2 fw-bold">Shelf Number</label>
                            <input oninput="capitalizeFirstLetter(this)" class="form-control" type="number" name="shelf_number" id="shelf_number" required placeholder="Enter shelf number">
                            <div class="invalid-feedback">Please enter book edition</div>
                        </div>
                        <div class="form-group mx-2">
                            <label for="quantity" class="py-2 fw-bold">Total Number</label>
                            <input class="form-control" type="number" name="quantity" id="shelf_number" required placeholder="Enter total number">
                            <div class="invalid-feedback">Please enter total</div>
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="subject" class="py-2 fw-bold">Subject</label>
                        <select class="form-control" name="subject" id="subject" required>
                            <option value="">Select Subject</option>
                            <option value="English">English</option>
                            <option value="Literacy">Literacy</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Biology">Biology</option>
                            <option value="Physics">Physics</option>
                            <option value="Chemistry">Chemistry</option>
                            <option value="Geography">Geography</option>
                            <option value="ICT">ICT</option>
                            <option value="Agriculture">Agriculture</option>
                            <option value="Commerce">Commerce</option>
                            <option value="Entreprenuership">Entreprenuership</option>
                            <option value="Religous Education">Religous Education</option>
                            <option value="Divinity">Divinity</option>
                            <option value="Economics">Economics</option>
                            <option value="Home Economics">Home Economics</option>
                            <option value="Kiswahili">Kiswahili</option>
                            <option value="History">History</option>
                            <option value="French">French</option>
                            <option value="German">German</option>
                        </select>
                        <div class="invalid-feedback">Please select subject</div>

                    </div>
                    <div class="form-group">
                        <label for="class_level" class="py-2 fw-bold">Class</label>
                        <select class="form-control" name="class_level" id="class_level" required>
                            <option value="">Select Class</option>
                            <option value="1">Senior One</option>
                            <option value="2">Senior Two</option>
                            <option value="3">Senior Three</option>
                            <option value="4">Senior Four</option>
                            <option value="5">Senior Five</option>
                            <option value="6">Senior Six</option>
                        </select>
                        <div class="invalid-feedback">Please select class</div>

                    </div>
                </div>

            </div>

        </section>
    </form>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
                    $('#book-image').attr('src', "http://localhost/<?php echo e($appName); ?>/uploads/images/" + response);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('An Error occurred, failed to upload image')
                }
            })
        })

    })

    $('#add-book-form').submit(function(e) {
        e.preventDefault();

        if (this.checkValidity() === true) {

            //   $("#save-book-button").attr('disabled', true);
            $("#save-book-button").text('Please wait...');

            let formData = $(this).serialize();

            $.ajax({
                method: 'post',
                url: '/<?php echo e($appName); ?>/books/create/',
                data: formData,
                success: function(response) {
                    // $("#add-book-form")[0].reset();
                    window.location.reload();
                    $("#save-book-button").text('Save Book Details');

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 401) {
                        // $("#save-book-button").removeAttr('disabled');
                        $("#save-book-button").text('Save Book Details');
                        alert('An Error Occured, Failled to save book data...');
                    }
                }
            })
        }

    })
</script>