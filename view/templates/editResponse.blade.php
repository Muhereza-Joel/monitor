@include('partials/header')

@include('partials/topBar');
@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Edit Response Details</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Edit Response</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">
            <div class="col-sm-10">
                <div class="card p-2">
                    
                    <div class="card-body">
                        <div class="alert alert-secondary">
                            <h4>You are editing a response for</h4>
                            <i class="fw-bold">>>>> {{$indicator['indicator_title']}} indicator <<<<< </i>
                        </div>
                        <form action="" class="needs-validation" novalidate id="edit-response-form">
                            <div class="form-group my-2">
                                <label for="">Baseline In Percentage</label>
                                <input type="hidden" name="response-id" value="{{$response['id']}}">
                                <input name="baseline" required readonly type="number" value="{{$response['baseline']}}" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="">Current state</label>
                                <small class="text-danger"> (Must be a whole number)</small>
                                <input required id="current" value="{{$response['current']}}" name="current" type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Current Progress</label>
                                <input required id="progress" value="{{$response['progress']}}" name="progress" readonly type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Target In Percentage</label>
                                <input name="target" required readonly type="number" value="{{$response['target']}}" class="form-control">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Progress</label>
                                <div class="progress">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="">Notes</label><br>
                                <small class="text-success">Please use the editor to add notes to this response. You can bold, create lists and even add external links to other resources in case you need them.</small>
                                <hr>
                                <div id="notes-editor" style="height: 300px;">{!! $response['notes'] !!}</div>

                            </div>
                            <br>
                            <div class="form-group">
                                <label for="">Lessons learnt</label><br>
                                <small class="text-success">Please use the editor to add lessons learnt to this response. You can bold, create lists and even add external links to other resources in case you need them.</small>
                                <hr>
                                <div id="lessons-editor" style="height: 300px;">{!! $response['lessons'] !!}</div>
                                <div class="invalid-feedback d-block text-dark fw-bold" id="lessons-feedback" style="display: none;">Please note that lessons are required to add this response</div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="">Recommendations</label><br>
                                <small class="text-success">Please use the editor to add recommendations to this response. You can bold, create lists and even add external links to other resources in case you need them.</small>
                                <hr>
                                <div id="recommendations-editor" style="height: 300px;">{!! $response['recommendations'] !!}</div>

                            </div>
                            <br>
                            <div class="text-start">
                                <button id="update-response-btn" type="submit" class="btn btn-sm btn-primary">Save Changes</button>
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
        var baseline = parseFloat($('input[name="baseline"]').val());
        var target = parseFloat($('input[name="target"]').val());
        var current = parseFloat($('#current').val());

        // Function to update the progress bar
        function updateProgressBar(current) {
            var progress = ((current - baseline) / (target - baseline)) * 100;
            $('#progress').val(progress.toFixed(1));

            // Update progress bar
            $('#progress-bar').css('width', progress.toFixed(1) + '%');
            $('#progress-bar').attr('aria-valuenow', progress.toFixed(1));
            $('#progress-bar').text(progress.toFixed(1) + '%');
        }

        // Initialize the progress bar on page load
        if (!isNaN(current)) {
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
                    gravity: 'bottom', // Position the toast at the bottom
                    position: 'left', // Align toast to the left
                    backgroundColor: '#ff8282',
                }).showToast();
            } else {
                $('#current').removeClass('is-invalid');
                updateProgressBar(current);
            }
        });

        var quillLessons = new Quill('#lessons-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'align': []
                    }],
                    ['link'],
                ]
            }
        });

        var quillNotes = new Quill('#notes-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'align': []
                    }],
                    ['link'],
                ]
            }
        });

        var quillRecommendations = new Quill('#recommendations-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'font': []
                    }, {
                        'size': []
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'align': []
                    }],
                    ['link'],
                ]
            }
        });

        $('#edit-response-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {
                var lessons = quillLessons.root.innerHTML.trim();
                var notes = quillNotes.root.innerHTML.trim();
                var recommendations = quillRecommendations.root.innerHTML.trim();

                if (lessons === "" || lessons === "<p><br></p>") {
                    $('#lessons-feedback').show();
                    Toastify({
                        text: "Lessons learnt cannot be empty.",
                        duration: 3000,
                        gravity: 'bottom', // Position the toast at the bottom
                        position: 'left', // Align toast to the left
                        backgroundColor: '#ff8282',
                    }).showToast();
                } else {
                    $('#lessons-feedback').hide();
                    let formData = $(this).serialize();

                    // Add the Quill editor content to the form data
                    formData += '&lessons=' + encodeURIComponent(lessons);
                    formData += '&notes=' + encodeURIComponent(notes);
                    formData += '&recommendations=' + encodeURIComponent(recommendations);

                    $.ajax({
                        method: 'POST',
                        url: "/{{$appName}}/dashboard/manage-indicators/resposes/response/edit/",
                        data: formData,
                        success: function(response) {
                            Toastify({
                                text: response.message || "Record Updated Successfully...",
                                duration: 3000,
                                gravity: 'bottom', // Position the toast at the bottom
                                position: 'left', // Align toast to the left
                                backgroundColor: 'green',
                            }).showToast();

                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        },
                        error: function() {
                            Toastify({
                                text: "An error occurred. Please try again.",
                                duration: 3000,
                                gravity: 'bottom', // Position the toast at the bottom
                                position: 'left', // Align toast to the left
                                backgroundColor: '#ff8282',
                            }).showToast();
                        }
                    });
                }
            } else {
                this.classList.add('was-validated');
            }
        });
    });
</script>