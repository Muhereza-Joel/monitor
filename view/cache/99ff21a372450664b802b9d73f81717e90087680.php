<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<style>
  .table-responsive {
    width: 100%;
    overflow-x: auto;
  }

  .status-draft {
    border-top: 8px solid #fc03a1;
    border-left: 3px solid #fc03a1;
  }

  .status-review {
    border-top: 8px solid #0a1157;
    border-left: 3px solid #0a1157;
  }

  .status-public {
    border-top: 8px solid green;
    border-left: 3px solid green;
  }

  .status-archived {
    border-top: 8px solid #1cc9be;
    border-left: 3px solid #1cc9be;
  }

  .status-key {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
  }

  .status-key span {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .status-key .key-draft {
    width: 20px;
    height: 10px;
    background-color: #fc03a1;
  }

  .status-key .key-review {
    width: 20px;
    height: 10px;
    background-color: #0a1157;
  }

  .status-key .key-public {
    width: 20px;
    height: 10px;
    background-color: green;
  }

  .status-key .key-archived {
    width: 20px;
    height: 10px;
    background-color: #1cc9be;
  }

  .drag-active {
    border: 2px dashed #28a745;
    /* Change border color */
    background-color: #f0f0f0;
    /* Light background */
    /* Add more styles as needed */
  }
</style>

<main id="main" class="main">

  <div class="pagetitle mt-3">
    <h1>All Responses</h1>
    <div class="d-flex align-items-center">
      <nav class="d-flex align-self-center w-50">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
          <li class="breadcrumb-item active">Responses</li>
        </ol>
      </nav>

      <div style="border-radius: 50%;" class="d-flex align-self-center justify-content-end w-50">
        <?php if($indicatorId != null): ?>
        <div class="btn-group" role="group" aria-label="Administrator Actions">
          <a data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Add More Responses To This Indicator."  class="btn btn-secondary btn-sm" href="/<?php echo e($appName); ?>/dashboard/indicators/responses/add/<?php echo e($indicatorId); ?>"><i class="bi bi-plus-circle"></i> Add More Responses</a>
          <a class="btn btn-secondary btn-sm" href="/<?php echo e($appName); ?>/dashboard/indicators/edit/<?php echo e($indicatorId); ?>"><i class="bi bi-pencil px-1"></i>Edit Indicator</a>
          
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-2">
      <div class="card pt-4">
        <div class="card-body">
          <div class="status-key">
            <span>
              <div class="key-draft"></div> Draft
            </span>
            <span>
              <div class="key-review"></div> Review
            </span>
            <span>
              <div class="key-public"></div> Public
            </span>
            <span>
              <div class="key-archived"></div> Archived
            </span>
          </div>
          <table class="table table-striped" id="responses-table">
            <thead>
              <tr>
                <th scope="col">Respondent</th>
                <th scope="col">Indicator, Notes, Lessons Learnt and Recommendations</th>
                <th scope="col">Stats</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr class="status-<?php echo e(strtolower($response['status'])); ?>">
                <td><span class="badge bg-success"><?php echo e($response['response_tag_label']); ?> from <br></span> <?php echo e($response['name']); ?></td>
                <td scope="row">
                  <div class="accordion w-100" id="accordionExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="heading<?php echo e($response['id']); ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($response['id']); ?>" aria-expanded="false" aria-controls="collapse<?php echo e($response['id']); ?>">
                          <strong>Indicator: <?php echo e($response['indicator_title']); ?></strong>
                        </button>
                      </h2>
                      <div id="collapse<?php echo e($response['id']); ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo e($response['id']); ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                          <?php 
                          $notesContent = trim(strip_tags($response['notes'], '<p><br>'));
                            $lessonsContent = trim(strip_tags($response['lessons'], '
                          <p><br>'));
                            $recommendationsContent = trim(strip_tags($response['recommendations'], '
                          <p><br>'));
                             ?>

                            <?php if(!empty($notesContent) && $notesContent !== '
                          <p><br></p>'): ?>
                          <h5 class="text-success">Notes Taken</h5>
                          <p class="text-success"><?php echo $response['notes']; ?></p>
                          <hr>
                          <?php endif; ?>

                          <?php if(!empty($lessonsContent) && $lessonsContent !== '<p><br></p>'): ?>
                          <h5 class="text-success">Lessons learnt</h5>
                          <p class="text-success"><?php echo $response['lessons']; ?></p>
                          <hr>
                          <?php endif; ?>

                          <?php if(!empty($recommendationsContent) && $recommendationsContent !== '<p><br></p>'): ?>
                          <h5 class="text-success">Recommendations</h5>
                          <p class="text-success"><?php echo $response['recommendations']; ?></p>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
                <td>
                  <div>
                    <strong>Baseline:</strong> <?php echo e($response['baseline']); ?><br>
                    <strong>Current:</strong> <?php echo e($response['current']); ?><br>
                    <strong>Target:</strong> <?php echo e($response['target']); ?><br>
                    <strong>Progress:</strong> <?php echo e($response['progress']); ?>%
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: <?php echo e($response['progress']); ?>%;" aria-valuenow="<?php echo e($response['progress']); ?>" aria-valuemin="0" aria-valuemax="100">
                        <?php echo e($response['progress']); ?>%
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
                      <?php if($role == 'Administrator' || $role == 'User'): ?>
                      <?php if($response['status'] == 'draft' || $response['status'] == 'review'): ?>
                      <?php if($myOrganisation['id'] == $response['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                      <a href="/<?php echo e($appName); ?>/dashboard/indicators/responses/edit/<?php echo e($response['id']); ?>" class="dropdown-item">
                        <i class="bi bi-pencil"></i> Edit Response
                      </a>
                      <a href="#add-files" id="add-file" class="dropdown-item" data-response-id="<?php echo e($response['id']); ?>" data-bs-toggle="modal" data-bs-target="#fileUploadModal">
                        <i class="bi bi-paperclip"></i> Add Files
                      </a>
                      <a href="#reponse-files" id="view-files" class="dropdown-item" data-response-id="<?php echo e($response['id']); ?>">
                        <i class="bi bi-file-earmark"></i> Response Files
                      </a>
                      <?php endif; ?>
                      <?php endif; ?>
                      <?php endif; ?>
                      <?php if($role == 'Administrator'): ?>
                      <?php if($response['status'] == 'draft'): ?>
                      <?php if($myOrganisation['id'] == $response['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                      <a href="/<?php echo e($appName); ?>/dashboard/manage-indicators/responses/delete/<?php echo e($response['id']); ?>" class="dropdown-item text-danger" id="delete-btn">
                        <i class="bi bi-trash"></i> Delete Response
                      </a>
                      <?php endif; ?>
                      <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </td>


              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<div class="modal fade lg" id="fileUploadModal" size="md" tabindex="-1" aria-labelledby="fileUploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fileUploadModalLabel">Upload Files</h5>
        <button type="button" class="close btn btn-light btn-sm" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-muted">You can choose files or drag and drop them into the area below:</p>
        <!-- File Upload Input -->
        <input type="file" multiple class="form-control" id="fileInput">
        <!-- Drag and Drop Area -->
        <div id="dropArea" style="height: 40vh; border: 2px dashed #ccc; padding: 20px; margin-top: 15px; text-align: center;">
          Drag and drop files here
        </div>
        <!-- Selected Files Container -->
        <div id="selectedFilesContainer" class="mt-3"></div>
        <!-- Hidden Input for File Links -->
        <input type="hidden" id="fileLinksInput" name="fileLinks">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-sm" id="uploadButton">Upload</button>
      </div>
    </div>
  </div>
</div>

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


<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    $('#responses-table').on('click', '#delete-btn', function(event) {
      event.preventDefault();
      var removeUrl = $(this).attr('href');
      $('#confirmDeleteModal').modal('show');
      $('#cancel-btn').click(function() {
        $('#confirmDeleteModal').modal('hide');
      });
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
          }, 3000);
        });
      });
    });

    $('#responses-table').on('click', '#view-files', function() {
      const responseId = $(this).data('response-id');
      $('#responseFilesModal').modal('show');

      // Make an AJAX request to fetch files for the given response ID
      $.ajax({
        url: `/<?php echo e($appName); ?>/response/files/?response_id=${responseId}`,
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
            const cleanedUrl = `<?php echo e($baseUrl); ?>/uploads/files/${file.unique_name}`;
            const fileLink = $('<a></a>')
              .attr('href', cleanedUrl)
              .text(`${file.original_name} (Added on: ${file.date_added} at ${file.time_added})`)
              .addClass('alert-link p-3')
              .on('click', function(event) {
                event.preventDefault(); // Prevent navigation

                // Trigger download via JavaScript
                downloadFile(cleanedUrl, file.original_name);
              });


            const removeButton = $('<button></button>')
              .text('Delete')
              .addClass('btn btn-danger btn-sm float-right')
              .on('click', function() {
                // Remove file logic here
                $.ajax({
                  url: `<?php echo e($baseUrl); ?>/file-remove/?response_id=${responseId}&file_id=${file.id}`,
                  type: 'DELETE',
                  success: function(response) {
                    // Remove the file link from the list
                    listItem.remove();
                    Toastify({
                      text: response.message || 'File Removed Successfully.',
                      duration: 5000,
                      gravity: 'bottom',
                      position: 'left',
                      backgroundColor: '#28a745',
                    }).showToast();
                  },
                  error: function(xhr, status, error) {
                    console.error('Failed to remove file:', error);
                  }
                });
              });

            const listItem = $('<div></div>')
              .addClass('list-group-item d-flex justify-content-between align-items-center')
              .append(fileLink)
              .append(removeButton);

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

    $('#dropArea').on('dragover', function(event) {
      event.preventDefault(); // Prevent default behavior
      $(this).addClass('drag-active');
    });

    $('#dropArea').on('dragleave drop', function(event) {
      event.preventDefault();
      $(this).removeClass('drag-active').empty();
    });

    $('#dropArea').on('drop', function(event) {
      event.preventDefault();
      var files = event.originalEvent.dataTransfer.files;
      if (files.length > 0) {
        var fileType = files[0].type;
        var fileName = files[0].name; // Get the file name
        var iconHtml = ''; // Default icon
        if (fileType.includes('word') || fileType.includes('document')) {
          iconHtml = '<i class="bi bi-file-word file-icon h1"></i> ';
        } else if (fileType.includes('excel') || fileType.includes('spreadsheet')) {
          iconHtml = '<i class="bi bi-file-excel file-icon h1"></i> ';
        } else if (fileType.includes('pdf')) {
          iconHtml = '<i class="bi bi-file-pdf file-icon h1"></i> ';
        } else if (fileType.includes('image')) {
          iconHtml = '<i class="bi bi-file-image file-icon h1"></i> ';
        }
        $('#dropArea').html(iconHtml + fileName); // Insert the icon HTML and file name
      }
    });

    $('#fileUploadModal').on('hidden.bs.modal', function() {
      $('#dropArea').empty();
    });
  });
</script>

<script>
  $(document).ready(function() {
    let selectedFiles = [];
    let responseId = null;

    $('#fileUploadModal').on('show.bs.modal', function(event) {
      const button = $(event.relatedTarget); // Button that triggered the modal
      responseId = button.data('response-id'); // Extract info from data-* attributes
    });

    // Handle file selection
    function handleFiles(files) {
      for (let file of files) {
        selectedFiles.push(file);
        displayFile(file);
      }
      updateFileInput();
    }

    // Display file in the selected files container
    function displayFile(file) {
      const fileType = file.type;
      let iconHtml = '';
      if (fileType.includes('word') || fileType.includes('document')) {
        iconHtml = '<i class="bi bi-file-word file-icon h1"></i>';
      } else if (fileType.includes('excel') || fileType.includes('spreadsheet')) {
        iconHtml = '<i class="bi bi-file-excel file-icon h1"></i>';
      } else if (fileType.includes('pdf')) {
        iconHtml = '<i class="bi bi-file-pdf file-icon h1"></i>';
      } else if (fileType.includes('image')) {
        iconHtml = '<i class="bi bi-file-image file-icon h1"></i>';
      } else {
        iconHtml = '<i class="bi bi-file-earmark file-icon h1"></i>';
      }

      const fileBox = `
      <div class="file-box" data-file-name="${file.name}">
        ${iconHtml} <span>${file.name}</span>
        <button type="button" class="btn btn-danger btn-sm remove-file-btn">Remove</button>
      </div>`;
      $('#selectedFilesContainer').append(fileBox);
    }

    // Handle file removal
    $('#selectedFilesContainer').on('click', '.remove-file-btn', function() {
      const fileName = $(this).closest('.file-box').data('file-name');
      selectedFiles = selectedFiles.filter(file => file.name !== fileName);
      $(this).closest('.file-box').remove();
      updateFileInput();
    });

    // Handle drag and drop
    $('#dropArea').on('dragover', function(event) {
      event.preventDefault();
      $(this).addClass('drag-active');
    });

    $('#dropArea').on('dragleave drop', function(event) {
      event.preventDefault();
      $(this).removeClass('drag-active');
    });

    $('#dropArea').on('drop', function(event) {
      event.preventDefault();
      const files = event.originalEvent.dataTransfer.files;
      handleFiles(files);
    });

    // Handle file input selection
    $('#fileInput').on('change', function(event) {
      const files = event.target.files;
      handleFiles(files);
    });

    // Update the file input with the current selected files
    function updateFileInput() {
      const dataTransfer = new DataTransfer();
      selectedFiles.forEach(file => dataTransfer.items.add(file));
      $('#fileInput')[0].files = dataTransfer.files;
    }

    // Handle upload button click
    $('#uploadButton').on('click', function() {
      const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
      const validFiles = selectedFiles.filter(file => allowedTypes.includes(file.type));

      if (validFiles.length === 0) {
        Toastify({
          text: 'No valid files selected. Only images, PDF, Word, and Excel files are allowed.',
          duration: 5000,
          gravity: 'bottom',
          position: 'left',
          backgroundColor: '#f44336',
        }).showToast();

        return;
      }

      if (validFiles.length !== selectedFiles.length) {
        Toastify({
          text: 'Some files are not allowed, please remove them. Only images, PDF, Word, and Excel files are allowed.',
          duration: 5000,
          gravity: 'bottom',
          position: 'left',
          backgroundColor: '#f44336',
        }).showToast();

        return;
      }
      const fileLinks = selectedFiles.map(file => URL.createObjectURL(file));
      $('#fileLinksInput').val(JSON.stringify(fileLinks));

      // Perform AJAX upload
      const formData = new FormData();
      validFiles.forEach(file => formData.append('files[]', file));
      formData.append('responseId', responseId);

      $.ajax({
        url: '<?php echo e($baseUrl); ?>/file-upload/',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          Toastify({
            text: response.message || 'Files Added Successfully.',
            duration: 5000,
            gravity: 'bottom',
            position: 'left',
            backgroundColor: '#28a745',
          }).showToast();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Toastify({
            text: jqXHR.responseJSON.error || 'Filled to upload files.',
            duration: 5000,
            gravity: 'bottom',
            position: 'left',
            backgroundColor: '#f44336',
          }).showToast();
        }
      });

      console.log(fileLinks); // For debugging
    });
    // Clear selected files when the modal is closed
    $('#fileUploadModal').on('hidden.bs.modal', function() {
      selectedFiles = [];
      responseId = null;
      $('#selectedFilesContainer').empty();
      $('#fileLinksInput').val('');
      $('#fileInput').val('');
      $('#dropArea').removeClass('drag-active');
    });
  });
</script>