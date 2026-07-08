<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Modified - Rydaris</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { margin:0; padding:0; background:#f5f5f5; font-family:Arial,Helvetica,sans-serif; }
        table { border-collapse:collapse; }
        img { display:block; border:0; max-width:100%; height:auto; }
        @media only screen and (max-width:600px) {
            .main-table { width:100% !important; }
            .padding-mobile { padding:25px !important; }
            .hero-box { padding:25px !important; }
            .heading { font-size:24px !important; }
            .subtext { font-size:16px !important; }
            .logo { width:120px !important; }
        }
    </style>
</head>
<body>

    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f5f5f5">
        <tr>
            <td align="center">

                <table width="700" cellpadding="0" cellspacing="0" class="main-table" bgcolor="#ffffff" style="width:700px;max-width:700px;">

                    <!-- HERO SECTION -->
                    <tr>
                        <td background="{{ asset('assets/frontend/images/pending-bg.png') }}" style="background-image:url('{{ asset('assets/frontend/images/pending-bg.png') }}');background-size:cover;background-position:center;background-repeat:no-repeat;padding:30px 40px 40px 40px;">

                            <!-- LOGO -->
                            <table width="100%">
                                <tr>
                                    <td align="left">
                                        <img src="{{ asset('assets/logo/logo.png') }}" width="200" class="logo" style="width:200px;height:auto;margin-bottom:40px;display:block;">
                                    </td>
                                </tr>
                            </table>

                            <!-- HERO BOX -->
                            <table width="100%">
                                <tr>
                                    <td class="hero-box" style="background:#0f766e;color:white;padding:35px;border-radius:18px;">
                                        <h1 class="heading" style="margin:0;font-size:32px;font-weight:700;line-height:1.2;">
                                            Your Booking Has Been Modified!
                                        </h1>
                                        <p class="subtext" style="margin-top:15px;font-size:18px;line-height:1.5;">
                                            Your booking details have been successfully updated as per your request.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- CONTENT -->
                    <tr>
                        <td class="padding-mobile" style="padding:30px 40px;font-size:16px;color:#444;line-height:1.7;">

                            <p style="margin-top:0;">
                                Dear <strong>{{ $booking->customer_fname }} {{ $booking->customer_lname }}</strong>,
                            </p>
                            <p>
                                We're writing to confirm that your booking <strong>#{{ $booking->reservation_number }}</strong> has been successfully modified. Here is a summary of your updated booking details:
                            </p>

                            <!-- STATUS BOX -->
                            <table width="100%">
                                <tr>
                                    <td style="background:#fff4e5;border-left:5px solid #0f766e;padding:18px;font-size:15px;border-radius:4px;margin-bottom:20px;">
                                        <strong>Booking Reference:</strong> {{ $booking->reservation_number }}<br><br>
                                        <strong>Status:</strong> {{ ucfirst($booking->booking_status) }}<br>
                                        <strong>Email:</strong> {{ $booking->customer_email }}
                                    </td>
                                </tr>
                            </table>

                            <br>

                            <!-- BOOKING DETAILS TABLE -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee;border-radius:8px;overflow:hidden;">
                                <tr>
                                    <td colspan="2" style="background:#0f766e;color:#fff;padding:15px 20px;font-size:16px;font-weight:700;">
                                        Booking Summary
                                    </td>
                                </tr>
                                <tr style="background:#f9f9f9;">
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;width:50%;border-bottom:1px solid #eee;">Vehicle</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ $booking->vehicle->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Pick-Up Location</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ $booking->pickupLocation->location ?? 'N/A' }}</td>
                                </tr>
                                <tr style="background:#f9f9f9;">
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Pick-Up Date & Time</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ date('d M Y', strtotime($booking->pickup_date)) }} at {{ $booking->pickup_time }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Return Location</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ $booking->returnLocation->location ?? 'N/A' }}</td>
                                </tr>
                                <tr style="background:#f9f9f9;">
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Return Date & Time</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ date('d M Y', strtotime($booking->return_date)) }} at {{ $booking->return_time }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Customer Name</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ $booking->customer_fname }} {{ $booking->customer_lname }}</td>
                                </tr>
                                <tr style="background:#f9f9f9;">
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Phone</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">{{ $booking->customer_phone }}</td>
                                </tr>
                                @if($booking->extras && $booking->extras->count())
                                <tr>
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Optional Extras</td>
                                    <td style="padding:12px 20px;color:#333;border-bottom:1px solid #eee;">
                                        @foreach($booking->extras as $extra)
                                            {{ $extra->vendorExtra->name ?? 'Extra' }} (x{{ $extra->qty }})<br>
                                        @endforeach
                                    </td>
                                </tr>
                                @endif
                                <!-- PRICE ROWS -->
                                <tr>
                                    <td colspan="2" style="background:#0f766e;color:#fff;padding:15px 20px;font-size:16px;font-weight:700;">
                                        Price Breakdown
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Total Amount</td>
                                    <td style="padding:12px 20px;color:#333;font-weight:700;border-bottom:1px solid #eee;">${{ number_format($booking->total_amount, 2) }}</td>
                                </tr>
                                <tr style="background:#f9f9f9;">
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;border-bottom:1px solid #eee;">Paid Amount</td>
                                    <td style="padding:12px 20px;color:#16a34a;font-weight:700;border-bottom:1px solid #eee;">${{ number_format($booking->paid_amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:12px 20px;color:#555;font-weight:bold;">Pending Amount</td>
                                    <td style="padding:12px 20px;color:#d97706;font-weight:700;">${{ number_format($booking->pending_amount ?? 0, 2) }}</td>
                                </tr>
                            </table>

                            <br>
                            <p>
                                If you did not request this modification or have any questions, please contact us immediately.
                            </p>

                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="background:#2c3e50;color:white;text-align:center;padding:25px;font-size:14px;line-height:1.6;">
                            If you have any questions, please contact us:<br><br>
                            Email: support@rydaris.com<br><br>
                            We look forward to serving you!<br><br>
                            <strong>Rydaris Team</strong>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
