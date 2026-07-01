<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            // Product Basics
            [
                'category' => 'product_basics',
                'title' => 'Can Rydaris handle multiple rental branches?',
                'description' => 'Yes. You can manage branch-level availability, staff permissions, transfers, pickups, returns, and reports from one system.',
            ],
            [
                'category' => 'product_basics',
                'title' => 'Does it support vehicle classes and rate plans?',
                'description' => 'Yes. You can organize vehicles by class, set rate plans, track add-ons, and manage pricing by branch or customer account.',
            ],
            [
                'category' => 'product_basics',
                'title' => 'Can teams manage booking extensions?',
                'description' => 'Yes. Extensions can update dates, rates, charges, vehicle status, customer balances, and expected return reports.',
            ],
            [
                'category' => 'product_basics',
                'title' => 'Does Rydaris include inspection records?',
                'description' => 'Pickup and return inspections can record mileage, fuel, damage notes, service flags, and supporting images or documents.',
            ],

            // Onboarding
            [
                'category' => 'onboarding',
                'title' => 'Can you migrate our current data?',
                'description' => 'Yes. Onboarding can include vehicle records, customer lists, rates, branch setup, active rentals, and historical balance data when available.',
            ],
            [
                'category' => 'onboarding',
                'title' => 'How long does implementation take?',
                'description' => 'Smaller teams can launch quickly. Larger fleets usually need workflow review, data cleanup, staff training, and a staged rollout plan.',
            ],
            [
                'category' => 'onboarding',
                'title' => 'Do staff need technical training?',
                'description' => 'No deep technical knowledge is required. Rydaris is structured around rental actions: reserve, dispatch, inspect, invoice, return, and report.',
            ],
            [
                'category' => 'onboarding',
                'title' => 'Can we keep our existing processes?',
                'description' => 'Most teams keep their core operating rules while replacing manual tracking with cleaner screens, permissions, and reporting.',
            ],

            // Reporting
            [
                'category' => 'reporting',
                'title' => 'What reports are included?',
                'description' => 'Reports can include utilization, revenue, deposits, unpaid balances, booking sources, branch performance, maintenance activity, late returns, and vehicle profitability.',
            ],
            [
                'category' => 'reporting',
                'title' => 'Can Rydaris manage deposits and refunds?',
                'description' => 'Yes. Deposit collection, partial adjustments, extra charges, refunds, and outstanding balances can be tracked against each agreement.',
            ],
            [
                'category' => 'reporting',
                'title' => 'Does it integrate with accounting tools?',
                'description' => 'Integration options depend on the plan and accounting system. Enterprise customers can discuss custom API or export workflows.',
            ],
            [
                'category' => 'reporting',
                'title' => 'How are user permissions handled?',
                'description' => 'Roles can separate front desk, branch manager, finance, fleet coordinator, administrator, and reporting access.',
            ],
            [
                'category' => 'reporting',
                'title' => 'Is Rydaris suitable for long-term rentals?',
                'description' => 'Yes. The system supports longer agreements, recurring customer accounts, extensions, scheduled invoices, and vehicle status tracking over time.',
            ],
            [
                'category' => 'reporting',
                'title' => 'What support is available?',
                'description' => 'Support depends on plan level, from email support to guided onboarding, launch support, priority help, and dedicated success management.',
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
