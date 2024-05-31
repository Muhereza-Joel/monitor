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
                    <div class="card-title">Add Response</div>
                    <div class="card-body">
                        <form action="" class="needs-validation" novalidate id="add-response-form">
                            <div class="form-group my-2">
                                <label for="">Baseline In Percentage</label>
                                <input type="hidden" name="indicator-id" value="{{$indicator['id']}}">
                                <input name="baseline" required readonly type="number" value="{{$indicator['baseline']}}" class="form-control">
                            </div>
                            <div class="form-group my-2">
                                <label for="">Enter current state</label>
                                <input  required id="current" name="current" required type="number" max="20" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>
                            <div class="form-group my-2">
                                <label for="">Current Progress</label>
                                <input required id="progress" name="progress" required readonly type="number" class="form-control">
                                <div class="invalid-feedback">This value is required</div>
                            </div>

                            <div class="form-group my-2">
                                <label for="">Target In Percentage</label>
                                <input name="target" required readonly type="number" value="{{$indicator['target']}}" class="form-control">
                            </div>

                            <div class="form-group my-2">
                                <label for="">Progress</label>
                                <div class="progress">
                                    <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group my-2">
                                <label for="">Lessons learnt</label>
                                <textarea name="lessons" rows="20" id="" class="form-control" placeholder="Enter lessons learnt here"></textarea>
                            </div>
                            <br>
                            <div class="text-start">
                                <button id="create-response-btn" type="submit" class="btn btn-sm btn-primary">Submit</button>
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
        $('#current').on('input', function() {
            var current = parseFloat($(this).val());
            var target = parseFloat($('input[name="target"]').val());

            if (!isNaN(current) && !isNaN(target) && target != 0) {
                var progress = (current / target) * 100;
                $('#progress').val(progress.toFixed(1));

                // Update progress bar
                $('#progress-bar').css('width', progress.toFixed(1) + '%');
                $('#progress-bar').attr('aria-valuenow', progress.toFixed(1));
                $('#progress-bar').text(progress.toFixed(1) + '%');
            } else {
                $('#progress').val('');
                $('#progress-bar').css('width', '0%');
                $('#progress-bar').attr('aria-valuenow', 0);
                $('#progress-bar').text('0%');
            }
        });

        $('#add-response-form').submit(function(event) {
            event.preventDefault();

            if (this.checkValidity() === true) {

                let formData = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: "/{{$appName}}/dashboard/manage-indicators/resposes/create/",
                    data: formData,
                    success: function(response) {

                        Toastify({
                            text: response.message || "Record Saved Successfully...",
                            duration: 3000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: 'green',
                        }).showToast();

                        setTimeout(function() {
                            window.location.reload();
                        }, 3000)


                    },
                    error: function() {}
                })
            }
        })

    });
</script>
