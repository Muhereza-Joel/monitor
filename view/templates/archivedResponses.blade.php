@include('partials/header')

@include('partials/topBar')

@include('partials/leftPane')

<main id="main" class="main">

  <div class="pagetitle mt-3">
    <h1>All Archived Responses</h1>
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
                      <a href="#reponse-files" id="view-files" class="dropdown-item" data-response-id="{{$response['id']}}">
                        <i class="bi bi-file-earmark"></i> Response Files
                      </a>
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

<div class="modal fade" id="responseFilesModal" tabindex="-1" aria-labelledby="responseFilesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="responseFilesModalLabel">Response Files</h5>
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="files-section">
        <!-- Files for selected response will be displayed here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@include('partials/footer')

<script>
  $(document).ready(function() {

    $('#responses-table').on('click', '#view-files', function() {
      const responseId = $(this).data('response-id');
      $('#responseFilesModal').modal('show');

      // Make an AJAX request to fetch files for the given response ID
      $.ajax({
        url: `/{{$appName}}/archived/response/files/?response_id=${responseId}`,
        method: 'GET',
        success: function(data) {
          const filesSection = $('#files-section');
          filesSection.empty(); // Clear previous files

          const panel = $('<div></div>')
            .addClass('alert alert-light')
            .css('background-color', '#f8f9fa') // Set background color
            .append(
              $('<div></div>')
              .addClass('panel-body')
              .append(
                $('<div></div>')
                .addClass('list-group')
              )
            );

          data.files.forEach(file => {
            const fileNameWithoutExtension = file.original_name.split('.').slice(0, -1).join('.');
            const fileExtension = file.original_name.split('.').pop();
            const cleanedUrl = `{{$baseUrl}}/uploads/files/${file.unique_name}`;
            const fileLink = $('<a></a>')
              .attr('href', cleanedUrl)
              .text(`${file.original_name} (Added on: ${file.date_added} at ${file.time_added})`)
              .addClass('alert-link p-3')
              .on('click', function(event) {
                event.preventDefault(); // Prevent navigation

                // Trigger download via JavaScript
                downloadFile(cleanedUrl, file.original_name);
              });


            
            const listItem = $('<div></div>')
              .addClass('list-group-item d-flex justify-content-between align-items-center')
              .append(fileLink)
              

            panel.find('.list-group').append(listItem);
          });

          filesSection.append(panel);
        },
        error: function(xhr, status, error) {
          console.error('Error fetching files:', error);
        }
      });

      function downloadFile(url, fileName) {
        const link = document.createElement('a');
        link.href = url;
        link.download = fileName;
        console.log(link);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
      }
    });
  });
</script>