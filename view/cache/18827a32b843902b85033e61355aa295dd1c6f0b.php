<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
                        <a href="#" class="dropdown-item"><i class="bi bi-book"></i>Export File</a>
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

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
  $(document).ready(function() {
    
  });
</script>