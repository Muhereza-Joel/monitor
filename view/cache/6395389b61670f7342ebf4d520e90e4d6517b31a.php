<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">


    <?php if($role == 'Administrator'): ?>

    <li class="nav-item">
      <a class="nav-link " href="/<?php echo e($appName); ?>/dashboard/">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link" href="/<?php echo e($appName); ?>/dashboard/organizations/choose/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organization</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/">
        <i class="bi bi-card-list"></i>
        <span>Create Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/">
        <i class="bi bi-card-list"></i>
        <span>All Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/resposes/">
        <i class="bi bi-card-list"></i>
        <span>All Responses</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/u/resposes/">
        <i class="bi bi-card-list"></i>
        <span>My Responses</span>
      </a>
    </li>


    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/users/add-new/">
        <i class="bi bi-card-list"></i>
        <span>Create User</span>
      </a>
    </li>

    <?php if($myOrganisation['name'] == 'Administrator'): ?>
      <li class="nav-item pb-2">
        <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/organizations/create/">
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

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/users/">
        <i class="bi bi-card-list"></i>
        <span>Monitor Users</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>

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
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link" href="/<?php echo e($appName); ?>/dashboard/organizations/choose/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organization</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/">
        <i class="bi bi-card-list"></i>
        <span>Create Indicators</span>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/">
        <i class="bi bi-card-list"></i>
        <span>All Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/manage-indicators/u/resposes/">
        <i class="bi bi-card-list"></i>
        <span>My Responses</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>

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
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item pb-2">
      <a class="nav-link" href="/<?php echo e($appName); ?>/dashboard/organizations/choose/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Switch Organization</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/indicators/archived/">
        <i class="bi bi-card-list"></i>
        <span>All Archived Indicators</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/all-archived-responses/">
        <i class="bi bi-card-list"></i>
        <span>All Archived Responses</span>
      </a>
    </li>
    
    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/users/">
        <i class="bi bi-card-list"></i>
        <span>Monitor Users</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/sign-out/">
        <i class="bi bi-box-arrow-right"></i>
        <span>Log Out</span>
      </a>
    </li>
    <?php endif; ?>

  </ul>

</aside><!-- End Sidebar-->