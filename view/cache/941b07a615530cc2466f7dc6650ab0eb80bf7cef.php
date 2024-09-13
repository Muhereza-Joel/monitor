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

  .archive-button {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 5px;
  }
</style>

<main id="main" class="main">

  <div class="pagetitle mt-3">
    <h1>Indicators</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Indicators</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-1">
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
            <div class="text-end">
              <?php if($publicAndArchivedIndicatorsCount > 0 && $chosenOrganisationId == $myOrganisation['id']): ?>
              <span id="move-to-archive-btn" class="btn btn-light btn-sm"> Move <span class="badge bg-primary" id="public-archived-count"><?php echo e($publicAndArchivedIndicatorsCount); ?></span> <?php echo e($publicAndArchivedIndicatorsCount > 1 ? 'Indicators' : 'Indicator'); ?> To Archives.</span>
              <?php endif; ?>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-responsive" id="indicators-table">
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
                <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="status-<?php echo e(strtolower($indicator['status'])); ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="Status: <?php echo e(ucfirst($indicator['status'])); ?>">
                  <td><?php echo e($indicator['indicator_title']); ?>

                    <?php if($indicator['response_count'] > 0): ?>
                    <span class="badge bg-primary">
                      <?php echo e($indicator['response_count']); ?> <?php echo e($indicator['response_count'] > 1 ? 'responses so far.' : 'response so far.'); ?>

                    </span>
                    <?php else: ?>
                    <span class="badge bg-warning">No responses yet.</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo e($indicator['definition']); ?></td>
                  <td>
                    <div>
                      <strong>Baseline:</strong> <?php echo e($indicator['baseline']); ?><br>
                      <strong>Target:</strong> <?php echo e($indicator['target']); ?><br>
                      <strong>Cumulative Progress. <div class="progress">
                          <div class="progress-bar" role="progressbar" style="width: <?php echo e($indicator['cumulative_progress']); ?>%;" aria-valuenow="<?php echo e($indicator['cumulative_progress']); ?>" aria-valuemin="0" aria-valuemax="100">
                            <?php echo e($indicator['cumulative_progress']); ?>%
                          </div>
                        </div></strong>
                    </div>
                  </td>
                  <td><?php echo e($indicator['data_source']); ?></td>
                  <td><?php echo e($indicator['frequency']); ?></td>
                  <td><?php echo e($indicator['responsible']); ?></td>
                  <td><?php echo e($indicator['reporting']); ?></td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="actionDropdown">
                        <a href="/<?php echo e($appName); ?>/dashboard/indicators/responses/all?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">
                          <i class="bi bi-eye"></i> View Indicator Responses
                        </a>
                        <?php if($role == 'Administrator'): ?>
                        <?php if($myOrganisation['id'] == $indicator['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                        <?php if($indicator['status'] == 'draft' || $indicator['status'] == 'review'): ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Editing an indicator is only available when the indicator is in draft or review state." href="/<?php echo e($appName); ?>/dashboard/indicators/edit?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">
                          <i class="bi bi-pencil-square"></i> Edit Indicator
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php if($role == 'Viewer'): ?>
                        <a href="/<?php echo e($appName); ?>/dashboard/indicators/responses/all?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">
                          <i class="bi bi-eye"></i> View Indicator Responses
                        </a>
                        <?php endif; ?>

                        <?php if($role == 'User' || $role == 'Administrator'): ?>
                        <?php if($myOrganisation['id'] == $indicator['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                        <?php if($indicator['status'] == 'draft'): ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Adding responses to an indicator is only available when the indicator is in draft or review state." href="/<?php echo e($appName); ?>/dashboard/indicators/responses/add?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">
                          <i class="bi bi-plus-circle"></i> Add Response
                        </a>
                        <?php endif; ?>
                        <?php if($indicator['status'] == 'draft'): ?>
                        <a id="review-indicator-btn" href="/<?php echo e($appName); ?>/dashboard/indicators/status/update?id=<?php echo e($indicator['id']); ?>&status=review" class="dropdown-item">
                          <i class="bi bi-pencil"></i> Review Indicator
                        </a>
                        <?php endif; ?>
                        <?php if($indicator['status'] == 'review'): ?>
                        <a id="publish-indicator-btn" href="/<?php echo e($appName); ?>/dashboard/indicators/status/update?id=<?php echo e($indicator['id']); ?>&status=public" class="dropdown-item">
                          <i class="bi bi-globe"></i> Make Indicator Public
                        </a>
                        <?php endif; ?>
                        <?php if($indicator['status'] == 'archived'): ?>
                        <a href="/<?php echo e($appName); ?>/dashboard/reports/create-report/?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">
                          <i class="bi bi-file-earmark"></i> Create Report
                        </a>
                        <?php endif; ?>
                        <?php if($indicator['status'] == 'review' || $indicator['status'] == 'public'): ?>
                        <a id="archive-indicator-btn" href="/<?php echo e($appName); ?>/dashboard/indicators/status/update?id=<?php echo e($indicator['id']); ?>&status=archived" class="dropdown-item">
                          <i class="bi bi-archive"></i> Archive Indicator
                        </a>
                        <a href="/<?php echo e($appName); ?>/dashboard/reports/create-report/?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">
                          <i class="bi bi-file-earmark"></i> Create Report
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>

                        <?php if($role == 'Administrator'): ?>
                        <?php if($myOrganisation['id'] == $indicator['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                        <?php if($indicator['status'] == 'draft'): ?>
                        <a data-bs-toggle="tooltip" data-bs-placement="left" data-bs-original-title="Deleting an indicator is only available when the indicator is in draft state." href="/<?php echo e($appName); ?>/dashboard/manage-indicators/delete/?id=<?php echo e($indicator['id']); ?>" class="dropdown-item text-danger" id="delete-btn">
                          <i class="bi bi-trash"></i> Delete Indicator
                        </a>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endif; ?>
                      </div>
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

  <div class="modal fade" id="reviewIndicatorModal" tabindex="-1" role="dialog" aria-labelledby="reviewIndicatorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="reviewIndicatorModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-info p-1 mt-2">Note that this action will move the indicator to the riew status and will update all responses for this indicator to review as well. Continue with caution because the action is irreversible!</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-review-indicator-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmReviewIndicatorModalBtn" class="btn btn-secondary btn-sm">Yes, Update Indicator Status</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="publishIndicatorModal" tabindex="-1" role="dialog" aria-labelledby="publishIndicatorModalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="publishIndicatorModalModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-danger">When you make this indicator public, this indicator will be archived as well when archiving indicators.</div>
          <div class="alert alert-info p-1 mt-2">Note that this action will move the indicator to the public status and will update all responses for this indicator to public as well. Continue with caution because the action is irreversible!</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-publish-indicator-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmPublishIndicatorModalBtn" class="btn btn-secondary btn-sm">Yes, Update Indicator Status</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="archiveIndicatorModal" tabindex="-1" role="dialog" aria-labelledby="archiveIndicatorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="archiveIndicatorModalLabel">Confirm Your Action</h5>

        </div>
        <div class="modal-body">
          <h6 class="text-dark">Are you sure you want to execute this action?</h6>
          <div class="alert alert-info p-1 mt-2">Note that this action will move the indicator to the archived status and will update all responses for this indicator to archived as well. Continue with caution because the action is irreversible!</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-archive-indicator-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmrArchiveIndicatorModalBtn" class="btn btn-secondary btn-sm">Yes, Update Indicator Status</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="moveToArchiveModal" tabindex="-1" role="dialog" aria-labelledby="moveToArchiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-dark" id="moveToArchiveModalLabel">Confirm Your Action</h5>
        </div>
        <div class="modal-body">
          <h6 class="text-dark">You are about to move all public and archived indicators and their responses to archives. Are you sure you want to proceed?</h6>
          <div class="alert alert-warning p-2 mt-2">Please note that this action is irreversible. Proceed with caution.</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" id="cancel-move-to-archive-btn" data-dismiss="modal">Cancel</button>
          <button type="button" id="confirmMoveToArchiveBtn" class="btn btn-success btn-sm">Yes, Move to Archives</button>
        </div>
      </div>
    </div>
  </div>



</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    // Initialize Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('#indicators-table').on('click', '#delete-btn', function(event) {
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


    $('#indicators-table').on('click', '#review-indicator-btn', function(event) {
      event.preventDefault();

      var url = $(this).attr('href');

      $('#reviewIndicatorModal').modal('show');
      $('#confirmReviewIndicatorModalBtn').on('click', function(event) {
        $('#reviewIndicatorModal').modal('hide');

        $.ajax({
          method: 'POST',
          url: url,
          success: function(response) {

            Toastify({
              text: response.message || "Indicator Status Updated Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function() {}
        })
      })

      $('#cancel-review-indicator-btn').on('click', function(event) {
        $('#reviewIndicatorModal').modal('hide');
      })
    })


    $('#indicators-table').on('click', '#publish-indicator-btn', function(event) {
      event.preventDefault();

      var url = $(this).attr('href');

      $('#publishIndicatorModal').modal('show');
      $('#confirmPublishIndicatorModalBtn').on('click', function(event) {
        $('#publishIndicatorModal').modal('hide');

        $.ajax({
          method: 'POST',
          url: url,
          success: function(response) {

            Toastify({
              text: response.message || "Indicator Status Updated Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function() {}
        })
      })

      $('#cancel-publish-indicator-btn').on('click', function(event) {
        $('#publishIndicatorModal').modal('hide');
      })
    })


    $('#indicators-table').on('click', '#archive-indicator-btn', function(event) {
      event.preventDefault();

      var url = $(this).attr('href');

      $('#archiveIndicatorModal').modal('show');
      $('#confirmrArchiveIndicatorModalBtn').on('click', function(event) {
        $('#archiveIndicatorModal').modal('hide');

        $.ajax({
          method: 'POST',
          url: url,
          success: function(response) {

            Toastify({
              text: response.message || "Indicator Status Updated Successfully...",
              duration: 4000,
              gravity: 'bottom',
              position: 'left',
              backgroundColor: 'green',
            }).showToast();

            setTimeout(function() {
              window.location.reload();
            }, 2000)
          },
          error: function() {}
        })
      })

      $('#cancel-archive-indicator-btn').on('click', function(event) {
        $('#archiveIndicatorModal').modal('hide');
      })
    })

    // Handle the click event for the "Move All to Archives" button
    $('#move-to-archive-btn').on('click', function() {
      $('#moveToArchiveModal').modal('show');
    });

    // Handle the click event for the confirm button in the modal
    $('#confirmMoveToArchiveBtn').on('click', function() {
      var endpointUrl = '/<?php echo e($appName); ?>/dashboard/indicators/move-to-archives/'; // Replace with your actual endpoint URL

      // Make the AJAX request
      $.ajax({
        method: 'POST',
        url: endpointUrl,
        success: function(response) {
          Toastify({
            text: response.message || "All public and archived indicators moved to archives successfully.",
            duration: 5000,
            gravity: 'bottom',
            position: 'left',
            backgroundColor: 'green',
          }).showToast();

          // Reload the page after a delay
          setTimeout(function() {
            window.location.reload();
          }, 3000);
        },
        error: function() {
          Toastify({
            text: "An error occurred while moving indicators to archives.",
            duration: 4000,
            gravity: 'bottom',
            position: 'left',
            backgroundColor: 'red',
          }).showToast();
        }
      });

      // Hide the modal
      $('#moveToArchiveModal').modal('hide');
    });

    // Handle the cancel button click in the modal
    $('#cancel-move-to-archive-btn').on('click', function() {
      $('#moveToArchiveModal').modal('hide');
    });
  });
</script>