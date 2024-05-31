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
    <a class="nav-link collapsed" href="#">
      <i class="bi bi-card-list"></i>
      <span>Customers</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#">
      <i class="bi bi-card-list"></i>
      <span>Employees</span>
    </a>
  </li>
  
  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="#">
      <i class="bi bi-card-list"></i>
      <span>Schedules</span>
    </a>
  </li>
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="#">
      <i class="bi bi-cart"></i>
      <span>Supplies</span>
    </a>
  </li>

  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="#">
      <i class="bi bi-shop-window"></i>
      <span>Orders</span>
    </a>
  </li>

  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/users/">
      <i class="bi bi-people"></i>
      <span>Invoices</span>
    </a>
  </li>
  
  <!-- <li class="nav-heading mb-3">Reports</li>

  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/dashboard/reports/branch-store/">
      <i class="bi bi-shop-window"></i>
      <span>Branch - Store</span>
    </a>
  </li> -->
  
  <?php endif; ?>

</ul>

</aside><!-- End Sidebar-->