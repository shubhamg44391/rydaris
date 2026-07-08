<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Modified - Dunya Car Rental</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
            padding: 25px;
        }
        .confirmation-message {
            text-align: center;
            margin-bottom: 25px;
        }
        .confirmation-message h1 {
            color: #d9534f;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .booking-details {
            margin: 20px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        .booking-details h2 {
            margin-top: 0;
            color: #d9534f;
            font-size: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .detail-row {
            margin-bottom: 12px;
            display: flex;
        }
        .detail-label {
            font-weight: bold;
            width: 160px;
            color: #555;
        }
        .detail-value {
            color: #333;
            flex: 1;
        }
        .price-section {
            margin-top: 25px;
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #eee;
        }
        .price-section h3 {
            margin-top: 0;
            color: #d9534f;
            font-size: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }
        .price-row:last-child {
            border-bottom: none;
        }
        .price-label {
            color: #555;
        }
        .price-value {
            font-weight: bold;
            color: #333;
        }
        .coupon-banner {
            background: #f0f8ff;
            padding: 12px;
            border-left: 4px solid #5bc0de;
            margin: 15px 0;
            font-weight: bold;
            color: #31708f;
            border-radius: 3px;
        }
        .total-row {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #ddd;
        }
        .btn-primary {
            background: #d9534f;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 15px;
            color: #777;
            font-size: 12px;
            border-top: 1px solid #eee;
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
            <!-- Confirmation Message -->
            <div class="confirmation-message">
                <h1>Your <?php echo $type === 'personal' ? 'Personal Information' : 'Booking'; ?> Has Been Modified</h1>
                <p>Dear <?php echo $customer_data['c_name'] . ' ' . $customer_data['last_name']; ?>,</p>
                <p>We have successfully updated your <?php echo $type === 'personal' ? 'personal information' : 'booking <strong>#' . $trip_data['t_trackingcode'] . '</strong>'; ?> as per your request.</p>
            </div>

            <?php if($type === 'booking'): ?>
            <!-- Booking Details -->
            <div class="booking-details">
                <h2>Booking Summary</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value"><?php echo $trip_data['t_trackingcode']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Customer Name:</span>
                    <span class="detail-value"><?php echo $customer_data['c_name'] . ' ' . $customer_data['last_name']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Vehicle:</span>
                    <span class="detail-value"><?php echo $trip_data['t_vechicle']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pick-Up Location:</span>
                    <span class="detail-value"><?php echo $trip_data['t_trip_fromlocation']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Pick-Up Date & Time:</span>
                    <span class="detail-value"><?php echo date('d M Y', strtotime($trip_data['t_start_date'])) . ' at ' . $trip_data['fromtime'] . ' Hrs'; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Return Location:</span>
                    <span class="detail-value"><?php echo $trip_data['t_trip_tolocation']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Return Date & Time:</span>
                    <span class="detail-value"><?php echo date('d M Y', strtotime($trip_data['t_end_date'])) . ' at ' . $trip_data['totime'] . ' Hrs'; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Rental Period:</span>
                    <span class="detail-value"><?php echo $trip_data['days']; ?> Days</span>
                </div>
            </div>

            <!-- Price Breakdown -->
            <div class="price-section">
                <h3>Price Breakdown</h3>
                
                <?php if($trip_data['is_coupon']): ?>
                <div class="coupon-banner">
                    Coupon <?php echo $trip_data['coupon_code']; ?> - $<?php echo $trip_data['discount_amount']; ?> Off
                </div>
                <?php endif; ?>

                <div class="price-row">
                    <span class="price-label">Vehicle Rental (<?php echo $trip_data['per_day_price']; ?> × <?php echo $trip_data['days']; ?> Days)</span>
                    <span class="price-value">- $<?php echo number_format($trip_data['per_day_price'] * $trip_data['days'], 2); ?> USD</span>
                </div>

                <div class="price-row">
                    <span class="price-label">Insurance</span>
                    <span class="price-value">- $<?php echo number_format($trip_data['insurance_price'], 2); ?> USD</span>
                </div>

                <?php 
                $extras = json_decode($trip_data['extras'], true);
                if($extras): 
                    foreach($extras as $extra): 
                ?>
                <div class="price-row">
                    <span class="price-label"><?php echo $extra['name']; ?></span>
                    <span class="price-value">- $<?php echo number_format($extra['price'], 2); ?> USD</span>
                </div>
                <?php 
                    endforeach; 
                endif; 
                ?>

                <div class="price-row">
                    <span class="price-label">Pick-up Location Fees</span>
                    <span class="price-value">- $<?php echo number_format($trip_data['pickup_location_fees'], 2); ?> USD</span>
                </div>

                <div class="price-row">
                    <span class="price-label">Return Location Fees</span>
                    <span class="price-value">- $<?php echo number_format($trip_data['dropup_location_fees'], 2); ?> USD</span>
                </div>

                <?php if($trip_data['is_coupon']): ?>
                <div class="price-row" style="color: #5cb85c;">
                    <span class="price-label">Coupon Discount (<?php echo $trip_data['coupon_code']; ?>)</span>
                    <span class="price-value">- $<?php echo number_format($trip_data['discount_amount'], 2); ?> USD</span>
                </div>
                <?php endif; ?>

                <div class="price-row total-row">
                    <span class="price-label">Total Amount</span>
                    <span class="price-value">$<?php echo number_format($trip_data['t_trip_amount'], 2); ?> USD</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Paid Amount</span>
                    <span class="price-value" style="color: green;">$<?php echo isset($trip_data['paid_amount']) ? number_format($trip_data['paid_amount'], 2) : '0.00'; ?> USD</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Pending Amount</span>
                    <span class="price-value" style="color: orange;">$<?php echo isset($trip_data['pending_amount']) ? number_format($trip_data['pending_amount'], 2) : (isset($trip_data['t_trip_amount']) ? number_format($trip_data['t_trip_amount'], 2) : '0.00'); ?> USD</span>
                </div>
                <div class="price-row">
                    <span class="price-label">Payment Method</span>
                    <span class="price-value" style="text-transform: capitalize;">
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
            <?php else: ?>
            <!-- Personal Information Details -->
            <div class="booking-details">
                <h2>Personal Information Summary</h2>
                
                <div class="detail-row">
                    <span class="detail-label">Full Name:</span>
                    <span class="detail-value"><?php echo $customer_data['c_name'] . ' ' . $customer_data['last_name']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value"><?php echo $customer_data['c_email']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value"><?php echo $customer_data['c_mobile']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Passport Number:</span>
                    <span class="detail-value"><?php echo $customer_data['pass_number']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Country:</span>
                    <span class="detail-value"><?php echo $customer_data['country']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date of Birth:</span>
                    <span class="detail-value"><?php echo $customer_data['dob']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Address:</span>
                    <span class="detail-value"><?php echo $customer_data['c_address']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">City:</span>
                    <span class="detail-value"><?php echo $customer_data['city']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Zip Code:</span>
                    <span class="detail-value"><?php echo $customer_data['zipcode']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Driver License Number:</span>
                    <span class="detail-value"><?php echo $customer_data['license_number']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">License Issue Date:</span>
                    <span class="detail-value"><?php echo $customer_data['license_issue_date']; ?></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">License Expiry Date:</span>
                    <span class="detail-value"><?php echo $customer_data['license_expiry_date']; ?></span>
                </div>
            </div>
            <?php endif; ?>

            <div style="text-align: center; margin: 25px 0;">
                <a href="#" style="background-color: #d9534f; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold; font-family: Arial, sans-serif;">
                    <?php echo $type === 'personal' ? 'View My Profile' : 'View Booking Details'; ?>
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> Dunya Car Rental. All rights reserved.</p>
            <p>Address: Exit 10W, Airport Rd., Amman, Jordan</p>
            <p>Need help? Contact us at bookings@dunyacars.com or +962799280000</p>
        </div>
    </div>
</body>
</html>
