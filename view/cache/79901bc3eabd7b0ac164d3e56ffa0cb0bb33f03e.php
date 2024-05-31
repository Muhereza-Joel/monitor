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
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/check-in/">
      <i class="bi bi-card-list"></i>
      <span>Check In Users</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/catalog/">
      <i class="bi bi-card-list"></i>
      <span>Catalog</span>
    </a>
  </li>
  
  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/books/add-new/">
      <i class="bi bi-cart"></i>
      <span>Add New Book</span>
    </a>
  </li>
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/books/">
      <i class="bi bi-cart"></i>
      <span>Books</span>
    </a>
  </li>

  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/books/lent/">
      <i class="bi bi-shop-window"></i>
      <span>Lent Books</span>
    </a>
  </li>

  
  <li class="nav-item pb-2">
    <a class="nav-link collapsed" href="/<?php echo e($appName); ?>/users/">
      <i class="bi bi-people"></i>
      <span>Library Users</span>
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