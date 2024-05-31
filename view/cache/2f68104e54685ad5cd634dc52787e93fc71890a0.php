<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <form class="needs-validation card p-4" novalidate id="add-book-form" enctype="multipart/form-data">
        <div class="pagetitle">
            <h1>Edit Book</h1>
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
                    <button class="btn btn-primary btn-sm" type="submit" id="save-book-button">Update Book Details</button>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <img id="book-image" src="<?php echo e($book['cover']); ?>" alt="book image" style="object-fit: fill;  border-radius: 5px;" width="100%" height="400px">
                        <input type="hidden" name="image_url" id="image_url" value="<?php echo e($book['cover']); ?>">
                    </div>
                    <div class="form-group">
                        <input name="image" class="btn btn-outline mt-2" type="file" id="image" accept="image/jpeg, image/png">
                        <div class="invalid-feedback">Please select an image</div>
                    </div>




                </div>

                <div class="col-sm-6 ">
                    <div class="form-group">
                        <input type="hidden" value="<?php echo e($book['id']); ?>" name="book_id">
                        <label for="title" class="pb-2">Book Title</label>
                        <input oninput="capitalizeEveryWord(this)" id="title" class="form-control" type="text" name="title" value="<?php echo e($book['title']); ?>" required placeholder="Enter book title">
                        <div class="invalid-feedback">Please enter book title</div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group my-2">
                            <label for="author" class="py-2">Book Author</label>
                            <input oninput="capitalizeEveryWord(this)" class="form-control" type="text" name="author" value="<?php echo e($book['author']); ?>" id="author" required placeholder="Enter book author">
                            <div class="invalid-feedback">Please enter book author</div>
                        </div>
                        <div class="form-group mx-2 my-2">
                            <label for="isbn" class="py-2">ISBN Number</label>
                            <input oninput="capitalizeEveryWord(this)" class=" form-control" type="text" name="isbn" value="<?php echo e($book['isbn']); ?>" id="isbn" required placeholder="Enter book isbn">
                            <div class="invalid-feedback">Please enter isbn</div>
                        </div>

                    </div>

                    <div class="d-flex">
                        <div class="form-group my-2">
                            <label for="edition" class="py-2">Book Edition</label>
                            <input oninput="capitalizeEveryWord(this)" class="form-control" type="text" name="edition" value="<?php echo e($book['edition']); ?>" id="edition" required placeholder="Enter book edition">
                            <div class="invalid-feedback">Please enter book edition</div>
                        </div>

                        <div class="form-group mx-2 my-2">
                            <label for="shelf_number" class="py-2">Shelf Number</label>
                            <input oninput="capitalizeFirstLetter(this)" class="form-control" type="number" name="shelf_number" value="<?php echo e($book['shelf_number']); ?>" id="shelf_number" required placeholder="Enter shelf number">
                            <div class="invalid-feedback">Please enter book edition</div>
                        </div>
                        <div class="form-group mx-2 my-2">
                            <label for="quantity" class="py-2">Total Number</label>
                            <input class="form-control" type="number" name="quantity" value="<?php echo e($book['total']); ?>" id="shelf_number" required placeholder="Enter total number">
                            <div class="invalid-feedback">Please enter total</div>
                        </div>

                    </div>


                    <div class="d-flex align-items-center">

                        <div class="form-group mx-2 my-2">

                            <label for="">Select Subject</label>
                            <select class="form-control" name="subject" id="subject" required>
                                <option value="">Select Subject</option>
                                <option value="English" <?php echo e($book['subject'] == 'English' ? 'selected' : ''); ?>>English</option>
                                <option value="Literacy" <?php echo e($book['subject'] == 'Literacy' ? 'selected' : ''); ?>>Literacy</option>
                                <option value="Mathematics" <?php echo e($book['subject'] == 'Mathematics' ? 'selected' : ''); ?>>Mathematics</option>
                                <option value="Biology" <?php echo e($book['subject'] == 'Biology' ? 'selected' : ''); ?>>Biology</option>
                                <option value="Physics" <?php echo e($book['subject'] == 'Physics' ? 'selected' : ''); ?>>Physics</option>
                                <option value="Chemistry" <?php echo e($book['subject'] == 'Chemistry' ? 'selected' : ''); ?>>Chemistry</option>
                                <option value="Geography" <?php echo e($book['subject'] == 'Geography' ? 'selected' : ''); ?>>Geography</option>
                                <option value="ICT" <?php echo e($book['subject'] == 'ICT' ? 'selected' : ''); ?>>ICT</option>
                                <option value="Agriculture" <?php echo e($book['subject'] == 'Agriculture' ? 'selected' : ''); ?>>Agriculture</option>
                                <option value="Commerce" <?php echo e($book['subject'] == 'Commerce' ? 'selected' : ''); ?>>Commerce</option>
                                <option value="Entreprenuership" <?php echo e($book['subject'] == 'Entreprenuership' ? 'selected' : ''); ?>>Entreprenuership</option>
                                <option value="Religous Education" <?php echo e($book['subject'] == 'Religous Education' ? 'selected' : ''); ?>>Religous Education</option>
                                <option value="Divinity" <?php echo e($book['subject'] == 'Divinity' ? 'selected' : ''); ?>>Divinity</option>
                                <option value="Economics" <?php echo e($book['subject'] == 'Economics' ? 'selected' : ''); ?>>Economics</option>
                                <option value="Home Economics" <?php echo e($book['subject'] == 'Home Economics' ? 'selected' : ''); ?>>Home Economics</option>
                                <option value="Kiswahili" <?php echo e($book['subject'] == 'Kiswahili' ? 'selected' : ''); ?>>Kiswahili</option>
                                <option value="History" <?php echo e($book['subject'] == 'History' ? 'selected' : ''); ?>>History</option>
                                <option value="French" <?php echo e($book['subject'] == 'French' ? 'selected' : ''); ?>>French</option>
                                <option value="German" <?php echo e($book['subject'] == 'German' ? 'selected' : ''); ?>>German</option>
                            </select>
                            <div class="invalid-feedback">Please select subject</div>

                        </div>
                    </div>

                    <div class="d-flex align-items-center">

                        <div class="form-group mx-2 my-2">
                            <label for="class_level" class="">Class</label>
                            <select class="form-control" name="class_level" id="class_level" required>
                                <option value="">Select Class</option>
                                <option value="1" <?php echo e($book['class_level'] == '1' ? 'selected' : ''); ?>>Senior One</option>
                                <option value="2" <?php echo e($book['class_level'] == '2' ? 'selected' : ''); ?>>Senior Two</option>
                                <option value="3" <?php echo e($book['class_level'] == '3' ? 'selected' : ''); ?>>Senior Three</option>
                                <option value="4" <?php echo e($book['class_level'] == '4' ? 'selected' : ''); ?>>Senior Four</option>
                                <option value="5" <?php echo e($book['class_level'] == '5' ? 'selected' : ''); ?>>Senior Five</option>
                                <option value="6" <?php echo e($book['class_level'] == '6' ? 'selected' : ''); ?>>Senior Six</option>
                            </select>
                            <div class="invalid-feedback">Please select class</div>

                        </div>
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
                url: '/<?php echo e($appName); ?>/books/update/',
                data: formData,
                success: function(response) {
                    // $("#add-book-form")[0].reset();
                    Toastify({
                        text: response.message || "Book Updated",
                        duration: 2000,
                        gravity: 'bottom',
                        backgroundColor: '#161b22',
                    }).showToast();

                    setTimeout(function() {
                        window.location.reload();

                    }, 3000)
                    $("#save-book-button").text('Update Book Details');

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