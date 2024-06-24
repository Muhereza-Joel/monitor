<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


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
                <?php $__currentLoopData = $indicators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indicator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="status-<?php echo e(strtolower($indicator['status'])); ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="Status: <?php echo e(ucfirst($indicator['status'])); ?>">
                  <td><?php echo e($indicator['indicator_title']); ?>

                    <?php if($indicator['response_count'] > 0): ?>
                    <span class="badge bg-primary">
                      has <?php echo e($indicator['response_count']); ?> <?php echo e($indicator['response_count'] > 1 ? 'responses.' : 'response.'); ?>

                    </span>
                    <?php else: ?>
                    <span class="badge bg-warning">No responses added.</span>
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
                          <a  href="#" class="dropdown-item">
                             Export Report
                          </a>
                           
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


</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    // Initialize Bootstrap tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
  });
</script>