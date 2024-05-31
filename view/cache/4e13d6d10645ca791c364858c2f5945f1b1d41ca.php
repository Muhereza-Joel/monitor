<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <form class="needs-validation" novalidate id="add-book-form" enctype="multipart/form-data">
        <div class="pagetitle">
            <h1>Book Details</h1>
            <div class="d-flex">
                <nav class="w-50">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/books/">Books</a></li>
                        <li class="breadcrumb-item active">Book Details</li>
                    </ol>
                </nav>
                <div class="buttons-container align-self-center w-50 text-end">
                    <?php if($role == 'Administrator'): ?>
                    <?php if($book['total'] == $book['borrowed']): ?>
                    <div class="badge bg-danger"><strong>Book is out of stock</strong></div>
                    <?php else: ?>
                    <a href="/<?php echo e($appName); ?>/books/lend/?id=<?php echo e($book['id']); ?>" class="btn btn-primary btn-sm">Lend Out Book</a>
                    <?php endif; ?>
                    <a href="/<?php echo e($appName); ?>/books/edit/?id=<?php echo e($book['id']); ?>" class="btn btn-primary btn-sm">Edit Book</a>

                    <?php endif; ?>
                </div>
            </div>

        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <img id="book-image" src="<?php echo e($book['cover']); ?>" alt="book image" style="object-fit: fill;  border-radius: 5px;" width="100%" height="400px">
                        <input type="hidden" name="image_url" id="image_url">
                    </div>

                </div>

                <div class="col-sm-6 ">
                    <div class="form-group">
                        <label for="title" class="pb-2">Book Title</label>
                        <input id="title" class="form-control" type="text" name="title" value="<?php echo e($book['title']); ?>" readonly>
                        <div class="invalid-feedback">Please enter book title</div>
                    </div>
                    <div class="d-flex">
                        <div class="form-group">
                            <label for="author" class="py-2">Book Author</label>
                            <input class="form-control" type="text" name="author" id="author" value="<?php echo e($book['author']); ?>" readonly>
                            <div class="invalid-feedback">Please enter book author</div>
                        </div>
                        <div class="form-group mx-2">
                            <label for="isbn" class="py-2">ISBN Number</label>
                            <input class=" form-control" type="text" name="isbn" id="isbn" value="<?php echo e($book['isbn']); ?>" readonly>
                            <div class="invalid-feedback">Please enter isbn</div>
                        </div>

                    </div>

                    <div class="d-flex">
                        <div class="form-group">
                            <label for="edition" class="py-2">Book Edition</label>
                            <input class="form-control" type="text" name="edition" id="edition" value="<?php echo e($book['edition']); ?>" readonly>
                            <div class="invalid-feedback">Please enter book edition</div>
                        </div>

                        <div class="form-group mx-2">
                            <label for="shelf_number" class="py-2">Shelf Number</label>
                            <input class="form-control" type="number" name="shelf_number" id="shelf_number" value="<?php echo e($book['shelf_number']); ?>" readonly>
                            <div class="invalid-feedback">Please enter book edition</div>
                        </div>

                    </div>


                    <div class="form-group">
                        <label for="subject" class="py-2 fw-bold">Subject</label>
                        <input class="form-control" type="text" name="shelf_number" id="shelf_number" value="<?php echo e($book['subject']); ?>" readonly>

                    </div>
                    <div class="form-group">
                        <label for="class_level" class="py-2 fw-bold">Class</label>
                        <input class="form-control" type="text" name="shelf_number" id="shelf_number" value="<?php echo e($book['subject']); ?>" readonly>
                        </select>

                    </div>

                </div>

            </div>

        </section>
    </form>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>