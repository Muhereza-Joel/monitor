<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <i class="bi bi-list toggle-sidebar-btn"></i>
    <a href="/{{$appName}}/dashboard/" class="logo d-flex align-items-center">
      <span class="d-none d-lg-block">M & E Monitor</span>
    </a>
  </div><!-- End Logo -->

  <div class="d-flex ps-3 ms-3">
    <?php $imageUrl = isset($myOrganisation['logo']) ? $myOrganisation['logo'] : "/{$appName}/assets/img/placeholder.png"; ?>
    <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle mt-3" width="40px" height="40px">
    <h3 class="h5 text-light mt-3"> {{$myOrganisation['name']}} <br>
      <small>is your organisation</small>
    </h3>
  </div>

</header><!-- End Header -->