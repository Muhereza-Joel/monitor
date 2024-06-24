<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<main id="main" class="main">

    <div class="pagetitle mt-4">
        <h1>Manage Indicators</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Manage Indicators</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row g-1">
            <div class="col-sm-8">
                <div class="card p-2">
                    <div class="card-title">Create New Indicator</div>
                    <div class="alert alert-warning p-2">This indicator you are about to create will belong to <span class="badge bg-primary"><?php echo e($myOrganisation['name']); ?></span></div>
                    <div class="card-body">
                        <form action="" class="needs-validation" novalidate id="create-indicator-form">
                            <div class="form-group my-2">
                                <label for="indicator-title">Indicator Title</label>
                                <textarea type="text" name="indicator-title" required class="form-control"></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="definition">Definition</label><br>
                                <small class="text-success">How it is calculated</small>
                                <textarea type="text" name="definition" required class="form-control"></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="baseline">Baseline</label><br>
                                <small class="text-success">What is the current value?</small>
                                <input type="number" name="baseline" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="target">Target</label><br>
                                <small class="text-success">What is the target value? Must be greater than the baseline.</small>
                                <input type="number" name="target" required class="form-control">
                                <div class="invalid-feedback">This field is required and must be greater than the baseline</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="data-source">Data Source</label><br>
                                <small class="text-success">How will it be measured?</small>
                                <textarea type="text" name="data-source" required class="form-control"></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="frequency">Frequency</label><br>
                                <small class="text-success">How often will it be measured?</small>
                                <input type="text" name="frequency" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="responsible">Responsible</label><br>
                                <small class="text-success">Who will measure it?</small>
                                <textarea type="text" name="responsible" required class="form-control"></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="reporting">Reporting</label><br>
                                <small class="text-success">Where will it be reported?</small>
                                <textarea type="text" name="reporting" required class="form-control"></textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="text-start">
                                <button type="submit" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card p-2">
                    <div class="card-title">Instructions</div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Indicator Title:</strong> Provide a brief and descriptive title for the indicator.</li>
                            <li><strong>Definition:</strong> Explain how the indicator is calculated.</li>
                            <li><strong>Baseline:</strong> Enter the current value of the indicator.</li>
                            <li><strong>Target:</strong> Set the target value. It must be greater than the baseline.</li>
                            <li><strong>Data Source:</strong> Specify how the data will be collected.</li>
                            <li><strong>Frequency:</strong> Indicate how often the data will be collected (e.g., monthly, quarterly).</li>
                            <li><strong>Responsible:</strong> Identify who is responsible for measuring the indicator.</li>
                            <li><strong>Reporting:</strong> Mention where the results will be reported.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </section>

</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
    $(document).ready(function() {
        $('#create-indicator-form').submit(function(event) {
            event.preventDefault();
            
            let baseline = parseFloat($('input[name="baseline"]').val());
            let target = parseFloat($('input[name="target"]').val());
            
            if (target <= baseline) {
                $('input[name="target"]').addClass('is-invalid');
                Toastify({
                    text: "Target value must be greater than the baseline.",
                    duration: 4000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#ff8282',
                }).showToast();
                return;
            }

            if (this.checkValidity() === true) {
                let formData = $(this).serialize();
                
                $.ajax({
                    method: 'POST',
                    url: "/<?php echo e($appName); ?>/dashboard/manage-indicators/create/",
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
                            window.location.reload();
                        }, 2000);
                    },
                    error: function() {
                        Toastify({
                            text: "An error occurred while saving the record.",
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#ff8282',
                        }).showToast();
                    }
                });
            }
        });
    });
</script>
