<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details - Dunya Car Rental</title>
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
            border-bottom: 1px solid #e5e5e5;
        }
        .logo {
            height: 50px;
        }
        .section {
            margin-bottom: 20px;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            overflow: hidden;
        }
        .section-title {
            background: #4a5568;
            color: #ffffff;
            padding: 10px 15px;
            font-size: 18px;
            font-weight: bold;
        }
        .section-content {
            padding: 15px;
        }
        .detail-row {
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #4a5568;
            display: inline-block;
            width: 150px;
        }
        .detail-value {
            color: #666666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #4a5568;
            color: #ffffff;
            text-align: left;
            padding: 8px 10px;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e5e5;
            color: #666666;
        }
        .total-row {
            font-weight: bold;
            color: #333333;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666666;
            font-size: 14px;
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

        <!-- Status Update -->
        <div class="section">
            <div class="section-title">Trip Status Update</div>
            <div class="section-content">
                <div class="detail-row">
                    <span class="detail-label">Order Number:</span>
                    <span class="detail-value"><?php echo $trip_data['t_trackingcode']??''; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Previous Status:</span>
                    <span class="detail-value"><?php echo ucfirst($old_status??''); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">New Status:</span>
                    <span class="detail-value"><?php echo ucfirst($new_status??''); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Updated On:</span>
                    <span class="detail-value"><?php echo date('d M Y H:i', strtotime($update_date??'')); ?></span>
                </div>
            </div>
        </div>

        <!-- Customer Details -->
        <div class="section">
            <div class="section-title">Customer Details</div>
            <div class="section-content">
                <div class="detail-row">
                    <span class="detail-label">Name:</span>
                    <span class="detail-value"><?php echo ($customer_data['c_name']??'') . ' ' . ($customer_data['last_name']??''); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value primary-color"><?php echo $customer_data['c_email']??''; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value primary-color"><?php echo $customer_data['c_mobile']??''; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date of Birth:</span>
                    <span class="detail-value"><?php echo date('d.m.Y', strtotime($customer_data['dob']??'')); ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value"><?php echo $customer_data['c_address']??''; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">City:</span>
                    <span class="detail-value"><?php echo $customer_data['city']??''; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Country:</span>
                    <span class="detail-value"><?php echo $customer_data['country']??''; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Flight Number:</span>
                    <span class="detail-value"><?php echo $customer_data['flight_number']??'' ?></span>
                </div>
            </div>
        </div>

        <!-- Rental Details -->
        <div class="section">
            <div class="section-title">Rental Details</div>
            <div class="section-content">
                <table>
                    <tr>
                        <th>Pick-up Location</th>
                        <th>Return Location</th>
                    </tr>
                    <tr>
                        <td><?php echo $trip_data['t_trip_fromlocation']??''; ?></td>
                        <td><?php echo $trip_data['t_trip_tolocation']??''; ?></td>
                    </tr>
                </table>
                
                <table style="margin-top: 15px;">
                    <tr>
                        <th>Pick-up Date & Time</th>
                        <th>Return Date & Time</th>
                        <th>Period</th>
                    </tr>
                    <tr>
                        <td><?php echo date('d.m.Y', strtotime($trip_data['t_start_date']??'')) . ' & ' . ($trip_data['fromtime']??'') . ' Hrs'; ?></td>
                        <td><?php echo date('d.m.Y', strtotime($trip_data['t_end_date']??'')) . ' & ' . ($trip_data['totime']??'') . ' Hrs'; ?></td>
                        <td><?php echo $trip_data['days']??''; ?> Days</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Selected Car -->
        <div class="section">
            <div class="section-title">Selected Car</div>
            <div class="section-content">
                <table>
                    <tr>
                        <th>Vehicle</th>
                        <th>Daily Rate</th>
                        <th>Total</th>
                    </tr>
                    <tr>
                        <td><?php echo $trip_data['t_vechicle']??''; ?></td>
                        <td><?php echo $trip_data['carprice']??''; ?></td>
                        <td><?php echo ($trip_data['carprice']??0) * ($trip_data['days']??0); ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Extras -->
        <?php if (!empty($trip_data['extras'])): ?>
        <div class="section">
            <div class="section-title">Extras</div>
            <div class="section-content">
                <table>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                    <?php 
                    $extras = json_decode($trip_data['extras'], true);
                    foreach ($extras as $extra): ?>
                    <tr>
                        <td><?php echo $extra['name']; ?></td>
                        <td><?php echo $extra['price']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="total-row">
                        <td>Extras Total</td>
                        <td><?php echo $trip_data['extras_total']??''; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- Insurance and Other Fees -->
        <div class="section">
            <div class="section-title">Insurance and other Fees</div>
            <div class="section-content">
                <table>
                    <tr>
                        <th>Item</th>
                        <th>Price</th>
                    </tr>
                    <tr>
                        <td><?php echo $trip_data['insurance_name']??''; ?></td>
                        <td><?php echo $trip_data['insurance_price']??''; ?></td>
                    </tr>
                    <?php if (!empty($trip_data['pai'])): ?>
                    <tr>
                        <td>PAI</td>
                        <td><?php echo $trip_data['pai']; ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Total -->
        <div class="section">
            <div class="section-title">Total</div>
            <div class="section-content">
                <table>
                    <tr class="total-row">
                        <td>Grand Total:</td>
                        <td style="text-align: right;">$ <?php echo $trip_data['t_trip_amount']??''; ?></td>
                    </tr>
                    <tr>
                        <td>Paid Amount:</td>
                        <td style="text-align: right; color: green; font-weight: bold;">$ <?php echo isset($trip_data['paid_amount']) ? number_format($trip_data['paid_amount'], 2) : '0.00'; ?></td>
                    </tr>
                    <tr>
                        <td>Pending Amount:</td>
                        <td style="text-align: right; color: orange; font-weight: bold;">$ <?php echo isset($trip_data['pending_amount']) ? number_format($trip_data['pending_amount'], 2) : (isset($trip_data['t_trip_amount']) ? number_format($trip_data['t_trip_amount'], 2) : '0.00'); ?></td>
                    </tr>
                    <tr>
                        <td>Payment Status:</td>
                        <td style="text-align: right;"><?php echo $trip_data['payment_status']??''; ?></td>
                    </tr>
                    <tr>
                        <td>Payment Method:</td>
                        <td style="text-align: right; text-transform: capitalize;">
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
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="font-weight: bold;">Regards,</p>
            <p style="font-weight: bold;">Dunya Car Rental</p>
            <p>Address: Exit 10W, Airport Rd., Amman, Jordan</p>
            <p>+962799280000</p>
            <p class="primary-color">bookings@dunyacars.com</p>
        </div>
    </div>
</body>
</html>
