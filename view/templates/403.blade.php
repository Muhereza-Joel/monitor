@include('partials/header')
  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>403</h1>
        <h2>You do not have permission to access this page.</h2>
        <a class="btn" href="/{{$appName}}/dashboard/">Go Back To Dashboard</a>
        <img src="/{{$appName}}/assets/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
        
      </section>

    </div>
  </main><!-- End #main -->

  @include('partials.footer')