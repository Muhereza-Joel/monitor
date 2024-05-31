@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');


<main id="main" class="main">

  <div class="pagetitle">
    <h1>All Responses</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Responses</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">

   <div class="row p-2">
    <div class="card">
        <div class="card-title">All Responses</div>
        <div class="card-body">
            <table class="table table-striped datatable">
                <thead>
                    <tr>
                        <th>SNo.</th>
                        <th>Respondent</th>
                        <th>Indicator</th>
                        <th>Lessons</th>
                        <th>Baseline</th>
                        <th>Current</th>
                        <th>Progress</th>
                        <th>Target</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($responses as $response)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$response['name']}}</td>
                            <td>{{$response['indicator_title']}}</td>
                            <td><p class="text-success">{{$response['lessons']}}</p></td>
                            <td>{{$response['baseline']}}</td>
                            <td>{{$response['current']}}</td>
                            <td>{{$response['progress']}}</td>
                            <td>{{$response['target']}}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   </div>

   
  </section>

</main><!-- End #main -->

@include('partials/footer')