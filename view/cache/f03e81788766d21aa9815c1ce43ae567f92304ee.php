<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <form class="needs-validation card p-4" novalidate id="lend-out-form" enctype="multipart/form-data">
    <div class="pagetitle">
      <h1>Lend Books</h1>
      <div class="d-flex">
        <nav class="w-50">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/books/">Books</a></li>
            <li class="breadcrumb-item active">Lend Book</li>
          </ol>
        </nav>
        <div class="buttons-container align-self-center w-50 text-end">
          <?php if($role == 'Administrator'): ?>
          <input class="btn btn-primary btn-sm" type="submit" value="Save Record Details" />
          <?php endif; ?>
        </div>
      </div>
    </div><!-- End Page Title -->
    <hr>
    <section class="section dashboard">
      <div class="row">
        <div class="col-sm-8" style="border-right: 1px solid #ccc;">
          <div class="d-flex align-items-center">
            <div class="alert alert-warning p-2">You can lend the same book to two people by using the search area..
              <strong>Not that the same book will not be given out to the same person if the previous is not returned</strong>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-5">
              <div>
                <img src="<?php echo e($book['cover']); ?>" style="object-fit: cover;" alt="avator" width="100%" height="300px" class="mt-3">
              </div>
            </div>
            <div class="col-sm-7 mt-3">
              <div class="form-group">
                <label for="">Book Title</label>
                <input value="<?php echo e($book['title']); ?>" type="text" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="">Book Author</label>
                <input value="<?php echo e($book['author']); ?>" type="text" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="">Book ISBN</label>
                <input value="<?php echo e($book['isbn']); ?>" type="text" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label class="py-2 pt-4" for="pickup-date">Pickup Date:</label>
                <input class="form-control" type="text" id="pickup-date" name="pickup-date" required autocomplete="off">
                <div class="invalid-feedback">Please provide the pickup date for the book</div>
              </div>
              <div class="form-group">
                <label class="py-2" for="return-date">Return Date:</label>
                <input class="form-control" type="text" id="return-date" name="return-date" required autocomplete="off">
                <div class="invalid-feedback">Please provide the return date for the book</div>
              </div>
            </div>
          </div>
        </div>



        <div class="col-sm-4">
          <div class="d-flex align-items-center">
            <div class="form-group">
              <label for="search-query-two">Username or Email</label>
              <input class="form-control" placeholder="Username or email" type="text" id="search-query-two" required>
              <div class="invalid-feedback">Please provide username or email</div>
            </div>

            <div class="form-group">
              <button type="button" class="btn btn-primary btn-sm mx-2 mt-4" id="search-user-btn">Search User</button>
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
              <input name="book-id" value="<?php echo e($book['id']); ?>" type="hidden">
            </div>

            <div class="form-group">
              <label for="">Email</label>
              <input id="email" type="text" class="form-control" readonly required>
              <div class="invalid-feedback">Please search user to get the email</div>
            </div>
          </div>
        </div>
      </div>
    </section>

  </form>
</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    $("#pickup-date").datepicker({
      minDate: 0,
      maxDate: "+1",
      dateFormat: 'yy-mm-dd',
      onSelect: function(selectedDate) {
        $("#return-date").datepicker("option", "minDate", selectedDate);
      }
    })

    $("#return-date").datepicker({
      minDate: 0,
      maxDate: "+10",
      dateFormat: 'yy-mm-dd',
      onSelect: function(selectedDate) {
        $("#pickup-date").datepicker("option", "maxDate", selectedDate);
      }
    })

    $('#lend-out-form').submit(function(event) {
      event.preventDefault();

      if (this.checkValidity()) {

        var formData = $(this).serialize();

        $.ajax({
          method: 'post',
          url: '/<?php echo e($appName); ?>/books/lend/save/',
          data: formData,
          success: function(response) {
            Toastify({
              text: response.message,
              duration: 2000,
              gravity: 'bottom',
              backgroundColor: '#161b22',
            }).showToast();
          },
          error: function(response) {
            const errorMessage = response.message || 'User already has the same book. Cannot lend the book again.';

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
  })
</script>