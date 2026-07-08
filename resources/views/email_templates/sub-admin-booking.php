<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Update - Dunya Car Rental</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            color: #4a5568;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ffffff;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
            text-align: center;
        }
        .logo {
            max-width: 150px;
        }
        .section {
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }
        .section-title {
            background-color: #d32f2f;
            color: white;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 18px;
            margin: 0 -20px 15px -20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        .info-label {
            font-weight: bold;
            min-width: 150px;
            width: 40%;
        }
        .info-value {
            flex: 1;
            min-width: 200px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        .table th {
            background-color: #b71c1c;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .table td {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #718096;
        }
        .text-primary {
            color: #d32f2f;
        }
        .text-bold {
            font-weight: bold;
        }
        .highlight {
            background-color: #FFFF00;
            padding: 2px 4px;
            border-radius: 3px;
            display: inline-block;
        }
        .change-marker {
            color: #FF0000;
            font-weight: bold;
            margin-left: 5px;
            font-size: 0.8em;
        }
        .booking-title {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0;
            color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo url('assets/frontend/images/logo.png'); ?>" alt="Dunya Car Rental" class="logo">           
        </div>
        
        <div class="booking-title">CAR RENTAL</div>
        <div class="section-title">BOOKING UPDATE RECEIVED</div>
        
        <div class="section-title">CUSTOMER DETAILS</div>
        <div class="section">
            <div class="info-row">
                <div class="info-label">Customer Name:</div>
                <div class="info-value <?php echo isset($changed_fields['c_name']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['c_name']; ?>
                    <?php if (isset($changed_fields['c_name'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Last Name:</div>
                <div class="info-value <?php echo isset($changed_fields['last_name']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['last_name']; ?>
                    <?php if (isset($changed_fields['last_name'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value <?php echo isset($changed_fields['c_email']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['c_email']; ?>
                    <?php if (isset($changed_fields['c_email'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Phone:</div>
                <div class="info-value <?php echo isset($changed_fields['c_mobile']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['c_mobile']; ?>
                    <?php if (isset($changed_fields['c_mobile'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Date of Birth:</div>
                <div class="info-value <?php echo isset($changed_fields['dob']) ? 'highlight' : ''; ?>">
                    <?php echo date('d.m.Y', strtotime($customer_data['dob'])); ?>
                    <?php if (isset($changed_fields['dob'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">License Number:</div>
                <div class="info-value <?php echo isset($changed_fields['license_number']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['license_number']; ?>
                    <?php if (isset($changed_fields['license_number'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Address:</div>
                <div class="info-value <?php echo isset($changed_fields['c_address']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['c_address']; ?>
                    <?php if (isset($changed_fields['c_address'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">City:</div>
                <div class="info-value <?php echo isset($changed_fields['city']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['city']; ?>
                    <?php if (isset($changed_fields['city'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Zipcode:</div>
                <div class="info-value <?php echo isset($changed_fields['zipcode']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['zipcode']; ?>
                    <?php if (isset($changed_fields['zipcode'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Country:</div>
                <div class="info-value <?php echo isset($changed_fields['country']) ? 'highlight' : ''; ?>">
                    <?php echo $customer_data['country']; ?>
                    <?php if (isset($changed_fields['country'])): ?>
                        <span class="change-marker">(Changed)</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="section-title">RENTAL DETAILS</div>
        <div class="section">
            <table class="table">
                <tr>
                    <th>Pick-up Location</th>
                    <th>Return Location</th>
                </tr>
                <tr>
                    <td <?php echo isset($changed_fields['t_trip_fromlocation']) ? 'class="highlight"' : ''; ?>>
                        <?php echo $trip_data['t_trip_fromlocation']; ?>
                        <?php if (isset($changed_fields['t_trip_fromlocation'])): ?>
                            <span class="change-marker">(Changed)</span>
                        <?php endif; ?>
                    </td>
                    <td <?php echo isset($changed_fields['t_trip_tolocation']) ? 'class="highlight"' : ''; ?>>
                        <?php echo $trip_data['t_trip_tolocation']; ?>
                        <?php if (isset($changed_fields['t_trip_tolocation'])): ?>
                            <span class="change-marker">(Changed)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <table class="table">
                <tr>
                    <th>Pick-up Date & Time</th>
                    <th>Return Date & Time</th>
                    <th>Period</th>
                </tr>
                <tr>
                    <td <?php echo (isset($changed_fields['t_start_date']) || isset($changed_fields['fromtime'])) ? 'class="highlight"' : ''; ?>>
                        <?php echo date('d.m.Y', strtotime($trip_data['t_start_date'])) . ' ' . $trip_data['fromtime'] . ' Hrs'; ?>
                        <?php if (isset($changed_fields['t_start_date']) || isset($changed_fields['fromtime'])): ?>
                            <span class="change-marker">(Changed)</span>
                        <?php endif; ?>
                    </td>
                    <td <?php echo (isset($changed_fields['t_end_date']) || isset($changed_fields['totime'])) ? 'class="highlight"' : ''; ?>>
                        <?php echo date('d.m.Y', strtotime($trip_data['t_end_date'])) . ' ' . $trip_data['totime'] . ' Hrs'; ?>
                        <?php if (isset($changed_fields['t_end_date']) || isset($changed_fields['totime'])): ?>
                            <span class="change-marker">(Changed)</span>
                        <?php endif; ?>
                    </td>
                    <td <?php echo isset($changed_fields['days']) ? 'class="highlight"' : ''; ?>>
                        <?php echo $trip_data['days'] . ' Days'; ?>
                        <?php if (isset($changed_fields['days'])): ?>
                            <span class="change-marker">(Changed)</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            
            <table class="table">   
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                        <tr>
                            <td>Vehicle Name</td>
                            <td class="<?php echo isset($changed_fields['v_nane']) ? 'highlight' : ''; ?>">
                                <?php echo $trip_data['v_nane']; ?>
                                <?php if (isset($changed_fields['v_nane'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Daily Rate</td>
                            <td class="<?php echo isset($changed_fields['v_amount']) ? 'highlight' : ''; ?>">
                                $<?php echo number_format($trip_data['v_amount'], 2); ?>
                                <?php if (isset($changed_fields['v_amount'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Extended Hours</td>
                            <td class="<?php echo isset($changed_fields['extended']) ? 'highlight' : ''; ?>">
                                $<?php echo number_format($trip_data['extended'] ?? 0, 2); ?>
                                <?php if (isset($changed_fields['extended'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <!-- Add all other trip data fields in the same format -->
                        <tr>
                            <td>Wifi</td>
                            <td class="<?php echo isset($changed_fields['wifi']) ? 'highlight' : ''; ?>">
                                $<?php echo number_format($trip_data['wifi'] ?? 0, 2); ?>
                                <?php if (isset($changed_fields['wifi'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Navigation</td>
                            <td class="<?php echo isset($changed_fields['navigation']) ? 'highlight' : ''; ?>">
                                $<?php echo number_format($trip_data['navigation'] ?? 0, 2); ?>
                                <?php if (isset($changed_fields['navigation'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <!-- Continue with all other fields -->
                        <tr>
                            <td>Total Amount</td>
                            <td class="<?php echo isset($changed_fields['t_trip_amount']) ? 'highlight' : ''; ?>">
                                $<?php echo number_format($trip_data['t_trip_amount'] ?? 0, 2); ?>
                                <?php if (isset($changed_fields['t_trip_amount'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Paid Amount</td>
                            <td class="<?php echo isset($changed_fields['paid_amount']) ? 'highlight' : ''; ?>">
                                <span style="color: green; font-weight: bold;">$<?php echo isset($trip_data['paid_amount']) ? number_format($trip_data['paid_amount'], 2) : '0.00'; ?></span>
                                <?php if (isset($changed_fields['paid_amount'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Pending Amount</td>
                            <td class="<?php echo isset($changed_fields['pending_amount']) ? 'highlight' : ''; ?>">
                                <span style="color: orange; font-weight: bold;">$<?php echo isset($trip_data['pending_amount']) ? number_format($trip_data['pending_amount'], 2) : (isset($trip_data['t_trip_amount']) ? number_format($trip_data['t_trip_amount'], 2) : '0.00'); ?></span>
                                <?php if (isset($changed_fields['pending_amount'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td class="<?php echo isset($changed_fields['payment_method']) ? 'highlight' : ''; ?>">
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
                                <?php if (isset($changed_fields['payment_method'])): ?>
                                    <span class="change-marker">(Changed)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
        
        <div class="footer">
            <p>Thank you for choosing Dunya Car Rental</p>
            <p>Address: Exit 10W, Airport Rd., Amman, Jordan</p>
            <p>Phone: +962799280000 | Email: bookings@dunyacars.com</p>
        </div>
    </div>
</body>
</html>
