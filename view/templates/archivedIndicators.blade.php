@include('partials/header')

@include('partials/topBar')

@include('partials/leftPane')


<main id="main" class="main">

  <div class="pagetitle mt-3">
    <h1>Indicators</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Indicators</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-1">
      <div class="card pt-4">

        <div class="card-body">
          
          <div class="table-responsive">
            <table class="table table-striped table-responsive datatable" id="indicators-table">
              <thead>
                <tr>
                  <th>Indicator</th>
                  <th>Definition</th>
                  <th>Stats</th>
                  <th>Data Source</th>
                  <th>Frequency</th>
                  <th>Responsible</th>
                  <th>Reporting</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($indicators as $indicator)
                <tr class="status-{{ strtolower($indicator['status']) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Status: {{ ucfirst($indicator['status']) }}">
                  <td>{{$indicator['indicator_title']}}
                    @if($indicator['response_count'] > 0)
                    <span class="badge bg-primary">
                      has {{$indicator['response_count']}} {{$indicator['response_count'] > 1 ? 'responses.' : 'response.'}}
                    </span>
                    @else
                    <span class="badge bg-warning">No responses added.</span>
                    @endif
                  </td>
                  <td>{{$indicator['definition']}}</td>
                  <td>
                    <div>
                      <strong>Baseline:</strong> {{$indicator['baseline']}}<br>
                      <strong>Target:</strong> {{$indicator['target']}}<br>
                      <strong>Cumulative Progress. <div class="progress">
                          <div class="progress-bar" role="progressbar" style="width: {{$indicator['cumulative_progress']}}%;" aria-valuenow="{{$indicator['cumulative_progress']}}" aria-valuemin="0" aria-valuemax="100">
                            {{$indicator['cumulative_progress']}}%
                          </div>
                        </div></strong>
                    </div>
                  </td>
                  <td>{{$indicator['data_source']}}</td>
                  <td>{{$indicator['frequency']}}</td>
                  <td>{{$indicator['responsible']}}</td>
                  <td>{{$indicator['reporting']}}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="actionDropdown">
                        <a href="/{{$appName}}/dashboard/indicators/responses/all?id={{$indicator['id']}}" class="dropdown-item">
                          <i class="bi bi-eye"></i> View Indicator Responses
                        </a>
                        @if($role == 'Administrator')
                          @if($myOrganisation['id'] == $indicator['organization_id'] || $myOrganisation['name'] == 'Administrator')
                            @if($indicator['status'] == 'draft' || $indicator['status'] == 'review')
                            <a data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Editing an indicator is only available when the indicator is in draft or review state." href="/{{$appName}}/dashboard/indicators/edit?id={{$indicator['id']}}" class="dropdown-item">
                              <i class="bi bi-pencil-square"></i> Edit Indicator
                            </a>
                            @endif
                          @endif
                        @endif
                        @if($role == 'Viewer')
                        <a href="/{{$appName}}/dashboard/indicators/archived/responses/all?id={{$indicator['id']}}" class="dropdown-item">
                          <i class="bi bi-eye"></i> View Indicator Responses
                        </a>
                        @endif
                        @if($role == 'User' || $role == 'Administrator')
                          @if($myOrganisation['id'] == $indicator['organization_id'] || $myOrganisation['name'] == 'Administrator')
                          <a  href="#" class="dropdown-item">
                          <i class="bi bi-book"></i> Export File
                          </a>
                           
                          @endif  
                        @endif
                      </div>
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
    </div>
  </section>


</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {
    // Initialize Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
  });
</script>