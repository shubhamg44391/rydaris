<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Enquiry - Dunya Car Rental</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e5e5e5;
        }
        .header {
            background: #ffffff;
            padding: 25px;
            text-align: center;
            border-bottom: 2px solid #ea580c; /* orange-600 matching brand */
        }
        .logo {
            height: 50px;
        }
        .content {
            padding: 30px;
        }
        .title {
            margin-bottom: 25px;
        }
        .title h1 {
            color: #ea580c;
            font-size: 22px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .title p {
            color: #666666;
            margin: 0;
            font-size: 14px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .details-table th, .details-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eeeeee;
        }
        .details-table th {
            background-color: #f9f9f9;
            color: #555555;
            font-weight: bold;
            width: 30%;
            font-size: 14px;
        }
        .details-table td {
            color: #333333;
            font-size: 14px;
        }
        .message-box {
            background-color: #f9fafb;
            border-left: 4px solid #ea580c;
            padding: 20px;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 14px;
            color: #4b5563;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 20px;
            color: #9ca3af;
            font-size: 12px;
            border-top: 1px solid #f3f4f6;
        }
        .footer a {
            color: #ea580c;
            text-decoration: none;
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
            <div class="title">
                <h1>New Enquiry Received</h1>
                <p>A user has submitted a new inquiry via the Contact Us form on Dunya Car Rental website.</p>
            </div>

            <!-- Details Table -->
            <table class="details-table">
                <tr>
                    <th>Sender Name</th>
                    <td><?php echo html_escape($firstname . ' ' . $lastname); ?></td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td><a href="mailto:<?php echo html_escape($email); ?>" style="color: #ea580c; text-decoration: none;"><?php echo html_escape($email); ?></a></td>
                </tr>
                <tr>
                    <th>Phone Number</th>
                    <td>
                        <?php if (!empty($phone)): ?>
                            <a href="tel:<?php echo html_escape($phone); ?>" style="color: #ea580c; text-decoration: none;"><?php echo html_escape($phone); ?></a>
                        <?php else: ?>
                            <em>Not Provided</em>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Submitted On</th>
                    <td><?php echo date('d M Y \a\t H:i'); ?></td>
                </tr>
            </table>

            <!-- Message Box -->
            <h3 style="color: #374151; font-size: 15px; margin: 20px 0 10px 0;">Message Content:</h3>
            <div class="message-box"><?php echo html_escape($message); ?></div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; <?php echo date('Y'); ?> Dunya Car Rental. All rights reserved.</p>
            <p>Address: Exit 10W, Airport Rd., Amman, Jordan</p>
            <p>This is an automated notification. Please reply to the user's email directly.</p>
        </div>
    </div>
</body>
</html>
