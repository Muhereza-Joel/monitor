<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">

  <div class="pagetitle">
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
      <div class="card">
        <div class="card-title">All Responses</div>
        <div class="card-body">
          <table class="table table-striped datatable">
            <thead>
              <tr>
                <th scope="col">SNo.</th>
                <th scope="col">Respondent</th>
                <th scope="col">Indicator and Lessons Learnt</th>
                <th scope="col">Achievements</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $__currentLoopData = $responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($response['name']); ?></td>
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
                           <h5 class="text-success">Lessons learnt</h5>
                          <p class="text-success"><?php echo $response['lessons']; ?></p>
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
                      <?php if($role == 'Administrator'): ?>
                      <a href="/<?php echo e($appName); ?>/dashboard/indicators/responses/edit?id=<?php echo e($response['id']); ?>" class="dropdown-item">Edit Indicator</a>
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
