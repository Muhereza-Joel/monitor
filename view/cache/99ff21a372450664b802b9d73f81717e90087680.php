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
</style>

<main id="main" class="main">

  <div class="pagetitle mt-3">
    <h1>All Responses</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Responses</li>
      </ol>
    </nav>
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
                        <?php if($myOrganisation['id'] == $response['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                        <a href="/<?php echo e($appName); ?>/dashboard/indicators/responses/edit?id=<?php echo e($response['id']); ?>" class="dropdown-item">Edit Response</a>
                        <?php endif; ?>
                      <?php endif; ?>
                      <?php if($role == 'Administrator'): ?>
                        <?php if($response['status'] == 'draft'): ?>
                          <?php if($myOrganisation['id'] == $response['organization_id'] || $myOrganisation['name'] == 'Administrator'): ?>
                          <a href="/<?php echo e($appName); ?>/dashboard/manage-indicators/responses/delete?id=<?php echo e($response['id']); ?>" class="dropdown-item text-danger" id="delete-btn">Delete Response</a>
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
  });
</script>