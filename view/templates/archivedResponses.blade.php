@include('partials/header')

@include('partials/topBar')

@include('partials/leftPane')

<main id="main" class="main">

  <div class="pagetitle mt-3">
    <h1>All Responses</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Responses</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-2">
      <div class="card pt-4">
        <div class="card-body">
          <table class="table table-striped datatable" id="responses-table">
            <thead>
              <tr>
                <th scope="col">Respondent</th>
                <th scope="col">Indicator, Notes, Lessons Learnt and Recommendations</th>
                <th scope="col">Stats</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($responses as $response)
              <tr class="status-{{ strtolower($response['status']) }}">
                <td><span class="badge bg-success">{{$response['response_tag_label']}} from <br></span> {{$response['name']}}</td>
                <td scope="row">
                  <div class="accordion w-100" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading{{$response['id']}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$response['id']}}" aria-expanded="false" aria-controls="collapse{{$response['id']}}">
                          <strong>Indicator: {{$response['indicator_title']}}</strong>
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
                </td>
                <td>
                  <div>
                    <strong>Baseline:</strong> {{$response['baseline']}}<br>
                    <strong>Current:</strong> {{$response['current']}}<br>
                    <strong>Target:</strong> {{$response['target']}}<br>
                    <strong>Progress:</strong> {{$response['progress']}}%
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: {{$response['progress']}}%;" aria-valuenow="{{$response['progress']}}" aria-valuemin="0" aria-valuemax="100">
                        {{$response['progress']}}%
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      @if($role == 'Administrator' || $role == 'User')
                        @if($myOrganisation['id'] == $response['organization_id'] || $myOrganisation['name'] == 'Administrator')
                        <a href="#" class="dropdown-item"><i class="bi bi-book"></i>Export File</a>
                        @endif
                      @endif
                     
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {
    
  });
</script>