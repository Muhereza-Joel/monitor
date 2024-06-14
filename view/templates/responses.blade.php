@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
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
                <th scope="col">Indicator and Lessons Learnt</th>
                <th scope="col">Stats</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($responses as $response)
              <tr>

                <td>{{$response['name']}}</td>
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
                      <a href="/{{$appName}}/dashboard/indicators/responses/edit?id={{$response['id']}}" class="dropdown-item">Edit Response</a>
                      @if($role == 'Administrator')
                      <a href="/{{$appName}}/dashboard/manage-indicators/resposes/delete?id={{$response['id']}}" class="dropdown-item text-danger" id="delete-btn">Delete Response</a>
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

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="confirmDeleteModalLabel">Confirm Your Action</h5>

      </div>
      <div class="modal-body">
        <h6 class="text-dark">Are you sure you want to execute this action?</h6>
        <div class="alert alert-warning p-2 mt-2">Note that this action will delete this response. Please continue with caution because the action is undoable</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" id="cancel-btn" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="btn btn-danger btn-sm">Yes, Delete Response</button>
      </div>
    </div>
  </div>
</div>

@include('partials/footer')

<script>
  $(document).ready(function() {
    $('#responses-table').on('click', '#delete-btn', function(event) {
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