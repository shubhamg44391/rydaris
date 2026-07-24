<?php

namespace App\Demo;

class DemoData
{
    public static function bookings(): array
    {
        $customers = ['Shubham Gupta', 'Aarav Mehta', 'Pooja Sharma', 'Vikram Singh', 'Neha Patel', 'Rahul Verma', 'Sneha Iyer', 'Karan Malhotra', 'Divya Nair', 'Rohan Das', 'Ananya Rao', 'Manish Jain', 'Ritu Kapoor', 'Amit Shah', 'Priya Menon', 'Sahil Khan', 'Isha Reddy', 'Naveen Kumar', 'Tara Bose', 'Yash Thakur'];
        $vehicles = ['Toyota Innova Crysta', 'Hyundai Creta', 'Maruti Swift Dzire', 'Mahindra XUV700', 'Honda City'];
        $locs = ['Surat Airport Counter', 'City Center Desk', 'Udhana Depot', 'Branch - Dhili', 'Railway Station'];
        $bStatus = ['confirmed', 'ongoing', 'completed', 'pending', 'cancelled'];
        $pStatus = ['partial', 'paid', 'paid', 'pending', 'refunded'];
        $methods = ['Razorpay', 'Pay on Arrival'];

        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $total = 3000.0 + (($i * 1250) % 22000);
            $ps = $pStatus[$i % 5];
            $paid = $ps === 'paid' ? $total : ($ps === 'partial' ? round($total / 2, 2) : 0.0);
            $day = str_pad((string) (($i % 27) + 1), 2, '0', STR_PAD_LEFT);
            $rows[] = [
                'booked_at' => "Jul {$day}, 2026 " . str_pad((string) (8 + ($i % 9)), 2, '0', STR_PAD_LEFT) . ':' . str_pad((string) (($i * 7) % 60), 2, '0', STR_PAD_LEFT) . ' AM',
                'reservation' => 'RSV-' . (1001 + $i),
                'customer' => $customers[$i % count($customers)],
                'vehicle' => $vehicles[$i % count($vehicles)],
                'pickup' => $locs[$i % count($locs)],
                'pickup_at' => "Jul {$day}, 2026 02:00 PM",
                'return' => $locs[($i + 2) % count($locs)],
                'return_at' => 'Jul ' . str_pad((string) ((($i % 24) + 4)), 2, '0', STR_PAD_LEFT) . ', 2026 02:00 PM',
                'paid' => (float) $paid,
                'pending' => (float) ($total - $paid),
                'total' => (float) $total,
                'payment_ref' => $ps === 'pending' ? 'N/A' : 'pay_ref_' . (1000 + $i),
                'booking_status' => $bStatus[$i % 5],
                'payment_status' => $ps,
                'payment_method' => $methods[$i % 2],
            ];
        }

        return $rows;
    }

    public static function vehicles(): array
    {
        $names = ['Toyota Innova Crysta', 'Hyundai Creta', 'Maruti Swift Dzire', 'Mahindra XUV700', 'Honda City', 'Kia Seltos', 'Tata Nexon', 'Renault Kwid', 'Volkswagen Virtus', 'Skoda Slavia'];
        $groups = ['MPV', 'SUV', 'Sedan', 'SUV', 'Sedan', 'SUV', 'SUV', 'Hatchback', 'Sedan', 'Sedan'];
        $fuels = ['Diesel', 'Petrol', 'CNG', 'Electric'];
        $statuses = ['Available', 'On Rent', 'Maintenance', 'Reserved'];

        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'name' => $names[$i % count($names)] . ($i >= count($names) ? ' II' : ''),
                'group' => $groups[$i % count($groups)],
                'plate' => 'GJ05 ' . chr(65 + ($i % 26)) . chr(66 + ($i % 25)) . ' ' . (1000 + $i * 37 % 9000),
                'year' => (string) (2021 + ($i % 4)),
                'fuel' => $fuels[$i % count($fuels)],
                'seats' => [5, 7, 5, 7, 5][$i % 5],
                'status' => $statuses[$i % count($statuses)],
            ];
        }

        return $rows;
    }

    public static function locations(): array
    {
        $names = ['Surat Airport Counter', 'City Center Desk', 'Udhana Depot', 'Branch - Dhili', 'Railway Station', 'Adajan Hub', 'Vesu Plaza', 'Katargam Point', 'Piplod Counter', 'Athwa Gate'];
        $cities = ['Surat', 'Surat', 'Surat', 'Dhili', 'Surat', 'Surat', 'Surat', 'Surat', 'Surat', 'Surat'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'name' => $names[$i % count($names)] . ($i >= count($names) ? ' 2' : ''),
                'city' => $cities[$i % count($cities)],
                'address' => 'Sector ' . (($i % 12) + 1) . ', Main Road',
                'phone' => '+91 98765 ' . str_pad((string) (11111 + $i * 111), 5, '0', STR_PAD_LEFT),
                'hours' => $i % 4 === 0 ? '24×7' : '08:00–22:00',
                'status' => $i % 5 === 3 ? 'Inactive' : 'Active',
            ];
        }

        return $rows;
    }

    public static function customers(): array
    {
        $names = ['Shubham Gupta', 'Aarav Mehta', 'Pooja Sharma', 'Vikram Singh', 'Neha Patel', 'Rahul Verma', 'Sneha Iyer', 'Karan Malhotra', 'Divya Nair', 'Rohan Das', 'Ananya Rao', 'Manish Jain', 'Ritu Kapoor', 'Amit Shah', 'Priya Menon', 'Sahil Khan', 'Isha Reddy', 'Naveen Kumar', 'Tara Bose', 'Yash Thakur'];
        $branches = ['Surat', 'Udhana', 'Dhili', 'All Branches'];
        $rows = [];
        foreach ($names as $i => $name) {
            $slug = strtolower(str_replace(' ', '.', $name));
            $rows[] = [
                'name' => $name,
                'email' => $slug . '@example.com',
                'phone' => '+91 9' . str_pad((string) (100000000 + $i * 7654321), 9, '0', STR_PAD_LEFT),
                'branch' => $branches[$i % count($branches)],
                'status' => $i % 6 === 5 ? 'Inactive' : 'Active',
            ];
        }

        return $rows;
    }

    public static function invitations(): array
    {
        $roles = ['Staff', 'User', 'Manager'];
        $statuses = ['Pending', 'Accepted', 'Expired'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'email' => 'user' . ($i + 1) . '@fleetco.com',
                'role' => $roles[$i % count($roles)],
                'sent' => '2026-0' . (6 + ($i % 2)) . '-' . str_pad((string) (($i % 27) + 1), 2, '0', STR_PAD_LEFT),
                'status' => $statuses[$i % count($statuses)],
            ];
        }

        return $rows;
    }

    public static function fleet(): array
    {
        return [
            ['vehicle' => 'Toyota Innova Crysta', 'plate' => 'GJ05 AB 4521', 'location' => 'Surat Airport', 'status' => 'Available', 'next' => '—'],
            ['vehicle' => 'Hyundai Creta', 'plate' => 'GJ05 CD 8890', 'location' => 'City Center', 'status' => 'On Rent', 'next' => '2026-07-13'],
            ['vehicle' => 'Maruti Swift Dzire', 'plate' => 'GJ05 EF 1122', 'location' => 'Udhana Depot', 'status' => 'Available', 'next' => '—'],
            ['vehicle' => 'Mahindra XUV700', 'plate' => 'GJ05 GH 3344', 'location' => 'Workshop', 'status' => 'Maintenance', 'next' => '2026-07-20'],
            ['vehicle' => 'Honda City', 'plate' => 'GJ05 IJ 5566', 'location' => 'Branch - Dhili', 'status' => 'Reserved', 'next' => '2026-07-18'],
        ];
    }

    public static function extras(): array
    {
        $names = ['Child Seat', 'GPS Navigator', 'Additional Driver', 'Wi-Fi Hotspot', 'Baby Seat', 'Snow Chains', 'Roadside Assistance', 'Fuel Prepay', 'Parking Pass', 'Roof Rack'];
        $types = ['Per Day', 'Per Day', 'Per Booking'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'name' => $names[$i % count($names)] . ($i >= count($names) ? ' Plus' : ''),
                'type' => $types[$i % count($types)],
                'price' => '₹' . (100 + ($i * 50) % 900),
                'status' => $i % 5 === 4 ? 'Inactive' : 'Active',
            ];
        }

        return $rows;
    }

    public static function insurance(): array
    {
        $names = ['Basic CDW', 'Super Cover', 'Personal Accident', 'Theft Protection', 'Tyre & Glass', 'Zero Excess', 'Full Insurance', 'Breakdown Cover', 'Collision Coverage', 'Third Party'];
        $cover = ['Collision damage waiver', 'Zero excess + theft', 'Occupant PA cover', 'Theft & burglary', 'Tyre and windscreen', 'No excess payable', 'All-round coverage', '24×7 breakdown', 'Collision only', 'Liability only'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'name' => $names[$i % count($names)] . ($i >= count($names) ? ' 2' : ''),
                'coverage' => $cover[$i % count($cover)],
                'price' => '₹' . (199 + ($i * 100) % 800) . ' / day',
                'status' => $i % 6 === 5 ? 'Inactive' : 'Active',
            ];
        }

        return $rows;
    }

    public static function features(): array
    {
        $feats = ['Bluetooth Audio', 'Rear Camera', 'Sunroof', '7 Seater', 'Cruise Control', 'Apple CarPlay', 'Ventilated Seats', 'Wireless Charging', 'ABS', 'Airbags', 'Keyless Entry', 'Parking Sensors', 'Auto AC', 'Alloy Wheels', 'LED Headlamps', 'Push Start', 'Hill Assist', '360 Camera', 'Ambient Lighting', 'Touchscreen'];
        $groups = ['All Groups', 'SUV, Sedan', 'SUV', 'MPV, SUV', 'Sedan'];
        $mapped = ['Yes', 'Partial', 'Yes'];
        $rows = [];
        foreach ($feats as $i => $f) {
            $rows[] = [
                'feature' => $f,
                'group' => $groups[$i % count($groups)],
                'mapped' => $mapped[$i % count($mapped)],
            ];
        }

        return $rows;
    }

    public static function rules(): array
    {
        $titles = ['Minimum Age', 'Fuel Policy', 'Mileage Limit', 'Smoking Policy', 'Security Deposit', 'Late Return', 'Cancellation', 'Cross-Border', 'Pet Policy', 'Cleaning Fee'];
        $details = ['Driver must be 21+ with valid license', 'Full to Full — return with same fuel level', '250 km/day included; excess ₹12/km', 'No smoking inside vehicles', 'Refundable deposit of ₹5,000', 'Late fee ₹300/hour after grace', 'Free cancellation up to 24h', 'Prior approval required', 'Pets allowed with cover', 'Charged if returned unclean'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'title' => $titles[$i % count($titles)] . ($i >= count($titles) ? ' (v2)' : ''),
                'detail' => $details[$i % count($details)],
                'status' => $i % 7 === 6 ? 'Inactive' : 'Active',
            ];
        }

        return $rows;
    }

    public static function coupons(): array
    {
        $codes = ['WELCOME10', 'WEEKEND500', 'FLEET20', 'SUMMER15', 'FIRSTRIDE', 'LOYAL25', 'FESTIVE50', 'EARLYBIRD', 'MONSOON10', 'CORP30'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $isPct = $i % 2 === 0;
            $rows[] = [
                'code' => $codes[$i % count($codes)] . ($i >= count($codes) ? ($i) : ''),
                'discount' => $isPct ? ((10 + ($i % 4) * 5) . '% off') : ('₹' . (250 + ($i % 4) * 250) . ' flat'),
                'valid' => '2026-' . str_pad((string) (7 + ($i % 5)), 2, '0', STR_PAD_LEFT) . '-28',
                'uses' => (($i * 7) % 100) . ' / 100',
                'status' => ($i % 5 === 4) ? 'Expired' : 'Active',
            ];
        }

        return $rows;
    }

    public static function tickets(): array
    {
        $subjects = ['Payment gateway not reflecting', 'Need help adding branch users', 'Invoice PDF formatting issue', 'Unable to upload vehicle image', 'Booking email not received', 'Coupon not applying', 'Refund status query', 'Change subscription plan', 'Reset staff password', 'Export report failing'];
        $priorities = ['High', 'Medium', 'Low'];
        $statuses = ['Open', 'In Progress', 'Resolved'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $rows[] = [
                'id' => 'TKT-' . (501 - $i),
                'subject' => $subjects[$i % count($subjects)],
                'priority' => $priorities[$i % count($priorities)],
                'status' => $statuses[$i % count($statuses)],
                'date' => '2026-07-' . str_pad((string) ((($i * 3) % 27) + 1), 2, '0', STR_PAD_LEFT),
            ];
        }

        return $rows;
    }

    public static function packages(): array
    {
        return [
            ['name' => 'Launch', 'price' => '₹2,999 / mo', 'users' => '3', 'vehicles' => '25', 'highlight' => false],
            ['name' => 'Growth', 'price' => '₹7,999 / mo', 'users' => '10', 'vehicles' => '100', 'highlight' => true],
            ['name' => 'Enterprise', 'price' => 'Custom', 'users' => 'Unlimited', 'vehicles' => 'Unlimited', 'highlight' => false],
        ];
    }

    public static function subscriptionHistory(): array
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $rows = [];
        for ($i = 0; $i < 20; $i++) {
            $m = 6 - ($i % 12);
            $year = $m < 0 ? 2025 : 2026;
            $mi = (($m % 12) + 12) % 12;
            $next = ($mi + 1) % 12;
            $plan = $i % 3 === 2 ? 'Launch' : 'Growth';
            $rows[] = [
                'plan' => $plan,
                'period' => $months[$mi] . " {$year} – " . $months[$next] . ' ' . ($next === 0 ? $year + 1 : $year),
                'amount' => $plan === 'Launch' ? '₹2,999' : '₹7,999',
                'status' => $i === 0 ? 'Active' : 'Paid',
                'paid' => "{$year}-" . str_pad((string) ($mi + 1), 2, '0', STR_PAD_LEFT) . '-01',
            ];
        }

        return $rows;
    }

    public static function rateGroups(): array
    {
        return [
            ['id' => '1', 'name' => 'Economy / Sedan'],
            ['id' => '2', 'name' => 'SUV'],
            ['id' => '3', 'name' => 'MPV'],
        ];
    }

    /**
     * Pricing matrix matching vendor availability fetchRates shape.
     * Day keys = rental duration tiers (not calendar days).
     */
    public static function ratesMatrix(?string $startDate = null, ?string $endDate = null): array
    {
        $start = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : now()->startOfDay();
        $end = $endDate ? \Carbon\Carbon::parse($endDate)->startOfDay() : now()->copy()->addDays(29)->startOfDay();

        $dates = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $dates[] = $d->format('Y-m-d');
        }

        $groupDefs = [
            '1' => [
                'name' => 'Economy / Sedan',
                'base' => [1 => 2500, 2 => 2300, 3 => 2100, 4 => 2000, 5 => 1900, 6 => 1850, 7 => 1800],
                'vehicles' => [
                    '101' => ['name' => 'Maruti Swift Dzire', 'code' => 'EDAR', 'bump' => 100],
                    '102' => ['name' => 'Honda City', 'code' => 'CDAR', 'bump' => 250],
                ],
            ],
            '2' => [
                'name' => 'SUV',
                'base' => [1 => 4200, 2 => 4000, 3 => 3800, 4 => 3600, 5 => 3500, 6 => 3400, 7 => 3300],
                'vehicles' => [
                    '201' => ['name' => 'Hyundai Creta', 'code' => 'IFAR', 'bump' => 150],
                    '202' => ['name' => 'Mahindra XUV700', 'code' => 'SFAR', 'bump' => 400],
                ],
            ],
            '3' => [
                'name' => 'MPV',
                'base' => [1 => 5500, 2 => 5200, 3 => 5000, 4 => 4800, 5 => 4600, 6 => 4500, 7 => 4400],
                'vehicles' => [
                    '301' => ['name' => 'Toyota Innova Crysta', 'code' => 'FVAR', 'bump' => 200],
                ],
            ],
        ];

        $data = [];
        foreach ($groupDefs as $gid => $def) {
            $groupDates = [];
            foreach ($dates as $date) {
                $dayPrices = [];
                for ($day = 1; $day <= 31; $day++) {
                    $price = $def['base'][min($day, 7)] ?? 1800;
                    $dayPrices[(string) $day] = ['price' => (float) $price, 'id' => null, 'pid' => null];
                }
                $groupDates[$date] = $dayPrices;
            }

            $vehicles = [];
            foreach ($def['vehicles'] as $vid => $v) {
                $vDates = [];
                foreach ($dates as $date) {
                    $dayPrices = [];
                    for ($day = 1; $day <= 31; $day++) {
                        $price = ($def['base'][min($day, 7)] ?? 1800) + $v['bump'];
                        $dayPrices[(string) $day] = [
                            'price' => (float) $price,
                            'id' => null,
                            'pid' => null,
                            'source' => 'vehicle',
                        ];
                    }
                    $vDates[$date] = $dayPrices;
                }
                $vehicles[$vid] = [
                    'name' => $v['name'],
                    'code' => $v['code'],
                    'dates' => $vDates,
                ];
            }

            $data[$gid] = [
                'name' => $def['name'],
                'dates' => $groupDates,
                'vehicles' => $vehicles,
            ];
        }

        return [
            'status' => 'success',
            'dates' => $dates,
            'data' => $data,
        ];
    }

    public static function groups(): array
    {
        return [
            ['name' => 'Economy 2/3 Door (ECMR)', 'code' => 'ECMR', 'description' => 'Economy 2/3 door hatchback with manual AC', 'vehicles_count' => '14 Vehicles', 'status' => 'Active'],
            ['name' => 'Economy 4/5 Door (EDMR)', 'code' => 'EDMR', 'description' => 'Economy 4/5 door hatchback with manual AC', 'vehicles_count' => '22 Vehicles', 'status' => 'Active'],
            ['name' => 'Compact SUV (CDMR)', 'code' => 'CDMR', 'description' => 'Compact 4-door SUV with manual transmission', 'vehicles_count' => '18 Vehicles', 'status' => 'Active'],
            ['name' => 'Compact Automatic (CDAR)', 'code' => 'CDAR', 'description' => 'Compact 4-door vehicle with automatic AC', 'vehicles_count' => '15 Vehicles', 'status' => 'Active'],
            ['name' => 'Intermediate Sedan (IDAR)', 'code' => 'IDAR', 'description' => '4-Door Sedan Automatic with AC & Cruise Control', 'vehicles_count' => '25 Vehicles', 'status' => 'Active'],
            ['name' => 'Full Size MPV (FVAR)', 'code' => 'FVAR', 'description' => '7-Seater Passenger Van / MPV Automatic', 'vehicles_count' => '12 Vehicles', 'status' => 'Active'],
            ['name' => 'Premium Sedan (PDAR)', 'code' => 'PDAR', 'description' => 'Premium 4-door sedan with luxury leather seats', 'vehicles_count' => '9 Vehicles', 'status' => 'Active'],
            ['name' => 'Luxury SUV (XFAR)', 'code' => 'XFAR', 'description' => 'Premium Luxury SUV 4WD Automatic', 'vehicles_count' => '6 Vehicles', 'status' => 'Active'],
            ['name' => 'Standard Convertible (STAR)', 'code' => 'STAR', 'description' => 'Standard Convertible sports car automatic', 'vehicles_count' => '4 Vehicles', 'status' => 'Active'],
            ['name' => 'Mini Electric (MBER)', 'code' => 'MBER', 'description' => 'Mini 3-door electric city car automatic', 'vehicles_count' => '10 Vehicles', 'status' => 'Active'],
            ['name' => 'Standard Pickup 4WD (SPAR)', 'code' => 'SPAR', 'description' => 'Double-cab 4WD utility pickup truck', 'vehicles_count' => '8 Vehicles', 'status' => 'Active'],
            ['name' => 'Full Size SUV (FFAR)', 'code' => 'FFAR', 'description' => 'Full size 7-seater luxury SUV automatic', 'vehicles_count' => '16 Vehicles', 'status' => 'Active'],
            ['name' => 'Intermediate Wagon (IWAR)', 'code' => 'IWAR', 'description' => 'Intermediate 5-door station wagon', 'vehicles_count' => '7 Vehicles', 'status' => 'Inactive'],
            ['name' => 'Special Cargo Van (SKMR)', 'code' => 'SKMR', 'description' => 'Commercial cargo van with high roof', 'vehicles_count' => '11 Vehicles', 'status' => 'Active'],
            ['name' => 'Overnight Sleeper RV (SVAR)', 'code' => 'SVAR', 'description' => 'Campervan / Motorhome sleeper vehicle', 'vehicles_count' => '3 Vehicles', 'status' => 'Active'],
        ];
    }

    public static function branches(): array
    {
        return [
            ['name' => 'Main Branch - Delhi', 'code' => 'DEL-01', 'city' => 'Delhi', 'phone' => '+91 98765 43210', 'email' => 'delhi@rydaris.com', 'status' => 'Active'],
            ['name' => 'Airport Branch - Mumbai', 'code' => 'BOM-02', 'city' => 'Mumbai', 'phone' => '+91 98765 43211', 'email' => 'mumbai@rydaris.com', 'status' => 'Active'],
            ['name' => 'Udhana Branch - Surat', 'code' => 'ST-03', 'city' => 'Surat', 'phone' => '+91 98765 43212', 'email' => 'surat@rydaris.com', 'status' => 'Active'],
            ['name' => 'Central Branch - Ahmedabad', 'code' => 'AMD-04', 'city' => 'Ahmedabad', 'phone' => '+91 98765 43213', 'email' => 'ahmedabad@rydaris.com', 'status' => 'Active'],
            ['name' => 'Vesu Hub - Surat', 'code' => 'ST-05', 'city' => 'Surat', 'phone' => '+91 98765 43214', 'email' => 'vesu@rydaris.com', 'status' => 'Active'],
            ['name' => 'Connaught Place - Delhi', 'code' => 'DEL-06', 'city' => 'Delhi', 'phone' => '+91 98765 43215', 'email' => 'cp.delhi@rydaris.com', 'status' => 'Active'],
            ['name' => 'BKC Center - Mumbai', 'code' => 'BOM-07', 'city' => 'Mumbai', 'phone' => '+91 98765 43216', 'email' => 'bkc.mumbai@rydaris.com', 'status' => 'Active'],
            ['name' => 'MG Road Depot - Bengaluru', 'code' => 'BLR-08', 'city' => 'Bengaluru', 'phone' => '+91 98765 43217', 'email' => 'blr@rydaris.com', 'status' => 'Active'],
            ['name' => 'Hi-Tech City - Hyderabad', 'code' => 'HYD-09', 'city' => 'Hyderabad', 'phone' => '+91 98765 43218', 'email' => 'hyd@rydaris.com', 'status' => 'Active'],
            ['name' => 'Airport Counter - Goa', 'code' => 'GOA-10', 'city' => 'Goa', 'phone' => '+91 98765 43219', 'email' => 'goa@rydaris.com', 'status' => 'Active'],
        ];
    }
}
