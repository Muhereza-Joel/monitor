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

    <li class="nav-heading mb-3">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/customers/">
        <i class="bi bi-card-list"></i>
        <span>Customers</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/routes/">
        <i class="bi bi-card-list"></i>
        <span>Routes / Journeys</span>
      </a>
    </li>


    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/tickets/">
        <i class="bi bi-card-list"></i>
        <span>Tickets / Book List</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/payments/">
        <i class="bi bi-card-list"></i>
        <span>Payments</span>
      </a>
    </li>

    <hr>
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

    <?php if($role == 'Customer'): ?>
    <li class="nav-item pb-2">
      <a class="nav-link " href="/<?php echo e($appName); ?>/dashboard/">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/routes/">
        <i class="bi bi-card-list"></i>
        <span>Routes / Journeys</span>
      </a>
    </li>


    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/u/tickets/">
        <i class="bi bi-card-list"></i>
        <span>My Tickets</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/u/payments/">
        <i class="bi bi-card-list"></i>
        <span>My Payments</span>
      </a>
    </li>

    <hr>
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