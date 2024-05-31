<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1 class="text-light">Book Your Ticket</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Book Ticket</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="col-sm-8">
                <div class="card p-3">
                    <div class="card-title">Your Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Full Name</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($customer['name']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Phone Number</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($customer['phone']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Gender</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($customer['gender']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>NIN number</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($customer['nin']); ?></div>
                        </div>



                    </div>


                </div>

                <div class="card p-3">
                    <div class="card-title">Route Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Starting Point</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($route['origin']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Destination</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($route['destination']); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Depature Time</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e(\Carbon\Carbon::createFromFormat('H:i:s.u', $route['depature_time'])->format('h:i A')); ?></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <h5>Ticket Price / Cost</h5>
                            </div>
                            <div class="col-sm-6"><?php echo e($route['ticket_price']); ?></div>
                        </div>

                    </div>

                    <div class="alert alert-warning">
                        Please note that the price of the ticket is the actual transport money you have to pay for the journey from <?php echo e($route['origin']); ?> to <?php echo e($route['destination']); ?>.
                        <strong>By saving the ticket, you hereby confirm availablity for the journey.</strong>
                    </div>

                    <form id="save-ticket-form">
                        <input type="hidden" name="customer-id" value="<?php echo e($customer['user_id']); ?>">
                        <input type="hidden" name="route-id" value="<?php echo e($route['id']); ?>">
                        <button type="submit" class="btn btn-primary btn-sm">Save and Create Ticket</button>
                    </form>
                </div>

            </div>

        </div>
    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#save-ticket-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() == true) {

                let formData = new FormData(this);

                $.ajax({
                    method: "post",
                    url: "/<?php echo e($appName); ?>/routes/tickets/create/",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Toastify({
                            text: response.message || "Ticket Saved Successfully",
                            duration: 3000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#32a852',
                        }).showToast();

                        setTimeout(function() {
                            // window.location.reload()
                        }, 3500)
                    },

                    error: function(jqXHR, textStatus, errorThrow) {
                        if (jqXHR.status === 500) {

                            Toastify({
                                text: jqXHR.responseJSON.error,
                                duration: 4000,
                                gravity: 'bottom',
                                position: 'left',
                                backgroundColor: 'red',
                            }).showToast();

                        }
                    }
                })
            }
        })
    })
</script>