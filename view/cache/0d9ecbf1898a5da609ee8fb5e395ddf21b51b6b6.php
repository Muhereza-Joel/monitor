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

        .contact-info,
        .ticket-details {
            padding: 10px;
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
                    <img src="/<?php echo e($appName); ?>/assets/img/logo2.png" alt="kapcco logo" class="logo">
                    <h1>Baby Coaches Uganda Limited</h1>
                    <h3><?php echo e($appNameFull); ?></h3>
                    <span>Fortportal Tourism City</span><br>
                    <span>Tel: +256 753172862</span><br>
                    <span>Email: customerservice@babycoaches.com</span>

                </td>
                <td class="ticket-details" style="width: 50%; vertical-align: top;">
                    <h4 class="document-header">Travel Ticket</h4>
                    <h5>Ticket reserved on: <?php echo e($ticket['created_at']); ?></h5>
                    <br>
                    <h4>Ticket Details</h4>
                    <p><strong>Traveler Name:</strong> <?php echo e($ticket['name']); ?></p>
                    <p><strong>Traveler Contact:</strong> <?php echo e($ticket['phone']); ?></p>
                    <p><strong>Route:</strong> <?php echo e($ticket['route']); ?></p>
                    <p><strong>Seat Number:</strong> <?php echo e($ticket['seat_number']); ?></p>
                    <p><strong>Departure Time:</strong> <?php echo e(\Carbon\Carbon::createFromFormat('H:i:s.u', $ticket['depature_time'])->format('h:i A')); ?></p>
                    <p><strong>Transport Amount Paid:</strong> Ugx <?php echo e($ticket['ticket_price']); ?></p>

                    <h4>Important Notes:</h4>
                    <ul>
                        <li>Please arrive at the departure point at least 30 minutes before the scheduled departure time.</li>
                        <li>Keep this ticket safe as it is required for boarding.</li>
                        <li>Luggage allowance is 20kg. Excess luggage may incur additional charges.</li>

                        <li>Refunds are not available for missed departures or cancellations.</li>
                    </ul>

                </td>
            </tr>
        </table>
    </div>
</body>

</html>