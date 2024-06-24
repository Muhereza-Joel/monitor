<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<main id="main" class="main">
  <section class="section dashboard">
    <div class="alert alert-warning mt-2">
      <h5>Welcome back, <?php echo e($username); ?></h5>
      <h6 class="fw-bold">| modifying data is allowed to only members of this organisation. None members can only view data.</h6>
      <hr>
      <h6 class="badge bg-primary">
        You are on the
        <?php if($role == 'Administrator'): ?>
          Administrator
        <?php elseif($role == 'Viewer'): ?>
          Viewer
        <?php else: ?>
          User
        <?php endif; ?>
        dashboard
      </h6>
    </div>

      <?php if($role == 'Viewer'): ?>
        <div class="alert alert-danger p-2">
          <?php echo e($username); ?>, your permissions only allows you to view data. If you need to modify or delete any information, please contact the Administrator to update your permissions.
        </div>
      <?php endif; ?>

      <div class="row g-1 mt-4">
        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">All <span>| Active Indicators</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-graph-up"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo e($indicatorsCount); ?></h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">All <span>| Active Responses</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo e($responsesCount); ?></h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Your <span>| Responses</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo e($userResponsesCount); ?></h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">All <span>| Users</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-circle"></i>
                </div>
                <div class="ps-3">
                  <h6><?php echo e($usersCount); ?></h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
