<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dunya Car Rental - Booking Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 0; color: #374151;">
    <!-- Email Container -->
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff;">
        <!-- Header -->
        <div style="background-color: #ffffff; padding: 20px; border-bottom: 1px solid #e5e7eb; text-align: center;">
            <img src="<?php echo url('assets/frontend/images/logo.png'); ?>" alt="Dunya Car Rental" style="max-width: 150px;">

        </div>
        
        <!-- Confirmation Message -->
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 20px; margin: 20px;">
            <h1 style="font-size: 18px; font-weight: 600; color: #991b1b; margin-bottom: 10px;">
                We are pleased to inform you that your car rental reservation with Dunya has been successfully confirmed. We are looking forward to hosting you and providing you with the best possible rental experience.
            </h1>
        </div>
        
        <!-- Booking Details -->
        <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin: 0 20px 20px;">
            <h2 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">Your booking details</h2>
            
            <div style="margin-bottom: 16px;">
                <span style="font-weight: 500; color: #4b5563;">Booking ID:</span>
                <span style="color: #6b7280; margin-left: 8px;"><?php echo $trip_data['t_trackingcode']; ?></span>
            </div>
            
            <div style="margin-bottom: 16px;">
                <span style="font-weight: 500; color: #4b5563;">Total:</span>
                <span style="color: #6b7280; margin-left: 8px;"><?php echo number_format($trip_data['t_trip_amount'], 2); ?> USD</span>
            </div>
            <div style="margin-bottom: 16px;">
                <span style="font-weight: 500; color: #4b5563;">Paid Amount:</span>
                <span style="color: green; font-weight: bold; margin-left: 8px;"><?php echo isset($trip_data['paid_amount']) ? number_format($trip_data['paid_amount'], 2) : '0.00'; ?> USD</span>
            </div>
            <div style="margin-bottom: 16px;">
                <span style="font-weight: 500; color: #4b5563;">Pending Amount:</span>
                <span style="color: orange; font-weight: bold; margin-left: 8px;"><?php echo isset($trip_data['pending_amount']) ? number_format($trip_data['pending_amount'], 2) : number_format($trip_data['t_trip_amount'], 2); ?> USD</span>
            </div>
            <div style="margin-bottom: 16px;">
                <span style="font-weight: 500; color: #4b5563;">Payment Method:</span>
                <span style="color: #6b7280; margin-left: 8px; text-transform: capitalize;">
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

            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 16px 0;">
                <tr>
                    <td width="50%" valign="top" style="padding-right: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 500; color: #4b5563;">Vehicle Class:</div>
                            <div style="color: #6b7280;"><?php echo $trip_data['t_vechicle']; ?></div>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 500; color: #4b5563;">Pick-Up:</div>
                            <div style="color: #6b7280; font-size: 14px;">
                                <div><?php echo date('d M H:i', strtotime($trip_data['t_start_date'] . ' ' . $trip_data['fromtime'])); ?> Hrs</div>
                                <div>at <?php echo $trip_data['t_trip_fromlocation']; ?></div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 500; color: #4b5563;">Extras:</div>
                            <div style="color: #6b7280;"><?php echo number_format($trip_data['extras_total'], 2); ?> USD</div>
                        </div>
                    </td>
                    <td width="50%" valign="top" style="padding-left: 10px;">
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 500; color: #4b5563;">Transmission:</div>
                            <div style="color: #6b7280;">automatic</div>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 500; color: #4b5563;">Return:</div>
                            <div style="color: #6b7280; font-size: 14px;">
                                <div><?php echo date('d M H:i', strtotime($trip_data['t_end_date'] . ' ' . $trip_data['totime'])); ?> Hrs</div>
                                <div>at <?php echo $trip_data['t_trip_tolocation']; ?></div>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 12px;">
                            <div style="font-weight: 500; color: #4b5563;">Insurance:</div>
                            <div style="color: #6b7280; font-size: 14px;">
                                <div><?php echo number_format($trip_data['insurance_price'], 2); ?> USD</div>
                                <div>Type: <?php echo $trip_data['insurance_name']; ?></div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>

            <a href="<?= url('manage-booking') ?>" style="display: inline-block; background-color: #dc2626; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 500; text-decoration: none; margin-top: 16px;">Manage Booking</a>
        </div>

        <!-- Reminder Section -->
        <div style="background-color: #dc2626; color: white; border-radius: 8px; padding: 20px; margin: 0 20px 20px;">
            <h2 style="font-size: 20px; font-weight: 700; color: white; margin-bottom: 8px;">Remember to check online</h2>
            <p style="color: #fecaca; margin-bottom: 12px;">To ensure Zero Waiting Time</p>
            <ul style="margin: 0; padding-left: 20px;">
                <li style="margin-bottom: 8px; color: #fecaca;">
                    Online check-in opens before your pick up
                </li>
                <li style="color: #fecaca;">
                    Check in online to get the Jordan Road Safety Information better than ever and faster than anywhere else!
                </li>
            </ul>
        </div>

        <!-- Know Before You Go -->
        <div style="background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin: 0 20px 20px;">
            <h2 style="font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 16px;">Know before you go</h2>
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%" valign="top" style="padding-right: 10px;">
                        <div style="margin-bottom: 16px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="32" valign="top" style="padding-right: 12px;">
                                        <div style="width: 32px; height: 32px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <div style="width: 12px; height: 12px; background-color: #dc2626; border-radius: 50%; margin: auto;"></div>
                                        </div>
                                    </td>
                                    <td valign="top">
                                        <h3 style="font-weight: 500; color: #111827; margin-bottom: 4px;">What to bring</h3>
                                        <p style="color: #6b7280; font-size: 14px;">
                                            The only thing you need to bring is a valid credit card and driver license.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="32" valign="top" style="padding-right: 12px;">
                                        <div style="width: 32px; height: 32px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <div style="width: 12px; height: 12px; background-color: #dc2626; border-radius: 50%; margin: auto;"></div>
                                        </div>
                                    </td>
                                    <td valign="top">
                                         <h3 style="font-weight: 500; color: #111827; margin-bottom: 4px;">Office Opening hours</h3>
                                         <div style="color: #6b7280; font-size: 14px;">
                                             <div>Exit 10W, Airport Rd.,</div>
                                             <div>Amman, Jordan</div>
                                             <div>Office Time:</div>
                                             <div>Mon - Sun: 00:00AM - 23:55PM</div>
                                         </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                    <td width="50%" valign="top" style="padding-left: 10px;">
                        <div style="margin-bottom: 16px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="32" valign="top" style="padding-right: 12px;">
                                        <div style="width: 32px; height: 32px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <div style="width: 12px; height: 12px; background-color: #dc2626; border-radius: 50%; margin: auto;"></div>
                                        </div>
                                    </td>
                                    <td valign="top">
                                        <h3 style="font-weight: 500; color: #111827; margin-bottom: 4px;">Cancellation</h3>
                                        <p style="color: #6b7280; font-size: 14px;">
                                            Cancel more than 72 hours prior to the rental and get a full refund.
Terms & conditions applied
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div>
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="32" valign="top" style="padding-right: 12px;">
                                        <div style="width: 32px; height: 32px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <div style="width: 12px; height: 12px; background-color: #dc2626; border-radius: 50%; margin: auto;"></div>
                                        </div>
                                    </td>
                                    <td valign="top">
                                        <h3 style="font-weight: 500; color: #111827; margin-bottom: 4px;">Terms & Conditions</h3>
                                        <div style="color: #6b7280; font-size: 14px;">
                                            <div>We have our full terms and conditions on our website here</div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        <!-- Company Information -->
        <div style="background-color: #ffffff; padding: 20px; margin: 0 20px 20px; text-align: center;">
            <h2 style="font-size: 22px; font-weight: 700; color: #111827; margin-bottom: 16px;">
                Dunya Car Rental Jordan
            </h2>
            
            <div style="color: #4b5563; margin-bottom: 8px;">
                <span style="font-weight: 500;">E-mail: bookings@dunyacars.com</span>
            </div>
            
            <div style="color: #4b5563; margin-bottom: 8px;">
                <span style="font-weight: 500;">Phone: +962799280000</span>
            </div>
        
            <div style="color: #4b5563; margin-bottom: 16px;">
                <span style="font-weight: 500;">Exit 10W, Airport Rd., Amman, Jordan</span>
            </div>
            
            <p style="color: #6b7280; font-size: 14px; max-width: 400px; margin: 0 auto;">
                If you have any inquiries, please feel free to contact the service team.
            </p>
        </div>
    </div>
</body>
</html>
