<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

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
        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Indicators</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-2">
      <div class="card">
        <div class="card-title">
          All Indicators
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped datatable table-responsive" id="indicators-table">
              <thead>
                <tr>
                  <th>SNo.</th>
                  <th>Indicator</th>
                  <th>Definition</th>
                  <th>Baseline</th>
                  <th>Target</th>
                  <th>Progress</th>
                  <th>Data Source</th>
                  <th>Frequency</th>
                  <th>Responsible</th>
                  <th>Reporting</th>
                  <th>Action</th>

                </tr>
              </thead>
              <tbody>
                <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($loop->iteration); ?></td>
                  <td><?php echo e($indicator['indicator_title']); ?></td>
                  <td><?php echo e($indicator['definition']); ?></td>
                  <td><?php echo e($indicator['baseline']); ?></td>
                  <td><?php echo e($indicator['target']); ?></td>
                  <td>
                   
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" style="width: <?php echo e($indicator['cumulative_progress']); ?>%;" aria-valuenow="<?php echo e($indicator['cumulative_progress']); ?>" aria-valuemin="0" aria-valuemax="100">
                        <?php echo e($indicator['cumulative_progress']); ?>%
                      </div>
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
                        <?php if($role == 'Administrator'): ?>
                        <a href="/<?php echo e($appName); ?>/dashboard/indicators/edit?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">Edit Indicator</a>
                        <a href="/<?php echo e($appName); ?>/dashboard/manage-indicators/delete/?id=<?php echo e($indicator['id']); ?>" class="dropdown-item text-danger" id="delete-btn">Delete Indicator</a>
                        <?php endif; ?>

                        <?php if($role == 'User' || $role == 'Administrator'): ?>

                        <a href="/<?php echo e($appName); ?>/dashboard/indicators/responses/add?id=<?php echo e($indicator['id']); ?>" class="dropdown-item">Add Response</a>
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

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
