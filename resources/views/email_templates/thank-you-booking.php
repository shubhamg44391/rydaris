<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Dunya Car Rental</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
        }
        .header {
            background: #ffffff;
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #e5e5e5;
        }
        .logo {
            height: 50px;
        }
        .content {
            padding: 20px;
        }
        .thank-you {
            text-align: center;
            margin-bottom: 20px;
        }
        .thank-you h1 {
            color: #ef4444;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .confirmation-box {
            background: #ef4444;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .company-info {
            background: #ffffff;
            padding: 20px;
            text-align: center;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
        }
        .company-info h2 {
            color: #333333;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .contact-info {
            margin-bottom: 15px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            padding: 15px;
            color: #666666;
            font-size: 12px;
        }
        .booking-details {
            margin: 20px 0;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 4px;
        }
        .booking-details h3 {
            margin-top: 0;
            color: #333333;
        }
        .detail-row {
            margin-bottom: 8px;
        }
        .detail-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="<?php echo url('assets/frontend/images/logo.png'); ?>" alt="Dunya Car Rental" class="logo">           
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Thank You Message -->
            <div class="thank-you">
                <h1>Thank you so much for choosing<br>Dunya Car Rental service!</h1>
            </div>

            <!-- Confirmation Box -->
            <div class="confirmation-box">
                <p>Dear <?php echo $customer_data['c_name']; ?>,</p>
                <p>We have successfully received your payment for booking #<?php echo $trip_data['t_trackingcode']; ?>. Your payment of $<?php echo $trip_data['t_trip_amount']; ?> has been processed successfully.</p>
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <h3>Booking Summary</h3>
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span><?php echo $trip_data['t_trackingcode']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Vehicle:</span>
                    <span><?php echo $trip_data['t_vechicle']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pick-Up:</span>
                    <span><?php echo date('d M Y', strtotime($trip_data['t_start_date'])) . ' at ' . $trip_data['t_trip_fromlocation']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Return:</span>
                    <span><?php echo date('d M Y', strtotime($trip_data['t_end_date'])) . ' at ' . $trip_data['t_trip_tolocation']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span>$<?php echo $trip_data['t_trip_amount']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Paid Amount:</span>
                    <span style="color: green; font-weight: bold;">$<?php echo isset($trip_data['paid_amount']) ? number_format($trip_data['paid_amount'], 2) : '0.00'; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pending Amount:</span>
                    <span style="color: orange; font-weight: bold;">$<?php echo isset($trip_data['pending_amount']) ? number_format($trip_data['pending_amount'], 2) : (isset($trip_data['t_trip_amount']) ? number_format($trip_data['t_trip_amount'], 2) : '0.00'); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span style="text-transform: capitalize;">
                        <?php 
                        if (isset($trip_data['payment_method'])) {
                            if ($trip_data['payment_method'] == 'arrival' || $trip_data['payment_method'] == 'pay_on_arrival') {
                                echo 'Pay On Arrival';
                            } else {
                                echo str_replace('_', ' ', $trip_data['payment_method']);
                            }
                        } else {
                            echo 'Pay On Arrival';
                        }
                        ?>
                    </span>
                </div>
            </div>

            <!-- Company Information -->
            <div class="company-info">
                <h2>Dunya Car Rental Jordan</h2>
                <div class="contact-info">
                    <p><strong>E-mail:</strong> bookings@dunyacars.com</p>
                    <p><strong>Phone:</strong> +962799280000</p>
                    <p><strong>Address:</strong> Exit 10W, Airport Rd., Amman, Jordan</p>
                </div>
                <p>If you have any inquiries, please feel free to contact our service team.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> Dunya Car Rental. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
