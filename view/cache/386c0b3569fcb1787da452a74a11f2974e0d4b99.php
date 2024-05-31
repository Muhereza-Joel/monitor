<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">


    <?php if($role == 'Administrator' || $role == 'Staff'): ?>

    <li class="nav-item">
      <a class="nav-link " href="/<?php echo e($appName); ?>/dashboard/">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <li class="nav-heading mb-3">Modules</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/branches/">
        <i class="bi bi-card-list"></i>
        <span>Branches</span>
      </a>
    </li>


    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/stores/">
        <i class="bi bi-card-list"></i>
        <span>Stores</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/inventory/products/">
        <i class="bi bi-card-list"></i>
        <span>Products</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/inventory/">
        <i class="bi bi-card-list"></i>
        <span>Inventory</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/orders/">
        <i class="bi bi-card-list"></i>
        <span>Requests / Orders</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/orders/payments/">
        <i class="bi bi-card-list"></i>
        <span>Payments</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/reports/">
        <i class="bi bi-card-list"></i>
        <span>Reports & Analysis</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/customers/">
        <i class="bi bi-card-list"></i>
        <span>Customers</span>
      </a>
    </li>

    <hr>
    <li class="nav-item">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/auth/user/profile/">
        <i class="bi bi-card-list"></i>
        <span>My Profile</span>
      </a>
    </li>

    <li class="nav-item">
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

    <!-- <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/inventory/products/">
        <i class="bi bi-card-list"></i>
        <span>Products</span>
      </a>
    </li> -->

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/inventory/">
        <i class="bi bi-card-list"></i>
        <span>Inventory</span>
      </a>
    </li>

    <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/my-orders/">
        <i class="bi bi-card-list"></i>
        <span>My Orders / Requests</span>
      </a>
    </li>



    <!-- <li class="nav-item pb-2">
      <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/u/payments/">
        <i class="bi bi-card-list"></i>
        <span>My Payments</span>
      </a>
    </li> -->

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