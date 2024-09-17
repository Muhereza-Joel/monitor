<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <i class="bi bi-list toggle-sidebar-btn"></i>
    <a href="<?php echo e(url('dashboard', null, true)); ?>" class="logo d-flex align-items-center">
      <span class="d-none d-lg-block">M & E Monitor</span>
    </a>
  </div><!-- End Logo -->

  <div class="d-flex ps-3 ms-3">
    <?php $imageUrl = isset($myOrganisation['logo']) ? $myOrganisation['logo'] : asset('img/placeholder.png'); ?>
    <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mt-3" width="40px" height="40px">
    <h4 class="h6 text-light mt-3"> <?php echo e($myOrganisation['name']); ?> <br>
      <small>is your organisation</small>
    </h4>
  </div>

  <nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">


    <li class="nav-item dropdown pe-3">

      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="<?php echo e($avator); ?>" alt="Profile" class="rounded-circle" width="40px" height="40px" style="object-fit: cover;">
        <span class="d-none d-md-block dropdown-toggle px-2">Hello, <?php echo e($username); ?></span>
      </a><!-- End Profile Iamge Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
          <span class="text-primary">Signed In As</span>
          <h6><?php echo e($username); ?></h6>
         
        <li>
          <hr class="dropdown-divider">
        </li>

        
          <li>
            <a class="dropdown-item d-flex align-items-center justify-content-start" href="<?php echo e(url('auth/user/profile/', null, true)); ?>">
              <i class="bi bi-person"></i>
              <span>Your Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>
        
        <li>
          <a class="dropdown-item d-flex align-items-center justify-content-start" href="#">
            <i class="bi bi-gear"></i>
            <span>Your Account Settings</span>
          </a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        
        <li>
          <hr class="dropdown-divider">
        </li>

        <li>
          <a class="dropdown-item d-flex align-items-center justify-content-start" href="/<?php echo e($appName); ?>/auth/sign-out/">
            <i class="bi bi-box-arrow-right"></i>
            <span>Sign Out</span>
          </a>
        </li>

      </ul><!-- End Profile Dropdown Items -->
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header><!-- End Header -->