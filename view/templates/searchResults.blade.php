@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');


<main id="main" class="main">

    <div class="pagetitle">
        <h5 class="fw-bold mb-3">Showing all search results based on  <i class="text-primary">{{$query}}</i> query</h5>
        
    </div>

    <section class="section">
        <div class="row">
            @if($category == 'responses_archive')
                <div class="accordion" id="resultsAccordion">
                    @foreach ($results as $index => $row)
                    <div class="accordion-item mb-2">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="true" aria-controls="collapse{{ $index }}">
                                <div class="d-flex"><h6>Response </h6><span class="badge bg-info mx-2">{{$row['status']}}</span> on {{$row['created_at']}}</div>
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}" data-bs-parent="#resultsAccordion">
                            <div class="accordion-body">

                                @php
                                $notesContent = trim(strip_tags($row['notes'], '<p><br>'));
                                    $lessonsContent = trim(strip_tags($row['lessons'], '
                                <p><br>'));
                                    $recommendationsContent = trim(strip_tags($row['recommendations'], '
                                <p><br>'));
                                    @endphp

                                    @if(!empty($notesContent) && $notesContent !== '
                                <p><br></p>')
                                <h5 class="text-success">Notes Taken</h5>
                                <p class="text-success">{!! $row['notes'] !!}</p>
                                <hr>
                                @endif

                                @if(!empty($lessonsContent) && $lessonsContent !== '<p><br></p>')
                                <h5 class="text-success">Lessons learnt</h5>
                                <p class="text-success">{!! $row['lessons'] !!}</p>
                                <hr>
                                @endif

                                @if(!empty($recommendationsContent) && $recommendationsContent !== '<p><br></p>')
                                <h5 class="text-success">Recommendations</h5>
                                <p class="text-success">{!! $row['recommendations'] !!}</p>
                                @endif


                            </div>
                        </div>
                    </div>
                    <hr>

                    @endforeach
                </div>
            @endif

        </div>
    </section>


</main><!-- End #main -->

@include('partials/footer')

<script>
    $(document).ready(function() {

    })
</script>