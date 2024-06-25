<style>
    .organisation-card {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .organisation-card.selected {
        border: 3px solid #007bff;
        transform: scale(0.9);
    }

    .organisation-card:hover {
        transform: scale(0.9);
    }
</style>

<form id="choose-organisation-form" class="row g-3 needs-validation" novalidate>
    <div class="row g-1" style="display: flex; flex-wrap: wrap;">
        <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($row['active'] == 'true'): ?>
        <div class="col-sm-4 d-flex">
            <div class="card p-2 flex-fill organisation-card" data-org-id="<?php echo e($row['id']); ?>">
                <div class="card-title"><?php echo e($row['name']); ?></div>
                
                <div class="card-body text-center">
                    <img style="width: 150px; object-fit: contain; border: 3px solid #999" src="<?php echo e($row['logo']); ?>" alt="logo" class="rounded-circle">
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <br>

    <div class="text-center">
        <a id="proceed-button" class="btn btn-primary btn-sm d-none" >Proceed</a>
    </div>
    <div class="text-center mt-2">
        <a href="<?php echo e($callbackUrl); ?>" class="btn btn-link">Go Back To Previous Page.</a>
    </div>
</form>


