<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Your Booking Under Review - Rydaris</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        /* Reset */

        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
        }

        img {
            display: block;
            border: 0;
            max-width: 100%;
            height: auto;
        }

        /* Mobile Responsive */

        @media only screen and (max-width:600px) {

            .main-table {
                width: 100% !important;
            }

            .padding-mobile {
                padding: 25px !important;
            }

            .red-box {
                padding: 25px !important;
            }

            .heading {
                font-size: 24px !important;
            }

            .subtext {
                font-size: 16px !important;
            }

            .logo {
                width: 120px !important;
            }

        }
    </style>

</head>

<body>

    <!-- OUTER -->

    <table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f5f5f5">

        <tr>
            <td align="center">

                <!-- MAIN TABLE -->

                <table width="700" cellpadding="0" cellspacing="0" class="main-table" bgcolor="#ffffff"
                    style="width:700px; max-width:700px;">

                    <!-- HERO SECTION -->

                    <tr>

                        <td background="{{ asset('assets/frontend/images/pending-bg.png') }}" style="
background-image:url('{{ asset('assets/frontend/images/pending-bg.png') }}');
background-size:cover;
background-position:center;
background-repeat:no-repeat;
padding:30px 40px 40px 40px;;
">

                            <!-- LOGO FIXED -->

                            <table width="100%">

                                <tr>

                                    <td align="left">

                                        <img src="{{ asset('assets/logo/logo.png') }}" width="200" class="logo" style="
width:200px;
height:auto;
margin-bottom:40px;
display:block;
">

                                    </td>

                                </tr>

                            </table>

                            <!-- RED BOX -->

                            <table width="100%">

                                <tr>

                                    <td class="red-box" style="
background:#0f766e;
color:white;
padding:35px;
border-radius:18px;
">

                                        <h1 class="heading" style="
margin:0;
font-size:32px;
font-weight:700;
line-height:1.2;
">

                                            Thank you for driving with Rydaris!

                                        </h1>

                                        <p class="subtext" style="
margin-top:15px;
font-size:18px;
line-height:1.5;
">

                                            Your journey begins with us safe,
                                            simple, and unforgettable.

                                        </p>

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>

                    <!-- CONTENT -->

                    <tr>

                        <td class="padding-mobile" style="
padding:30px 40px;
font-size:16px;
color:#444;
line-height:1.7;
">

                            <p style="margin-top:0;">

                                Just letting you know — we've received your booking!

                                Your reservation request has been successfully received
                                and is now being reviewed by our team.

                            </p>

                            <p>

                                Keep an eye on your inbox — once approved,
                                you will receive a
                                <strong>Booking Confirmation Email</strong>
                                with all the details of your trip.

                            </p>

                            <!-- STATUS BOX -->

                            <table width="100%">

                                <tr>

                                    <td style="
background:#fff4e5;
border-left:5px solid #ff9800;
padding:18px;
font-size:15px;
">

                                        <strong>Booking Status:</strong>

                                        Pending Approval

                                        <br><br>

                                        <strong>Booking Reference:</strong>

                                        {{ $booking->reservation_number }}

                                        <br>

                                        <strong>Email:</strong>

                                        {{ $booking->customer_email }}

                                    </td>

                                </tr>

                            </table>

                        </td>

                    </tr>

                    <!-- FOOTER -->

                    <tr>

                        <td style="
background:#2c3e50;
color:white;
text-align:center;
padding:25px;
font-size:14px;
line-height:1.6;
">

                            If you have any questions about your booking, please contact us:

                            <br><br>

                            Email: support@rydaris.com

                            <br><br>

                            We look forward to serving you!

                            <br><br>

                            <strong>Rydaris Team</strong>

                        </td>

                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>

</html>
