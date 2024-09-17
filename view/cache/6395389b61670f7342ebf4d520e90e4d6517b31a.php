<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <style>
    .nav-link.active {
      color: #fff;
      border-left: 10px solid #14445e;
      background-color: #181f1d;
    }
  </style>

  <?php 

  use core\Request;
  $currentPath = Request::path();
   ?>

  <ul class="sidebar-nav" id="sidebar-nav">

    <?php if($role == 'Administrator'): ?>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard') ? 'active' : ''; ?> " href="<?php echo e(url('dashboard', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/organizations/choose/') ? 'active' : ''; ?> " href="<?php echo e(url('dashboard/organizations/choose/', null, true)); ?>">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organisation</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/manage-indicators/') ? 'active' : 'collapsed'; ?> " href="<?php echo e(url('dashboard/manage-indicators/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Create Indicators</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/manage-events/') ? 'active' : 'collapsed'; ?> " href="<?php echo e(url('dashboard/manage-events/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Manage Events</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/indicators/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/indicators/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Active Indicators</span>
      </a>
    </li>

    
    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/manage-indicators/resposes/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/manage-indicators/resposes/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Responses</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/manage-indicators/u/resposes/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/manage-indicators/u/resposes/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>My Responses</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/indicators/archived/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/indicators/archived/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/all-archived-responses/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/all-archived-responses/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Archived Responses</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/users/add-new/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/users/add-new/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Create User</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/organizations/users/create/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/organizations/users/create/', null, true)); ?>">
        <i class="bi bi-card-list"></i>
        <span>Create Organization User</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/organizations/create/') ? 'active' : 'collapsed'; ?> "  href="<?php echo e(url('dashboard/organizations/create/', null, true)); ?>">
        <i class="bi bi-card-list"></i>
        <span>Organizations</span>
      </a>
    </li>
    <?php endif; ?>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/users/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/users/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Monitor Users</span>
      </a>
    </li>
    <?php endif; ?>

    <?php endif; ?>

    <?php if($role == 'User'): ?>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/') ? 'active' : ''; ?>" href="<?php echo e(url('dashboard/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/organizations/choose/') ? 'active' : ''; ?>" href="<?php echo e(url('dashboard/organizations/choose/', null, true)); ?>">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organisation</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/manage-indicators/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/manage-indicators/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Create Indicators</span>
      </a>
    </li>
    <?php endif; ?>


    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/indicators/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/indicators/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Active Indicators</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/manage-indicators/u/resposes/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/manage-indicators/u/resposes/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>My Responses</span>
      </a>
    </li>
    <?php endif; ?>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/indicators/archived/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/indicators/archived/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/all-archived-responses/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/all-archived-responses/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Archived Responses</span>
      </a>
    </li>

    <?php endif; ?>

    <?php if($role == 'Viewer'): ?>
    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/') ? 'active' : ''; ?>" href="<?php echo e(url('dashboard/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/organizations/choose/') ? 'active' : ''; ?>" href="<?php echo e(url('dashboard/organizations/choose/', null, true)); ?>">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organisation</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/indicators/archived/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/indicators/archived/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?php echo $currentPath == url('dashboard/all-archived-responses/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/all-archived-responses/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Archived Responses</span>
      </a>
    </li>

    <?php if($myOrganisation['id'] == $chosenOrganisationId || $myOrganisation['name'] == 'Administrator'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link <?php echo $currentPath == url('dashboard/users/') ? 'active' : 'collapsed'; ?>" href="<?php echo e(url('dashboard/users/', null, true)); ?>">
        <?php $imageUrl = isset($chosenOrganisationLogo) ? $chosenOrganisationLogo : asset('img/avatar.png'); ?>
        <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mx-1" width="25px" height="25px">
        <span>Monitor Users</span>
      </a>
    </li>
    <?php endif; ?>

    <?php endif; ?>

  </ul>

</aside><!-- End Sidebar-->