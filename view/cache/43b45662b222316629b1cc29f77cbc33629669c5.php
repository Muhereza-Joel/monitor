<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<body>

    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-7">
                            <div class="d-flex flex-column justify-content-center py-4">
                                <a href="/<?php echo e($appName); ?>" class="logo d-flex align-items-center w-auto">
                                    <img src="/<?php echo e($appName); ?>/assets/img/torodev.png" style="width: 400px; object-fit:contain;" alt="logo">
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <div class="pt-4 pb-2">
                                                <h5 class="card-title text-center pb-0 fs-4">Please choose your organisation and click Proceed</h5>
                                                <div class="alert alert-info">We see that you need an account, but please note that self registered users only have permissions that allow them to view data.</div>
                                            </div>

                                            <div id="invalid-registration" class="alert alert-danger alert-dismissible fade d-none p-1" role="alert">
                                                <span class="text-center"></span>
                                            </div>
                                            <?php echo $__env->make('chooser', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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

    <?php echo $__env->make('partials/footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <script>
    $(document).ready(function() {
        $('.organisation-card').on('click', function() {
            $('.organisation-card').removeClass('selected');
            $(this).addClass('selected');

            let selectedOrgId = $(this).data('org-id');

            $.ajax({
                method: 'post',
                url: '/<?php echo e($appName); ?>/auth/set-organisation/',
                data: { organisation_id: selectedOrgId },
                success: function(response) {
                    $('#proceed-button').attr('href', '/<?php echo e($appName); ?>/auth/register/').removeClass('d-none');
                    
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


