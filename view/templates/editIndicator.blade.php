@include('partials/header')

@include('partials/topBar')

@include('partials/leftPane')

<main id="main" class="main">

    <div class="pagetitle mt-4">
        <h1>Manage Indicators</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Indicator Details</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row g-1">
            <div class="col-sm-8">
                <div class="card p-2">
                    <div class="card-title">Edit Indicator</div>
                    <div class="card-body">
                        <form action="" class="needs-validation" novalidate id="update-indicator-form">
                            <div class="form-group my-2">
                                <label for="indicator-title">Indicator Title</label>
                                <input type="hidden" value="{{$indicator['id']}}" name="indicator-id">
                                <textarea type="text" name="indicator-title" required class="form-control">{{$indicator['indicator_title']}}</textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="definition">Definition</label><br>
                                <small class="text-success">How it is calculated</small>
                                <textarea type="text" name="definition" required class="form-control">{{$indicator['definition']}}</textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="baseline">Baseline</label><br>
                                <small class="text-success">What is the current value?</small>
                                <input type="number" name="baseline" value="{{$indicator['baseline']}}" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="target">Target</label><br>
                                <small class="text-success">What is the target value? Must be greater than the baseline.</small>
                                <input type="number" name="target" value="{{$indicator['target']}}" required class="form-control">
                                <div class="invalid-feedback">This field is required and must be greater than the baseline</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="data-source">Data Source</label><br>
                                <small class="text-success">How will it be measured?</small>
                                <textarea type="text" name="data-source" required class="form-control">{{$indicator['data_source']}}</textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="frequency">Frequency</label><br>
                                <small class="text-success">How often will it be measured?</small>
                                <input type="text" name="frequency" value="{{$indicator['frequency']}}" required class="form-control">
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="responsible">Responsible</label><br>
                                <small class="text-success">Who will measure it?</small>
                                <textarea type="text" name="responsible" required class="form-control">{{$indicator['responsible']}}</textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="reporting">Reporting</label><br>
                                <small class="text-success">Where will it be reported?</small>
                                <textarea type="text" name="reporting" required class="form-control">{{$indicator['reporting']}}</textarea>
                                <div class="invalid-feedback">This field is required</div>
                            </div>

                            <div class="text-start">
                                <button type="submit" class="btn btn-sm btn-primary">Update Indicator Details</button>
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

                        <div class="alert alert-warning">
                            When you update the target, all progress values for responses attached to this indicator will be calculated automatically using the new target value.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {
        $('#update-indicator-form').submit(function(event) {
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
                    url: "/{{$appName}}/dashboard/manage-indicators/update/",
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
                        }, 2000);
                    },
                    error: function() {
                        Toastify({
                            text: "An error occurred while updating the record.",
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
