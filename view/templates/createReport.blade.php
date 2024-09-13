@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Create Report For Indicator.</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
                <li class="breadcrumb-item active">Create Report</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row g-2">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card p-2">
                            <div class="card-title">Indicator Details</div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">Indicator Title</div>
                                    <div class="col-sm-8">
                                        <div class="form-control">{{$indicatorDetails['indicator_title']}}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">Indicator Definition</div>
                                    <div class="col-sm-8">
                                        <div class="form-control">{{$indicatorDetails['definition']}}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">Metrics</div>
                                    <div class="col-sm-8">
                                        <div class="form-control">
                                            Baseline: {{$indicatorDetails['baseline']}} &nbsp;&nbsp;&nbsp; Target: {{$indicatorDetails['target']}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">Data Source</div>
                                    <div class="col-sm-8">
                                        <div class="form-control">{{$indicatorDetails['data_source']}}</div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">Responsible</div>
                                    <div class="col-sm-8">
                                        <div class="form-control">{{$indicatorDetails['responsible']}}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">Reports are submitted to</div>
                                    <div class="col-sm-8">
                                        <div class="form-control">{{$indicatorDetails['reporting']}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card p-2">
                            <div class="card-title">Responses For This Indicator.</div>
                            <div class="card-body">
                                @foreach($responses as $response)
                                <div class="accordion w-100 mb-3" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{$response['id']}}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$response['id']}}" aria-expanded="false" aria-controls="collapse{{$response['id']}}">
                                                <span class="badge bg-success mx-2">{{$response['response_tag_label']}} from {{$response['name']}}</span>
                                                <div class="d-flex align-items-center">
                                                    <strong>Baseline:</strong> {{$response['baseline']}}&nbsp;&nbsp;
                                                    <strong>Current:</strong> {{$response['current']}}&nbsp;&nbsp;
                                                    <strong>Target:</strong> {{$response['target']}}&nbsp;&nbsp;
                                                    <strong>Progress:</strong> {{$response['progress']}}%
                                                    
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{$response['id']}}" class="accordion-collapse collapse" aria-labelledby="heading{{$response['id']}}" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                @php
                                                $notesContent = trim(strip_tags($response['notes'], '<p><br>'));
                                                    $lessonsContent = trim(strip_tags($response['lessons'], '
                                                <p><br>'));
                                                    $recommendationsContent = trim(strip_tags($response['recommendations'], '
                                                <p><br>'));
                                                    @endphp

                                                    @if(!empty($notesContent) && $notesContent !== '
                                                <p><br></p>')
                                                <h5 class="text-success">Notes Taken</h5>
                                                <p class="text-success">{!! $response['notes'] !!}</p>
                                                <hr>
                                                @endif

                                                @if(!empty($lessonsContent) && $lessonsContent !== '<p><br></p>')
                                                <h5 class="text-success">Lessons learnt</h5>
                                                <p class="text-success">{!! $response['lessons'] !!}</p>
                                                <hr>
                                                @endif

                                                @if(!empty($recommendationsContent) && $recommendationsContent !== '<p><br></p>')
                                                <h5 class="text-success">Recommendations</h5>
                                                <p class="text-success">{!! $response['recommendations'] !!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-start mt-3">
                    <button id="export-pdf-btn" class="btn btn-primary btn-sm" data-indicator-id="{{$indicatorId}}">
                        <i class="bi bi-file-earmark-pdf"></i> Export As PDF
                    </button>
                    <button id="export-word-btn" class="btn btn-secondary btn-sm" data-indicator-id="{{$indicatorId}}">
                        <i class="bi bi-file-earmark-word"></i> Export As Word
                    </button>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-2">
                    <div class="card-title">Previous Reports For Indicator.</div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </section>



</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {
        $('#export-pdf-btn').click(function(e) {
            e.preventDefault();
            var indicatorId = $(this).data('indicator-id');
            $.ajax({
                url: '/{{$appName}}/reports/pdf/export/single/',
                type: 'POST',
                data: {
                    indicator_id: indicatorId,
                },
                success: function(response) {
                    // Handle success response
                    
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Error exporting PDF');
                }
            });
        });

        $('#export-word-btn').click(function(e) {
            e.preventDefault();
            var indicatorId = $(this).data('indicator-id');
            $.ajax({
                url: '/{{$appName}}/reports/word/export/single/',
                type: 'POST',
                data: {
                    indicator_id: indicatorId,
                },
                success: function(response) {
                    // Handle success response
                    
                },
                error: function(xhr) {
                    // Handle error response
                    alert('Error exporting Word document');
                }
            });
        });
    });
</script>