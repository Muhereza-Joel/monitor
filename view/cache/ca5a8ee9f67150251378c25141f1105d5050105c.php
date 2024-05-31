<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Manage Indicators</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Indicator Details</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">
            <div class="col-sm-8">
                <div class="card p-2">
                    <div class="card-title">Edit Indicator</div>
                    <div class="card-body">
                        <form action="" class="needs-validation" novalidate id="update-indicator-form">
                            <div class="form-group my-2">
                                <label for="">Indicator Title</label>
                                <input type="hidden" value="<?php echo e($indicator['id']); ?>" name="indicator-id">
                                <textarea type="text" name="indicator-title" required class="form-control"><?php echo e($indicator['indicator_title']); ?></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>


                            <div class="form-group my-2">
                                <label for="">Definition</label><br>
                                <small class="text-success">How it is calculated</small>
                                <textarea type="text" name="definition" required class="form-control"><?php echo e($indicator['definition']); ?></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Baseline</label><br>
                                <small class="text-success">What is the current value?</small>
                                <input type="number" name="baseline" value="<?php echo e($indicator['baseline']); ?>" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>


                            <div class="form-group my-2">
                                <label for="">Target</label><br>
                                <small class="text-success">What is the target value?</small>
                                <input type="number" name="target" value="<?php echo e($indicator['target']); ?>" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Data Source</label><br>
                                <small class="text-success">How will it be measured?</small>
                                <textarea type="text" name="data-source" required class="form-control"><?php echo e($indicator['data_source']); ?></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Frequency</label><br>
                                <small class="text-success">How often will it be measured?</small>
                                <input type="text" name="frequency" value="<?php echo e($indicator['frequency']); ?>" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Responsible</label><br>
                                <small class="text-success">Who will measure it?</small>
                                <textarea type="text" name="responsible" required class="form-control"><?php echo e($indicator['responsible']); ?></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Reporting</label><br>
                                <small class="text-success">Where will it be reported?</small>
                                <textarea type="text" name="reporting" required class="form-control"><?php echo e($indicator['reporting']); ?></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>


                            <div class="text-start">
                                <button type="submit" class="btn btn-sm btn-primary">Update Indicator Details</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {


        $('#update-indicator-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "/<?php echo e($appName); ?>/dashboard/manage-indicators/update/",
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Record Updated Successfully...",
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'green',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload();
                        }, 2000)


                    },
                    error: function() {}
                })
            }
        })

    })
</script>