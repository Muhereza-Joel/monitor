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
                        <th>SNo.</th>
                        <th>Respondent</th>
                        <th>Indicator</th>
                        <th>Lessons</th>
                        <th>Baseline</th>
                        <th>Current</th>
                        <th>Progress</th>
                        <th>Target</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($response['name']); ?></td>
                            <td><?php echo e($response['indicator_title']); ?></td>
                            <td><p class="text-success"><?php echo e($response['lessons']); ?></p></td>
                            <td><?php echo e($response['baseline']); ?></td>
                            <td><?php echo e($response['current']); ?></td>
                            <td><?php echo e($response['progress']); ?></td>
                            <td><?php echo e($response['target']); ?></td>
                            
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