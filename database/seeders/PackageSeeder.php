<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Launch',
                'eyebrow' => 'Starter',
                'description' => 'For small operators formalizing day-to-day reservations and vehicle records.',
                'price' => '$79',
                'billing_period' => '/ month',
                'features' => [
                    'Up to 25 vehicles',
                    'Reservation calendar',
                    'Customer and agreement records',
                    'Basic invoices and deposits',
                    'Email support',
                ],
                'is_featured' => false,
                'button_text' => 'Start Launch',
                'order' => 1,
            ],
            [
                'name' => 'Growth',
                'eyebrow' => 'Most selected',
                'description' => 'For active rental teams managing higher booking volume and multiple staff roles.',
                'price' => '$189',
                'billing_period' => '/ month',
                'features' => [
                    'Up to 100 vehicles',
                    'Multi-branch availability',
                    'Inspection and maintenance logs',
                    'Revenue and utilization dashboards',
                    'Priority onboarding support',
                ],
                'is_featured' => true,
                'button_text' => 'Book Growth Demo',
                'order' => 2,
            ],
            [
                'name' => 'Growth Quarterly',
                'eyebrow' => 'Quarterly Value',
                'description' => 'For active rental teams looking for quarterly savings and fleet tracking.',
                'price' => '$499',
                'billing_period' => '/ quarter',
                'features' => [
                    'Up to 100 vehicles',
                    'Multi-branch availability',
                    'Inspection and maintenance logs',
                    'Revenue and utilization dashboards',
                    'Priority onboarding support',
                ],
                'is_featured' => false,
                'button_text' => 'Start Growth Quarterly',
                'order' => 4,
            ],
            [
                'name' => 'Enterprise',
                'eyebrow' => 'Scale',
                'description' => 'For regional fleets needing advanced permissions, integrations, and launch support.',
                'price' => 'Custom',
                'billing_period' => '',
                'features' => [
                    'border limit' => 'Unlimited',
                    'Unlimited fleet bands',
                    'Custom approval workflows',
                    'Accounting and API integrations',
                    'Dedicated success manager',
                    'Custom reports and data exports',
                ],
                'is_featured' => false,
                'button_text' => 'Talk to Sales',
                'order' => 5,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::create($pkg);
        }
    }
}
