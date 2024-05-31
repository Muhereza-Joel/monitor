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
        h3,
        h4,
        h5 {
            margin: 5px 0;
        }

        .document-header {
            text-decoration: underline;
            font-size: 20px;
            color: #075E54;
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
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td class="contact-info" style="width: 50%; vertical-align: top;">
                    <img src="/<?php echo e($appName); ?>/assets/img/logo2.png" width="200px" alt="logo" class="logo">
                    <h1>Defence Forces Shop Uganda ltd</h1>
                    <h3><?php echo e($appNameFull); ?></h3>
                    <span>Defence Forces Shop Uganda ltd, Headquarters</span><br>
                    <span>P.O Box 123, Bombo-Luwero</span><br>
                    <span>Tel: +256 753172862</span><br>
                    <span>Email: customerservice@dfshop.com</span>

                </td>

                <td class="ticket-details" style="width: 50%; vertical-align: top;">
                    <h4 class="document-header">Receipt</h4>
                    <br>
                    <h2>Order Details</h2>
                    <h5>Order Placed On: <?php echo e($reciept['created_at']); ?></h5>
                    <p><strong>Customer Name:</strong> <?php echo e($reciept['name']); ?></p>
                    <p><strong>Customer Contact:</strong> <?php echo e($reciept['phone']); ?></p>
                    <p><strong>Product:</strong> <?php echo e($reciept['title']); ?></p>
                    <p><strong>Quantity Ordered:</strong> <?php echo e($reciept['order_quantity']); ?></p>
                    <p><strong>Total Amount Paid:</strong> Ugx <?php echo e($reciept['total_amount_due']); ?></p>

                    <h4>Important Notes:</h4>
                    <ul>
                        <li>Please remember to carry this receipt when you come to pick your items.</li>
                        <li>Goads Ounce Sold are Not Returnable.</li>
                    </ul>

                </td>

            </tr>
        </table>
    </div>
</body>

</html>