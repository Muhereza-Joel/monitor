<div class="copyright text-center my-4">
  © Copyright <strong><span>M & E Monitor <?php echo date('Y'); ?></span></strong>. All Rights Reserved
</div>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center active"><i class="bi bi-arrow-up-short"></i></a>
<!-- Vendor JS Files -->
<script src="<?php echo e($baseUrl); ?>/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/echarts/echarts.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/quill/quill.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/php-email-form/validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.js" integrity="sha512-79j1YQOJuI8mLseq9icSQKT6bLlLtWknKwj1OpJZMdPt2pFBry3vQTt+NZuJw7NSd1pHhZlu0s12Ngqfa371EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Template Main JS File -->
<script src="<?php echo e($baseUrl); ?>/assets/js/jquery.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/js/moments.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?php echo e($baseUrl); ?>/assets/js/main.js"></script>

<script>
  function showLoadingOverlay() {
    $('#loading-overlay').fadeIn();
  }

  // Hide loading overlay
  function hideLoadingOverlay() {
    $('#loading-overlay').fadeOut();
  }
</script>

</body>

</html>