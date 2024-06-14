@include('partials/header')

@include('partials/topBar');

@include('partials/leftPane');

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Users</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{$appName}}/dashboard/">Home</a></li>
        <li class="breadcrumb-item active">Users</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row p-2">
      <div class="alert alert-info">Only people who have completed their profiles after creating accounts are the ones shown here.</div>
      <div class="card pt-4">
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-bordered">
            <thead>
              <tr>
                <th>
                  Username
                </th>
                <th>Full Name</th>
                <th>Role</th>
                <th>Email</th>
                <th>Home Country</th>
                <th>District</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                <td>{{$user['username']}}</td>
                <td>{{$user['name']}}</td>
                <td>{{$user['role']}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['country']}}</td>
                <td>{{$user['district']}}</td>

                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      @if($role == 'Administrator')

                      <a class="dropdown-item" href="/{{$appName}}/dashboard/users/view?id={{$user['id']}}">View User Details</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item text-danger" href="#">Block User</a> <!-- Replace "1" with the actual book ID -->
                      <a class="dropdown-item text-danger" href="#">Delete User</a> <!-- Replace "1" with the actual book ID -->
                      @endif
                      
                      @if($role == 'Viewer')
                      <a class="dropdown-item" href="/{{$appName}}/dashboard/users/view?id={{$user['id']}}">View User Details</a> <!-- Replace "1" with the actual book ID -->
                      @endif
                    </div>
                  </div>
                </td>
              </tr>

              @endforeach


            </tbody>
          </table>
          <!-- End Table with stripped rows -->

        </div>
      </div>

    </div>
  </section>

</main><!-- End #main -->

@include('partials/footer')