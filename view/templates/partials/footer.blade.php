

<!-- Vendor JS Files -->
<script src="/{{$appName}}/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="/{{$appName}}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/{{$appName}}/assets/vendor/chart.js/chart.umd.js"></script>
<script src="/{{$appName}}/assets/vendor/echarts/echarts.min.js"></script>
<script src="/{{$appName}}/assets/vendor/quill/quill.min.js"></script>
<script src="/{{$appName}}/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="/{{$appName}}/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="/{{$appName}}/assets/vendor/php-email-form/validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.js" integrity="sha512-79j1YQOJuI8mLseq9icSQKT6bLlLtWknKwj1OpJZMdPt2pFBry3vQTt+NZuJw7NSd1pHhZlu0s12Ngqfa371EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Template Main JS File -->
<script src="/{{$appName}}/assets/js/jquery.min.js"></script>
<script src="/{{$appName}}/assets/js/moments.js"></script>
<script src="/{{$appName}}/assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="/{{$appName}}/assets/js/main.js"></script>

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