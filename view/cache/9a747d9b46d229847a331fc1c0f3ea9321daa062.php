<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e($appNameFull); ?></title>
    <style>
        body {
            background-color: #fcfdfe;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            background-color: #075E54;
            color: #ffffff;
            page-break-inside: avoid;
            padding: 10px;
        }

        .logo {
            max-width: 80px;
            display: block;
            margin: 0 auto 10px auto;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            margin: 5px 0;
            color: #075E54;
        }

        .document-header {
            text-decoration: underline;
            font-size: 20px;
            color: #075E54;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            page-break-inside: avoid;
            /* Prevent table from breaking across pages */
        }

        tr th {
            background-color: #075E54;
            color: #ffffff;
            height: 30px;
            vertical-align: middle;
            padding-top: 5px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .contact-info {
            text-align: center;
        }


        @media  print {
            .container {
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="contact-info" style="width: 50%; vertical-align: top;">
            <img src="/<?php echo e($appName); ?>/assets/img/logo2.png" width="200px" alt="logo" class="logo">
            <h1>Defence Forces Shop Uganda Ltd</h1>
            
            <span>Defence Forces Shop Uganda Ltd, Headquarters</span><br>
            <span>P.O Box 123, Bombo-Luwero</span><br>
            <span>Tel: +256 753172862</span><br>
            <span>Email: customerservice@dfshop.com</span>

            <br><br><br><br><br>
            <h2>Inventory Report</h2>
            <span>Eported On <?php echo e($currentDate); ?></span>

        </div>
        <div class="card">
            <div class="card-body">

                <!-- Table with stripped rows -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="">SNo.</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Store</th>
                            <th scope="col">Product</th>
                            <th scope="col">Stock Price</th>
                            <th scope="col">Sale Price</th>
                            <th scope="col">Available</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $stock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($item['branch_name']); ?></td>
                            <td><?php echo e($item['zone_name']); ?></td>
                            <td><?php echo e($item['title']); ?></td>
                            <td>Ugx <?php echo e($item['buying_price']); ?></td>
                            <td>Ugx <?php echo e($item['selling_price']); ?></td>
                            <td><?php echo e($item['available_stock']); ?></td>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                    </tbody>
                </table>
                <!-- End Table with stripped rows -->

            </div>
        </div>

    </div>
</body>

</html>