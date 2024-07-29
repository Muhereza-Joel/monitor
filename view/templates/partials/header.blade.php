<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{$pageTitle}}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{$baseUrl}}/assets/img/logo_yellow.png" rel="icon">
  <link href="{{$baseUrl}}/assets/img/logo_yellow.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
  <!-- Vendor CSS Files -->
  <link href="{{$baseUrl}}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <link href="{{$baseUrl}}/assets/vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.min.css" integrity="sha512-UiKdzM5DL+I+2YFxK+7TDedVyVm7HMp/bN85NeWMJNYortoll+Nd6PU9ZDrZiaOsdarOyk9egQm6LOJZi36L2g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Template Main CSS File -->
  <link href="{{$baseUrl}}/assets/css/style.css" rel="stylesheet">

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

    @keyframes spin {
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
  </style>

</head>