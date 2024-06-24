<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">


    <?php if($role == 'Administrator'): ?>

    <li class="nav-item">
      <a class="nav-link " href="/<?php echo e($appName); ?>/dashboard/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link" href="/<?php echo e($appName); ?>/dashboard/organizations/choose/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organisation</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Create Indicators</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/resposes/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Responses</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/u/resposes/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>My Responses</span>
      </a>
    </li>
    <?php endif; ?>

    <hr>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/archived/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/all-archived-responses/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Archived Responses</span>
      </a>
    </li>

    <hr>


    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/users/add-new/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Create User</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/organizations/users/create/">
        <i class="bi bi-card-list"></i>
        <span>Create Organization User</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/organizations/create/">
        <i class="bi bi-card-list"></i>
        <span>Organizations</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/users/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Monitor Users</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/sign-out/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Log Out</span>
      </a>
    </li>


    <?php endif; ?>

    <?php if($role == 'User'): ?>

    <li class="nav-item">
      <a class="nav-link " href="/<?php echo e($appName); ?>/dashboard/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link" href="/<?php echo e($appName); ?>/dashboard/organizations/choose/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organisation</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Create Indicators</span>
      </a>
    </li>
    <?php endif; ?>


    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Indicators</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/u/resposes/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>My Responses</span>
      </a>
    </li>
    <?php endif; ?>

    <hr>
    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/archived/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/all-archived-responses/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Archived Responses</span>
      </a>
    </li>
    <hr>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/sign-out/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Log Out</span>
      </a>
    </li>

    <?php endif; ?>

    <?php if($role == 'Viewer'): ?>
    <li class="nav-item">
      <a class="nav-link " href="/<?php echo e($appName); ?>/dashboard/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link" href="/<?php echo e($appName); ?>/dashboard/organizations/choose/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organisation</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/archived/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/all-archived-responses/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>All Archived Responses</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/users/">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : "/{$appName}/assets/img/avatar.png"; ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Monitor Users</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/sign-out/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Log Out</span>
      </a>
    </li>
    <?php endif; ?>

  </ul>

</aside><!-- End Sidebar-->