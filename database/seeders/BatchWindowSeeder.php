<?php

namespace Database\Seeders;

use App\Models\BatchWindow;
use Illuminate\Database\Seeder;

class BatchWindowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batchWindows = [
            [
                'name' => 'Morning Batch',
                'cutoff_time' => '09:00:00',
                'fulfillment_start_time' => '09:30:00',
                'fulfillment_end_time' => '10:30:00',
                'timezone' => 'Africa/Lagos',
                'capacity_limit' => 20,
                'status' => 'active',
            ],
            [
                'name' => 'Afternoon Batch',
                'cutoff_time' => '15:00:00',
                'fulfillment_start_time' => '15:30:00',
                'fulfillment_end_time' => '16:30:00',
                'timezone' => 'Africa/Lagos',
                'capacity_limit' => 20,
                'status' => 'active',
            ],
            [
                'name' => 'Evening Batch',
                'cutoff_time' => '19:00:00',
                'fulfillment_start_time' => '19:30:00',
                'fulfillment_end_time' => '20:30:00',
                'timezone' => 'Africa/Lagos',
                'capacity_limit' => 10,
                'status' => 'active',
            ],
            [
                'name' => 'Emergency Batch',
                'cutoff_time' => '21:00:00',
                'fulfillment_start_time' => '21:15:00',
                'fulfillment_end_time' => '21:45:00',
                'timezone' => 'Africa/Lagos',
                'capacity_limit' => 5,
                'status' => 'inactive',
            ],
        ];

        foreach ($batchWindows as $batchWindow) {
            BatchWindow::updateOrCreate(
                ['name' => $batchWindow['name']],
                [
                    'cutoff_time' => $batchWindow['cutoff_time'],
                    'fulfillment_start_time' => $batchWindow['fulfillment_start_time'],
                    'fulfillment_end_time' => $batchWindow['fulfillment_end_time'],
                    'timezone' => $batchWindow['timezone'],
                    'capacity_limit' => $batchWindow['capacity_limit'],
                    'status' => $batchWindow['status'],
                ]
            );
        }
    }
}