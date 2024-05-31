<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


<main id="main" class="main">

  <div class="pagetitle">
    <h1 class="text-dark">Create New Order</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Create Order.</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="row g-2">
      <div class="alert alert-info">
        Hey <strong><?php echo e($userDetails['name']); ?></strong>, you are a few steps to creating your order. Please note that we shall only process your order after you settling your payments for this order.
        Please continue and place your order, after go to the orders section and complete payment for this order.
      </div>

      <div class="col-sm-6">
        <div class="card p-2">
          <div class="card-title">Your Order Details</div>
          <div class="card-body">
            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Branch Name</div>
              <div class="col-sm-6"><?php echo e($stockDetails['branch_name']); ?></div>
            </div>
            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Store Name</div>
              <div class="col-sm-6"><?php echo e($stockDetails['zone_name']); ?></div>
            </div>
            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Product Title</div>
              <div class="col-sm-6"><?php echo e($stockDetails['title']); ?></div>
            </div>

            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Available</div>
              <div class="col-sm-6"><?php echo e($stockDetails['available_stock']); ?> <?php echo e($stockDetails['units']); ?></div>
            </div>

            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Unit Cost</div>
              <div class="col-sm-6">Ugx <?php echo e($stockDetails['selling_price']); ?></div>
            </div>
            <form action="" class="needs-validation my-2" novalidate id="create-order-form">

              <hr>

              <div class="d-flex">
                <div class="form-group me-3">
                  <input type="hidden" name="stock-id" value="<?php echo e($stockDetails['id']); ?>">
                  <input type="hidden" name="user-id" value="<?php echo e($userDetails['user_id']); ?>">
                  <label for="">Unit Price</label>
                  <input required readonly value="<?php echo e($stockDetails['selling_price']); ?>" class="form-control" type="number" placeholder="Unit price" name="unit-price">

                </div>
                <div class="form-group">

                  <label for="">Enter <?php echo e($stockDetails['units']); ?> to purchase</label>
                  <input required class="form-control" type="number" placeholder="Units to purchase" name="order-quantity" max="<?php echo e($stockDetails['available_stock']); ?>">
                  <div class="invalid-feedback">Please provide quantity that you need purchase not exceeding <?php echo e($stockDetails['available_stock']); ?> <?php echo e($stockDetails['units']); ?></div>
                </div>

              </div>

              <div class="form-group my-2">
                <label for="">Total Amount Due</label>
                <input type="number" id="total-amount" name="total-amount-due" readonly class="form-control">
              </div>

              <div class="text-start my-2">
                <button class="btn btn-primary btn-sm" type="submit">Place Order</button>
                <a href="/<?php echo e($appName); ?>/dashboard/inventory/" class="btn btn-danger btn-sm">Cancel Order Creation</a>
              </div>

            </form>

          </div>
        </div>

      </div>
      <div class="col-sm-6">
        <div class="card p-2">
          <div class="card-title">Your Personal Details</div>
          <div class="card-body">
            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Fullname</div>
              <div class="col-sm-6"><?php echo e($userDetails['name']); ?></div>
            </div>
            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Email Address</div>
              <div class="col-sm-6"><?php echo e($userDetails['email']); ?></div>
            </div>
            <div class="row my-2">
              <div class="col-sm-3 fw-bold">Contact</div>
              <div class="col-sm-6"><?php echo e($userDetails['phone']); ?></div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {

    $('input[name="order-quantity"]').on('input', function() {
      var unitPrice = parseFloat($('input[name="unit-price"]').val());
      var quantity = parseFloat($(this).val());
      var totalAmount = unitPrice * quantity;

      if (!isNaN(totalAmount)) {
        $('#total-amount').val(totalAmount);
      } else {
        $('#total-amount').val('');
      }
    });

    $('#create-order-form').submit(function(event) {
      event.preventDefault();

      if (this.checkValidity() === true) {

        let formData = $(this).serialize();

        $.ajax({
          method: 'POST',
          url: "/<?php echo e($appName); ?>/dashboard/stock/orders/add/",
          data: formData,
          success: function(response) {

            Toastify({
              text: response.message || "Record Saved Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              // window.location.reload();
            }, 2000)


          },
          error: function() {}
        })
      }
    })



  });
</script>