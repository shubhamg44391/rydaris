<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Dunya Car Rental</title>
    <style>
        /* Inline CSS for email compatibility */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
        }
        .header {
            background: #fff;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }
        .logo {
            height: 80px;
            width: auto;
        }
        .section {
            background: #fff;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .section-header {
            background: #4a5568;
            color: white;
            padding: 12px 20px;
            font-weight: bold;
        }
        .section-body {
            padding: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        @media (min-width: 480px) {
            .grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            min-width: 150px;
            color: #4a5568;
        }
        .detail-value {
            color: #2d3748;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #4a5568;
            color: white;
            text-align: left;
            padding: 10px 15px;
        }
        td {
            padding: 10px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-primary {
            color: #ef4444;
        }
        .font-bold {
            font-weight: bold;
        }
        .border-t {
            border-top: 1px solid #e2e8f0;
        }
        .pt-2 {
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="<?php echo url('assets/frontend/images/logo.png'); ?>" alt="Dunya Car Rental" class="logo">
        </div>

        <!-- Customer Details -->
        <div class="section">
            <div class="section-header">
                <h2>Customer Details</h2>
            </div>
            <div class="section-body">
                <div class="grid">
                    <div>
                        <div class="detail-row">
                            <span class="detail-label">Reservation Code:</span>
                            <span class="detail-value"><?php echo $trip_data['t_trackingcode']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Customer:</span>
                            <span class="detail-value"><?php echo $customer_data['c_name'] . ' ' . $customer_data['last_name']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Date of Birth:</span>
                            <span class="detail-value"><?php echo date('d.m.Y', strtotime($customer_data['dob'])); ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Flight Ticket Number:</span>
                            <span class="detail-value"><?php echo $customer_data['flight_number'] ?: 'N/A'; ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="detail-row">
                            <span class="detail-label">City:</span>
                            <span class="detail-value"><?php echo $customer_data['city']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Country:</span>
                            <span class="detail-value"><?php echo $customer_data['country']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Phone:</span>
                            <span class="detail-value text-primary"><?php echo $customer_data['c_mobile']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">E-mail:</span>
                            <span class="detail-value text-primary"><?php echo $customer_data['c_email']; ?></span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Additional Comments:</span>
                            <span class="detail-value"><?php echo $customer_data['additional_comments'] ?: 'N/A'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Details -->
        <div class="section">
            <div class="section-header">
                <h2>Rental Details</h2>
            </div>
            <div class="section-body">
                <table>
                    <thead>
                        <tr>
                            <th>Pick-up Location</th>
                            <th>Return Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $trip_data['t_trip_fromlocation']; ?></td>
                            <td><?php echo $trip_data['t_trip_tolocation']; ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <table>
                    <thead>
                        <tr>
                            <th>Pick-up Date & Time</th>
                            <th>Return Date & Time</th>
                            <th>Period</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo date('d.m.Y', strtotime($trip_data['t_start_date'])) . ' & ' . $trip_data['fromtime'] . ' Hrs'; ?> </td>
                            <td><?php echo date('d.m.Y', strtotime($trip_data['t_end_date'])) . ' & ' . $trip_data['totime'] . ' Hrs'; ?></td>
                            <td><?php echo $trip_data['days'] . ' Days'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Selected Cars -->
        <div class="section">
            <div class="section-header" style="background-color: #718096;">
                <h2>Selected Cars</h2>
            </div>
            <div class="section-body">
                <table>
                    <thead style="background-color: #a0aec0;">
                        <tr>
                            <th>Vehicle</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $trip_data['t_vechicle']; ?></td>
                            <td><?php echo number_format($trip_data['per_day_price'], 2) . ' X ' . $trip_data['days']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Insurance and Other Fees -->
        <div class="section">
            <div class="section-header" style="background-color: #718096;">
                <h2>Insurance and other Fees</h2>
            </div>
            <div class="section-body">
                <div class="grid">
                    <div>
                        <div class="detail-row" style="justify-content: space-between;">
                            <span>Insurance</span>
                            <span><?php echo $trip_data['insurance_price'] ? '$' . $trip_data['insurance_price'] : '-'; ?></span>
                            <span><?php echo $trip_data['insurance_price'] ? '$' . ($trip_data['insurance_price']) : '0'; ?></span>
                        </div>
                        <div class="detail-row" style="justify-content: space-between;">
                            <span>Extras</span>
                            <span><?php echo $trip_data['extras_total'] ? '$' . $trip_data['extras_total'] : '0'; ?></span>
                            <span><?php echo $trip_data['extras_total'] ? '$' . $trip_data['extras_total'] : '0'; ?></span>
                        </div>
                    </div>
                    <div>
                        <div class="detail-row" style="justify-content: space-between;">
                            <span>Pickup Location fees</span>
                            <span><?php echo $trip_data['pickup_location_fees'] ? '$' . $trip_data['pickup_location_fees'] : '-'; ?></span>
                            <span><?php echo $trip_data['pickup_location_fees'] ? '$' . $trip_data['pickup_location_fees'] : '-'; ?></span>
                        </div>
                        <div class="detail-row" style="justify-content: space-between;">
                            <span>Return Location fees</span>
                            <span><?php echo $trip_data['dropup_location_fees'] ? '$' . $trip_data['dropup_location_fees'] : '-'; ?></span>
                            <span><?php echo $trip_data['dropup_location_fees'] ? '$' . $trip_data['dropup_location_fees'] : '-'; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total -->
        <div class="section">
            <div class="section-header">
                <h2>Total</h2>
            </div>
            <div class="section-body">
                <div style="text-align: right;">
                    <div class="detail-row" style="justify-content: space-between; font-size: 1.1em;">
                        <span class="font-bold">Total Amount:</span>
                        <span class="font-bold">$ <?php echo number_format($trip_data['t_trip_amount'], 2); ?></span>
                    </div>
                    <div class="detail-row" style="justify-content: space-between;">
                        <span>Paid Amount:</span>
                        <span style="color: green; font-weight: bold;">$ <?php echo isset($trip_data['paid_amount']) ? number_format($trip_data['paid_amount'], 2) : '0.00'; ?></span>
                    </div>
                    <div class="detail-row" style="justify-content: space-between;">
                        <span>Pending Amount:</span>
                        <span style="color: orange; font-weight: bold;">$ <?php echo isset($trip_data['pending_amount']) ? number_format($trip_data['pending_amount'], 2) : (isset($trip_data['t_trip_amount']) ? number_format($trip_data['t_trip_amount'], 2) : '0.00'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Details -->
        <div class="section">
            <div class="section-header">
                <h2>Payment Details</h2>
            </div>
            <div class="section-body">
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value" style="text-transform: capitalize;">
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

        <!-- Contact Information -->
        <div class="section"> 
            <div class="section-body text-center">
                <p class="font-bold">Regards,</p>
                <p class="font-bold">Dunya Car Rental</p>
                <p>Address: Exit 10W, Airport Rd., Amman, Jordan</p>
                <p>+962799280000</p>
                <p class="text-primary">bookings@dunyacars.com</p>
            </div>
        </div>
    </div>
</body>
</html>
