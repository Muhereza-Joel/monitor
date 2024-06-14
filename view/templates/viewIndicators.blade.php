@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<style>
  .table-responsive {
    width: 100%;
    overflow-x: auto;
  }
</style>


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Indicators</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Indicators</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-2">
      <div class="card pt-4">

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped datatable table-responsive" id="indicators-table">
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
                <tr>

                  <td>{{$indicator['indicator_title']}}

                    @if($indicator['response_count'] > 0)
                    <span class="badge bg-primary">
                      {{$indicator['response_count']}} {{$indicator['response_count'] > 1 ? 'responses so far.' : 'response so far.'}}
                    </span>
                    @else
                    <span class="badge bg-warning">No responses yet.</span>
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
                        @if($role == 'Administrator')
                        <a href="/{{$appName}}/dashboard/indicators/edit?id={{$indicator['id']}}" class="dropdown-item">Edit Indicator</a>
                        <a href="/{{$appName}}/dashboard/indicators/responses/all?id={{$indicator['id']}}" class="dropdown-item">View Indicator Responses</a>
                        @endif

                        @if($role == 'Viewer')
                        <a href="/{{$appName}}/dashboard/indicators/responses/all?id={{$indicator['id']}}" class="dropdown-item">View Indicator Responses</a>
                        @endif
                        
                        @if($role == 'User' || $role == 'Administrator')
                        <a href="/{{$appName}}/dashboard/indicators/responses/add?id={{$indicator['id']}}" class="dropdown-item">Add Response</a>
                        @endif
                        
                        @if($role == 'Administrator')
                        <a href="/{{$appName}}/dashboard/manage-indicators/delete/?id={{$indicator['id']}}" class="dropdown-item text-danger" id="delete-btn">Delete Indicator</a>
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
    </div>

  </section>

  <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-warning p-2 mt-2">Note that this action will delete this indicator with all its responses. Please continue with caution because the action is undoable</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Delete Indicator</button>
        </div>
      </div>
    </div>
  </div>

</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {
    $('#indicators-table').on('click', '#delete-btn', function(event) {
      event.preventDefault();

      var removeUrl = $(this).attr('href');

      $('#confirmDeleteModal').modal('show');
      $('#cancel-btn').click(function() {
        $('#confirmDeleteModal').modal('hide');

      })

      $('#confirmDeleteModal').on('click', '#confirmDeleteBtn', function() {
        $.post(removeUrl, function(response) {
          Toastify({
            text: response.message || 'Record Deleted Successfully',
            duration: 2000,
            gravity: 'bottom',
            backgroundColor: 'green',
          }).showToast();

          setTimeout(function() {
            window.location.reload();

          }, 3000)
        });
      });
    })
  })
</script>