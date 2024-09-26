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
  
      <div class="card pt-4">
        <div class="card-body">
          <!-- Table with stripped rows -->
          <table class="table datatable table-bordered">
            <thead>
              <tr>
                <th>Organisation</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Prevellage</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $user)
              <tr>
                <td>
                  <?php $imageUrl = isset($user['organization_logo']) ? $user['organization_logo'] : "/{$appName}/assets/img/placeholder.png"; ?>
                  <div style="display: flex; align-items: center;">
                    <img src="<?php echo $imageUrl; ?>" alt="Profile" class="rounded-circle" width="25px" height="25px" style="margin-right: 8px;">
                    <span>{{$user['organization_name']}}</span>
                  </div>
                </td>

                <td>{{$user['name'] ?? 'N/A'}}</td>
                <td>{{$user['email']}}</td>
                <td>{{$user['role']}}</td>
                <td>{{$user['country']}}, {{$user['district'] ?? 'N/A'}}</td>

                <td>
                  <div class="dropdown">
                    <button class="btn btn-outline btn-sm dropdown-toggle" type="button" id="actionDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Select Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="actionDropdown">
                      @if($role == 'Administrator')
                      @if($myOrganisation['id'] == $user['organization_id'] || $myOrganisation['name'] == 'Administrator')
                      <a class="dropdown-item" href="{{ route('user.details', ['id' => $user['_id']], true) }}">
                        <i class="bi bi-eye"></i> View User Details
                      </a>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#updateRoleModal" data-user-id="{{ $user['user_id'] }}" data-user-role="{{ $user['role'] }}">
                        <i class="bi bi-pencil-square"></i> Update User Role
                      </a>
                      <a class="dropdown-item text-danger" href="#">
                        <i class="bi bi-slash-circle"></i> Block User
                      </a>
                      <a class="dropdown-item text-danger" href="#">
                        <i class="bi bi-trash"></i> Delete User
                      </a>
                      @endif
                      @endif

                      @if($role == 'User')
                      <a class="dropdown-item" href="{{ route('user.details', ['id' => $user['_id']], true) }}">
                        <i class="bi bi-eye"></i> View User Details
                      </a>
                      @endif

                      @if($role == 'Viewer')
                      <a class="dropdown-item" href="{{ route('user.details', ['id' => $user['_id']], true) }}">
                        <i class="bi bi-eye"></i> View User Details
                      </a>
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

  <!-- Update Role Modal -->
  <div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateRoleModalLabel">Update User Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateRoleForm" action="/{{$appName}}/dashboard/users/update-role" method="POST">

          <div class="modal-body">
            <input type="hidden" name="user_id" id="modalUserId">
            <div class="mb-3">
              <label for="userRole" class="form-label">Role</label>
              <select class="form-select" id="userRole" name="role" required>
                <option value="Administrator">Administrator</option>
                <option value="User">User</option>
                <option value="Viewer">Viewer</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Update Role</button>
          </div>
        </form>
      </div>
    </div>
  </div>


</main><!-- End #main -->

@include('partials/footer')

<script>
  $(document).ready(function() {
    var updateRoleModal = $('#updateRoleModal');

    updateRoleModal.on('show.bs.modal', function(event) {
      var button = $(event.relatedTarget);
      var userId = button.data('user-id');
      var userRole = button.data('user-role');

      var modalUserId = $('#modalUserId');
      var modalUserRole = $('#userRole');

      modalUserId.val(userId);
      modalUserRole.val(userRole);
    });

    $('#updateRoleForm').on('submit', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();

      $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,

        success: function(response) {

          Toastify({
            text: response.message,
            duration: 3000,
            gravity: 'bottom',
            position: 'left',
            backgroundColor: 'green',
          }).showToast();

          setTimeout(function() {
            window.location.reload()
          }, 3000)

        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
        }
      });
    });
  });
</script>