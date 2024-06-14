@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');


<main id="main" class="main">

  <section class="section dashboard">

    <div class="alert alert-warning">
      <h3 class="fw-bold">{{$appNameFull}}</h3>
      <h5>Welcome back, {{$username}}</h5>
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

    <div class="row">
      <div class="col-sm-4">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">All <span>| Indicators</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-graph-up"></i>
              </div>
              <div class="ps-3">
                <h6>145</h6>
                

              </div>
            </div>
          </div>

        </div>
      </div>


      <div class="col-sm-4">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">All <span>| Responses</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="ps-3">
                <h6>145</h6>
                

              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-sm-4">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">Your <span>| Responses</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="ps-3">
                <h6>145</h6>
                

              </div>
            </div>
          </div>

        </div>
      </div>


      <div class="col-sm-4">
        <div class="card info-card sales-card">
          <div class="card-body">
            <h5 class="card-title">All <span>| Users</span></h5>

            <div class="d-flex align-items-center">
              <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                <i class="bi bi-person-circle"></i>
              </div>
              <div class="ps-3">
                <h6>145</h6>
                

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>


  </section>

</main><!-- End #main -->

@include('partials/footer')