<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancellation Confirmation - Dunya Car Rental</title>
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
        .title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 20px;
        }
        .message {
            margin-bottom: 20px;
            color: #666666;
        }
        .booking-details {
            border-top: 1px solid #e5e5e5;
            padding-top: 20px;
            margin-top: 20px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 15px;
        }
        .detail-box {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #4a5568;
        }
        .grid-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        @media (min-width: 600px) {
            .grid-container {
                grid-template-columns: 1fr 1fr;
            }
        }
        .footer {
            text-align: center;
            padding: 15px;
            color: #666666;
            font-size: 12px;
        }
        .company-info {
            text-align: center;
            margin-top: 20px;
        }
        .company-info h2 {
            font-size: 20px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 15px;
        }
        .contact-info {
            margin-bottom: 10px;
        }
        .primary-color {
            color: #ef4444;
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
            <!-- Title -->
            <div class="title">Cancellation Confirmation</div>

            <!-- Message -->
            <div class="message">
                <p>Dear <?php echo $customer_data['c_name']; ?>,</p>
                <p>Your reservation #<?php echo $trip_data['t_trackingcode']; ?> has been successfully cancelled.</p>
                <p>We are sorry to hear that you want to cancel your reservation, but hope to see you in the future.</p>
                
                <?php if ($trip_data['payment_status'] == 'Completed'): ?>
                <p>
                    A refund has been issued for your payment of $<?php echo $trip_data['t_trip_amount']; ?>.
                    <?php if (strtotime($trip_data['t_start_date']) - time() < 86400): ?>
                        <span class="primary-color">Please note that as the cancellation was made within 24 hours of the scheduled pick-up time, a partial refund may apply according to our cancellation policy.</span>
                    <?php endif; ?>
                </p>
                <p>The refund may take up to 15 business days to appear on your statement. If you need any assistance, please don't hesitate to contact us.</p>
                <?php endif; ?>
            </div>

            <!-- Booking Details -->
            <div class="booking-details">
                <div class="section-title">Details of your cancelled booking</div>
                
                <div class="detail-box">
                    <div class="detail-row">
                        <span class="detail-label">Booking ID:</span>
                        <span>#<?php echo $trip_data['t_trackingcode']; ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Customer:</span>
                        <span><?php echo $customer_data['c_name'] . ' ' . $customer_data['last_name']; ?></span>
                    </div>
                </div>

                <div class="grid-container">
                    <!-- Pickup -->
                    <div class="detail-box">
                        <div class="detail-row">
                            <span class="detail-label">Pick-Up:</span>
                        </div>
                        <div class="detail-row">
                            <span><?php echo date('d M Y', strtotime($trip_data['t_start_date'])) . ' at ' . $trip_data['fromtime'] . ' Hrs'; ?></span>
                        </div>
                        <div class="detail-row">
                            <span><?php echo $trip_data['t_trip_fromlocation']; ?></span>
                        </div>
                    </div>

                    <!-- Return -->
                    <div class="detail-box">
                        <div class="detail-row">
                            <span class="detail-label">Return:</span>
                        </div>
                        <div class="detail-row">
                            <span><?php echo date('d M Y', strtotime($trip_data['t_end_date'])) . ' at ' . $trip_data['totime'] . ' Hrs'; ?></span>
                        </div>
                        <div class="detail-row">
                            <span><?php echo $trip_data['t_trip_tolocation']; ?></span>
                        </div>
                    </div>
                </div>

                <div class="grid-container">
                    <!-- Vehicle -->
                    <div class="detail-box">
                        <div class="detail-row">
                            <span class="detail-label">Vehicle:</span>
                            <span><?php echo $trip_data['t_vechicle']; ?></span>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div class="detail-box">
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
                </div>
            </div>

            <!-- Company Information -->
            <div class="company-info">
                <h2>Dunya Car Rental Jordan</h2>
                <div class="contact-info">
                    <p>E-mail: bookings@dunyacars.com</p>
                    <p>Phone: +962799280000</p>
                    <p>Exit 10W, Airport Rd., Amman, Jordan</p>
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
