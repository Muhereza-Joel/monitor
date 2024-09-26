<!DOCTYPE html>
<html lang="<?php echo e(get_locale()); ?>">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo e($pageTitle); ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo e(asset('img/logo_yellow.png')); ?>" rel="icon">
  <link href="<?php echo e(asset('img/logo_yellow.png')); ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
  <!-- Vendor CSS Files -->
  <link href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/bootstrap-icons/bootstrap-icons.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/boxicons/css/boxicons.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/quill/quill.snow.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/quill/quill.bubble.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/remixicon/remixicon.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/simple-datatables/style.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('vendor/jquery-ui/jquery-ui.min.css')); ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css" integrity="sha512-UiKdzM5DL+I+2YFxK+7TDedVyVm7HMp/bN85NeWMJNYortoll+Nd6PU9ZDrZiaOsdarOyk9egQm6LOJZi36L2g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Template Main CSS File -->
  <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet">

  <style>
    #loading-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.1);
      z-index: 9999;
    }

    #loading-indicator {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 50px;
      height: 50px;
      border: 8px dotted green;
      border-radius: 50%;
      border-top: 8px solid #e74c3c;
      animation: spin 1s linear infinite;
    }

    @keyframes  spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    body {
      -webkit-user-select: none;
      /* Safari */
      -moz-user-select: none;
      /* Firefox */
      -ms-user-select: none;
      /* Internet Explorer/Edge */
      user-select: none;
      /* Non-prefixed version, currently supported by Chrome, Opera, and Firefox */
    }

    .btn {
      border-radius: 0px !important;
    }

    .highlight {
      background-color: yellow;
      /* or any color you prefer */
      font-weight: bold;
      /* optional for emphasis */
    }
  </style>

<style>
  .search-form {
    width: 180% !important;
    /* Ensure the form takes full width */
  }

  .search-form .search-input {
    width: 9000px;
    /* Set a fixed width for the input field */
    padding: 9px 20px !important;
    /* Increase padding for comfort */
    border-radius: 5px !important;
    /* Optional: rounded corners */
    border: 1px solid #ccc;
    /* Optional: border color */
  }

  .search-form .form-control {
    border-radius: 5px;
    /* Optional: rounded corners for select */
  }

  .search-form .form-control.me-2 {
    width: 150px;
    /* Set a fixed width for the select dropdown */
  }

  .search-form .btn {
    padding: 10px 15px;
    /* Increase button size */
    border-radius: 5px;
    /* Optional: rounded corners for button */
  }

  
</style>

</head>