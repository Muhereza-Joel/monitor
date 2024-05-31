<?php echo $__env->make('partials/header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->make('partials/topBar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<?php echo $__env->make('partials/leftPane', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;

<main id="main" class="main">
    <div class="content-area">

        <section class="section m-4">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="d-flex  align-items-center  px-3">
                            <div class="pagetitle p-2 order-0 w-50">


                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="/<?php echo e($appName); ?>/dashboard/">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Thankyou</li>
                                    </ol>
                                </nav>
                            </div>

                            <div class="buttons-container w-50">

                            </div>
                        </div>
                        <hr class="mx-4">


                        <?php
                        // require_once('top.php');
                        require_once('../TicketReservationSystem/vendor/pesapal/pesapal/OAuth.php');
                        require_once('../TicketReservationSystem/vendor/pesapal/db/dbconnector.php');
                        require_once('../TicketReservationSystem/vendor/pesapal/pesapal/checkStatus.php');

                        $database = new pesapalDatabase();

                        $pesapalMerchantReference    = null;
                        $pesapalTrackingId             = null;
                        $checkStatus                 = new pesapalCheckStatus();

                        if (isset($_GET['pesapal_merchant_reference']))
                            $pesapalMerchantReference = $_GET['pesapal_merchant_reference'];

                        if (isset($_GET['pesapal_transaction_tracking_id']))
                            $pesapalTrackingId = $_GET['pesapal_transaction_tracking_id'];


                        $status     = $checkStatus->checkStatusUsingTrackingIdandMerchantRef($pesapalMerchantReference, $pesapalTrackingId);
                        // $responseArray	= $checkStatus->getTransactionDetails($pesapalMerchantReference,$pesapalTrackingId);

                        $transactionDetails    = $checkStatus->getTransactionDetails($pesapalMerchantReference, $pesapalTrackingId);


                        //Update database
                        $value    = array("COMPLETED" => "Paid", "PENDING" => "Pending", "INVALID" => "Cancelled", "FAILED" => "Cancelled");
                        $status    = $value[$transactionDetails['status']];
                        $payement_method = $transactionDetails['payment_method'];

                        $dbUpdateSuccessful = $database->updateTransaction($transactionDetails);


                        // if($dbUpdateSuccessful) $dbupdated = "True"; else  $dbupdated = 'False';

                        //At this point, you can update your database.
                        //In my case i will let the IPN do this for me since it will run
                        //IPN runs when there is a status change  and since this is a new transaction, 
                        //the status has changed for UNKNOWN to PENDING/COMPLETED/FAILED
                        ?>

                        <div class="m-4">
                            <h3>Thankyou for paying your ticket, transaction is complete</h3>
                            <div class="alert alert-success">Go to the tickets section and print a copy of your ticket..
                                <br>
                                <strong>Come along with your ticket when you come to board the bus.</strong>
                            </div>
                            <h6>Here are the details of the your transaction</h6>

                        </div>
                        <div class="alert alert-light m-4 row-fluid">
                            <div class="span6">
                                <b>PAYMENT RECEIVED</b>
                                <blockquote>
                                    <b>Merchant reference: </b> <?php echo $pesapalMerchantReference; ?><br />
                                    <b>Pesapal Tracking ID: </b> <?php echo $pesapalTrackingId; ?><br />
                                    <b>Status: </b> <?php echo $status; ?><br />
                                    <b>Payment Method: </b> <?php echo $payement_method; ?><br />
                                </blockquote>
                            </div>

                        </div>
                    </div>
                </div>

        </section>

    </div>

    </div>
    </div>
    </div>
</main>
<?php echo $__env->make('partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>




</body>

</html>