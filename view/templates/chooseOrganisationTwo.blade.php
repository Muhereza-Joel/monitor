@include('partials/header')

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-7">
                            
                            <div class="card mb-3">
                                <div class="d-flex flex-column justify-content-center py-4">
                                    <a href="/{{$appName}}" class="logo d-flex align-items-center w-auto">
                                        <img src="/{{$appName}}/assets/img/logo_yellow.png" style="width: 400px; object-fit:contain;" alt="logo">
                                    </a>
                                </div><!-- End Logo -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <div class="pt-0 pb-2">
                                                <h5 class="card-title text-center pb-0 fs-4">Please choose your organisation and click Proceed</h5>

                                            </div>

                                            <div id="invalid-registration" class="alert alert-danger alert-dismissible fade d-none p-1" role="alert">
                                                <span class="text-center"></span>
                                            </div>
                                            <div class="alert alert-warning">
                                                <strong>You can only view data for organisations you belong to. To modify data, create indicators, or add responses, please select your own organisation.</strong>
                                            </div>
                                            @include('chooser')

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->

    @include('partials/footer')

    <script>
        $(document).ready(function() {
            $('.organisation-card').on('click', function() {
                $('.organisation-card').removeClass('selected');
                $(this).addClass('selected');

                let selectedOrgId = $(this).data('org-id');
                Toastify({
                    text: 'Switching organisation please wait...',
                    duration: 4000,
                    gravity: 'bottom',
                    position: 'left',
                    backgroundColor: '#',
                }).showToast();

                $.ajax({
                    method: 'post',
                    url: '/{{$appName}}/auth/set-organisation/',
                    data: {
                        organisation_id: selectedOrgId
                    },
                    success: function(response) {
                        $('#proceed-button').attr('href', '{{ url("dashboard/", null, true)}} ').removeClass('d-none');
                        Toastify({
                            text: 'Please click proceed button to continue...',
                            duration: 4000,
                            gravity: 'bottom',
                            position: 'left',
                            backgroundColor: '#28a745',
                        }).showToast();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Toastify({
                            text: jqXHR.responseJSON.message,
                            duration: 4000,
                            gravity: 'top',
                            position: 'center',
                            backgroundColor: 'red',
                        }).showToast();
                    }
                });
            });
        });
    </script>