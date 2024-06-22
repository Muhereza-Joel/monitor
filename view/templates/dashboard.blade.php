@include('partials/header')
@include('partials/topBar')
@include('partials/leftPane')

<main id="main" class="main">
  <section class="section dashboard">
    <div class="alert alert-warning mt-2">
      <h3 class="fw-bold">{{$appNameFull}}</h3>
      <h5>Welcome back, {{$username}}</h5>
      <hr>
      <h6 class="badge bg-primary">
        You are on the
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

    <div class="row g-4">
      <div class="col-sm-3">
        <div class="card p-3">
          <h2>My Organisation</h2>
          <div class="card p-2 flex-fill organisation-card" data-org-id="{{$myOrganisation['id']}}">
            <div class="card-title">{{$myOrganisation['name']}}</div>
            <div class="card-body text-center">
              <?php $imageUrl = isset($myOrganisation['logo']) ? $myOrganisation['logo'] : "/{$appName}/assets/img/placeholder.png"; ?>
              <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle" width="150px">
            </div>
          </div>

        </div>
      </div>
      
      <div class="col-sm-9">
      <div class="card p-3">
        <h5>Other Organisations</h5>
        <div class="row g-1" style="display: flex; flex-wrap: wrap;">
          @foreach($organisations as $row)
            @if($row['id'] != $myOrganisation['id'])
              <div class="col-sm-3 d-flex">
                <div class="card p-2 flex-fill organisation-card" data-org-id="{{$row['id']}}">
                  <div class="card-title">{{$row['name']}}</div>
                  <div class="card-body text-center">
                    <?php $imageUrl = isset($row['logo']) ? $row['logo'] : "/{$appName}/assets/img/placeholder.png"; ?>
                    <img style="width: 100px; object-fit: contain; border: 3px solid #999" src="<?php echo $imageUrl; ?>" alt="logo" class="rounded-circle">
                  </div>
                </div>
              </div>
            @endif
          @endforeach
        </div>

      </div>
      </div>

      @if($role == 'Viewer')
        <div class="alert alert-info p-2">
          {{$username}}, your role only allows you to view data. If you need to modify or delete any information, please contact the Administrator to update your permissions.
        </div>
      @endif

      <div class="row g-1 mt-4">
        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">All <span>| Indicators in your organisation</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-graph-up"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$indicatorsCount}}</h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">All <span>| Responses in your organisation</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$responsesCount}}</h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Your <span>| Responses in your organisation</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-check-circle"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$userResponsesCount}}</h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">All <span>| Users in your organisation</span></h5>
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-person-circle"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$usersCount}}</h6>
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

@include('partials/footer')
