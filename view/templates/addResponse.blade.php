@include('partials/header')

@include('partials/topBar');
@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Add Response To Indicator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Add Response</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">
            <div class="col-sm-10">
                <div class="card p-2">

                    <div class="card-body">
                        <form action="" class="needs-validation" novalidate id="add-response-form">

                            @if(isset($lastCurrentState['last_current_state']) && $lastCurrentState['last_current_state'] == $indicator['target'])
                            <div class="alert alert-warning">The target for this indicator was achieved..</div>
                            @else
                            <div class="alert alert-secondary">
                                <h4>You are adding a response to</h4>
                                <i class="fw-bold">>>>> {{$indicator['indicator_title']}} indicator <<<< </i>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Indicator Baseline</label>
                                <input id="indicator-id" type="hidden" name="indicator-id" value="{{$indicator['id']}}">
                                <input type="hidden" name="last_current_state" value="{{ isset($lastCurrentState['last_current_state']) ? $lastCurrentState['last_current_state'] : '' }}">
                                <input name="baseline" required readonly type="number" value="{{$indicator['baseline']}}" class="form-control">
                            </div>
                            <div class="form-group my-2 alert alert-info">
                                <label for="">Previous State Entered</label>
                                <input type="text" class="form-control" readonly value="{{ isset($lastCurrentState['last_current_state']) ? $lastCurrentState['last_current_state'] : 'No response added yet' }}">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Enter current state</label>
                                <small class="text-danger"> (Must be a whole number)</small>
                                <input required id="current" name="current" type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Current Progress</label>
                                <input required id="progress" name="progress" readonly type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Target For Indicator</label>
                                <input name="target" required readonly type="number" value="{{$indicator['target']}}" class="form-control">
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
                                <div class="quill-editor" id="notes-editor-container" style="height: 300px;"></div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="">Lessons learnt</label><br>
                                <small class="text-success">Please use the editor to add lessons learnt to this response. You can bold, create lists and even add external links to other resources in case you need them.</small>
                                <hr>
                                <div class="quill-editor" id="editor-container" style="height: 300px;"></div>
                                <div class="invalid-feedback d-block text-dark fw-bold" id="editor-feedback" style="display: none;">Please note that lessons are required to add this response</div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="">Recommendations</label><br>
                                <small class="text-success">Please use the editor to add recommendations to this response. You can bold, create lists and even add external links to other resources in case you need them.</small>
                                <hr>
                                <div class="quill-editor" id="recommendations-editor-container" style="height: 300px;"></div>
                            </div>
                            <br>
                            <div class="text-start">
                                <button id="create-response-btn" type="submit" class="btn btn-sm btn-primary">Submit Response</button>
                            </div>
                            @endif
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
        var lastCurrentState = parseFloat($('input[name="last_current_state"]').val()) || baseline;

        // Initial progress calculation
        var initialProgress = (lastCurrentState - baseline) / (target - baseline) * 100;
        initialProgress = isNaN(initialProgress) ? 0 : initialProgress;
        $('#progress').val(initialProgress.toFixed(1));
        $('#progress-bar').css('width', initialProgress.toFixed(1) + '%');
        $('#progress-bar').attr('aria-valuenow', initialProgress.toFixed(1));
        $('#progress-bar').text(initialProgress.toFixed(1) + '%');

        $('#current').on('input', function() {
            var current = parseFloat($(this).val());

            if (isNaN(current) || current < lastCurrentState || current > target) {
                $('#current').addClass('is-invalid');
                $('#progress').val('');
                $('#progress-bar').css('width', '0%');
                $('#progress-bar').attr('aria-valuenow', 0);
                $('#progress-bar').text('0%');

                Toastify({
                    text: "Current state must be between " + lastCurrentState + " and " + target,
                    duration: 3000,
                    gravity: 'bottom', // Position the toast at the bottom
                    position: 'left', // Align toast to the left
                    backgroundColor: '#ff8282',
                }).showToast();
            } else {
                $('#current').removeClass('is-invalid');
                var progress = ((current - baseline) / (target - baseline)) * 100;
                $('#progress').val(progress.toFixed(1));

                // Update progress bar
                $('#progress-bar').css('width', progress.toFixed(1) + '%');
                $('#progress-bar').attr('aria-valuenow', progress.toFixed(1));
                $('#progress-bar').text(progress.toFixed(1) + '%');
            }
        });

        var quill = new Quill('#editor-container', {
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

        var notesQuill = new Quill('#notes-editor-container', {
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

        var recommendationsQuill = new Quill('#recommendations-editor-container', {
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

        $('#add-response-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {
                var lessons = quill.root.innerHTML.trim();
                var notes = notesQuill.root.innerHTML.trim();
                var recommendations = recommendationsQuill.root.innerHTML.trim();

                if (lessons === "" || lessons === "<p><br></p>") {
                    $('#editor-feedback').show();
                    Toastify({
                        text: "Lessons learnt cannot be empty.",
                        duration: 3000,
                        gravity: 'bottom', // Position the toast at the bottom
                        position: 'left', // Align toast to the left
                        backgroundColor: '#ff8282',
                    }).showToast();
                } else {
                    $('#editor-feedback').hide();

                    var current = parseFloat($('#current').val());
                    var progress = (current - baseline) / (target - baseline) * 100;

                    // Validate current state before submission
                    if (isNaN(current) || current < lastCurrentState || current > target) {
                        Toastify({
                            text: "Current state must be between " + lastCurrentState + " and " + target,
                            duration: 3000,
                            gravity: 'bottom', // Position the toast at the bottom
                            position: 'left', // Align toast to the left
                            backgroundColor: '#ff8282',
                        }).showToast();
                        return;
                    }

                    $.ajax({
                        url: '/{{$appName}}/dashboard/manage-indicators/resposes/create/',
                        method: 'POST',
                        data: {
                            indicator_id: $('input[name="indicator-id"]').val(),
                            baseline: baseline,
                            current: current,
                            target: target,
                            progress: progress.toFixed(1),
                            lessons: lessons,
                            notes: notes,
                            recommendations: recommendations,
                        },
                        success: function(response) {
                            Toastify({
                                text: "Response added successfully!",
                                duration: 3000,
                                gravity: 'bottom', // Position the toast at the bottom
                                position: 'left', // Align toast to the left
                                backgroundColor: '#28a745',
                            }).showToast();
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(response) {
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

        loadFormData($('input[name="indicator-id"]').val());

        // Save form data on input change
        $('form input, form select, form textarea').on('change', function() {
            saveFormData();
        });

        var editors = [quill, notesQuill, recommendationsQuill];
        editors.forEach(function(editor) {
            editor.on('text-change', function(delta, oldDelta, source) {
                saveFormData();
            });
        });


        $('form').on('submit', function() {
            localStorage.removeItem('monitorresponsedata');
        });

        function saveFormData() {

            var formData = {};
            $('form').find('input[name], select[name], textarea[name]').each(function() {
                formData[$(this).attr('name')] = $(this).val();
            });

            var lessons = quill.root.innerHTML.trim();
            var notes = notesQuill.root.innerHTML.trim();
            var recommendations = recommendationsQuill.root.innerHTML.trim()

            formData['lessons'] = lessons;
            formData['notes'] = notes;
            formData['recommendations'] = recommendations;

            localStorage.setItem('monitorresponsedata', JSON.stringify(formData));
        }


        function loadFormData(indicatorId) {
            var savedData = localStorage.getItem('monitorresponsedata');
            if (savedData) {
                savedData = JSON.parse(savedData);

                if (savedData['indicator-id'] && savedData['indicator-id'] === indicatorId) {

                    Toastify({
                        text: "You have unsaved response data for this indicator, it has been restored for you.",
                        duration: 90000,
                        gravity: 'top',
                        position: 'center',
                        close: true,
                    }).showToast();


                    for (var key in savedData) {
                        if (key !== 'lessons' && key !== 'notes' && key !== 'recommendations' && key !== 'indicator-id') {
                            var $field = $('form').find('[name="' + key + '"]');
                            if ($field.length > 0) {
                                $field.val(savedData[key]);
                            }
                        }
                    }

                    var quillEditors = {
                        'lessons': quill,
                        'notes': notesQuill,
                        'recommendations': recommendationsQuill
                    };

                    for (var key in quillEditors) {
                        if (savedData.hasOwnProperty(key)) {
                            var quillEditor = quillEditors[key];
                            if (quillEditor) {
                                quillEditor.root.innerHTML = savedData[key];
                            }
                        }
                    }
                }
            }
        }

    });
</script>