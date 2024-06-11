<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Response Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Edit Response</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">
            <div class="col-sm-10">
                <div class="card p-2">
                    <div class="card-title">Edit Response</div>
                    <div class="card-body">
                        <form action="" class="needs-validation" novalidate id="add-response-form">
                            <div class="form-group my-2">
                                <label for="">Baseline In Percentage</label>
                                <input type="hidden" name="response-id" value="<?php echo e($response['id']); ?>">
                                <input name="baseline" required readonly type="number" value="<?php echo e($response['baseline']); ?>" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="">Current state</label>
                                <input required id="current" value="<?php echo e($response['current']); ?>" name="current" type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Current Progress</label>
                                <input required id="progress" value="<?php echo e($response['current']); ?>" name="progress" readonly type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Target In Percentage</label>
                                <input name="target" required readonly type="number" value="<?php echo e($response['target']); ?>" class="form-control">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Progress</label>
                                <div class="progress">
                                    <div id="progress-bar"  class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="">Lessons learnt</label>
                                <div id="editor-container" style="height: 300px;"><?php echo $response['lessons']; ?></div>
                                <div class="invalid-feedback d-block text-dark fw-bold" id="editor-feedback" style="display: none;">Please note that lessons are required to add this response</div>
                            </div>
                            <br>
                            <div class="text-start">
                                <button id="create-response-btn" type="submit" class="btn btn-sm btn-primary">Update</button>
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
        var baseline = parseFloat($('input[name="baseline"]').val());
        var target = parseFloat($('input[name="target"]').val());
        var current = parseFloat($('#current').val());

        // Function to update the progress bar
        function updateProgressBar(current) {
            var progress = (current / target) * 100;
            $('#progress').val(progress.toFixed(1));

            // Update progress bar
            $('#progress-bar').css('width', progress.toFixed(1) + '%');
            $('#progress-bar').attr('aria-valuenow', progress.toFixed(1));
            $('#progress-bar').text(progress.toFixed(1) + '%');
        }

        // Initialize the progress bar on page load
        if (!isNaN(current) && current >= baseline && current <= target) {
            updateProgressBar(current);
        }

        $('#current').on('input', function() {
            current = parseFloat($(this).val());

            if (isNaN(current) || current < baseline || current > target) {
                $('#current').addClass('is-invalid');
                $('#progress').val('');
                $('#progress-bar').css('width', '0%');
                $('#progress-bar').attr('aria-valuenow', 0);
                $('#progress-bar').text('0%');

                Toastify({
                    text: "Current state must be between " + baseline + " and " + target,
                    duration: 3000,
                    gravity: 'bottom', // Position the toast at the top
                    position: 'left', // Center the toast horizontally
                    backgroundColor: '#ff8282',
                }).showToast();
            } else {
                $('#current').removeClass('is-invalid');
                updateProgressBar(current);
            }
        });

        var quill = new Quill('#editor-container', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'font': [] }, { 'size': [] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['link'],
                ]
            }
        });

        $('#add-response-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {
                var lessons = quill.root.innerHTML.trim();
                
                if (lessons === "" || lessons === "<p><br></p>") {
                    $('#editor-feedback').show();
                    Toastify({
                        text: "Lessons learnt cannot be empty.",
                        duration: 3000,
                        gravity: 'bottom', // Position the toast at the top
                        position: 'left', // Center the toast horizontally
                        backgroundColor: '#ff8282',
                    }).showToast();
                } else {
                    $('#editor-feedback').hide();
                    let formData = $(this).serialize();

                    // Add the Quill editor content to the form data
                    formData += '&lessons=' + encodeURIComponent(lessons);

                    $.ajax({
                        method: 'POST',
                        url: "/<?php echo e($appName); ?>/dashboard/manage-indicators/resposes/response/edit/",
                        data: formData,
                        success: function(response) {
                            Toastify({
                                text: response.message || "Record Updated Successfully...",
                                duration: 3000,
                                gravity: 'bottom', // Position the toast at the top
                                position: 'left', // Center the toast horizontally
                                backgroundColor: 'green',
                            }).showToast();

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        },
                        error: function() {}
                    });
                }
            }
        });
    });
</script>

