@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

    <div class="alert alert-warning">
      <h3 class="fw-bold">{{$appNameFull}}</h3>
      <hr>
      <h6 class="badge bg-primary">You are on the
        @if($role == 'Administrator')
        Administrator
        @elseif($role == 'Viewer')
        Viewer
        @else
        User
        @endif
        dashboard
      </h6>
    </div>

   
  </section>

</main><!-- End #main -->

@include('partials/footer')