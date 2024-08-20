<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rates')->insert([
            [
                'rates_for' => 'Regular Day',
                'regular' => 1,
                'overtime' => 1.25,
                'night_differential_rate' => 1.10,
                'night_differential_ot_rate' => 1.375,
            ],
            [
                'rates_for' => 'Rest Day',
                'regular' => 1.30,
                'overtime' => 1.69,
                'night_differential_rate' => 1.43,
                'night_differential_ot_rate' => 1.859,
            ],
            [
                'rates_for' => 'Special Holiday',
                'regular' => 1.30,
                'overtime' => 1.69,
                'night_differential_rate' => 1.43,
                'night_differential_ot_rate' => 1.859,
            ],
            [
                'rates_for' => 'Regular Holiday',
                'regular' => 2,
                'overtime' => 2.6,
                'night_differential_rate' => 2.2,
                'night_differential_ot_rate' => 2.86,
            ],
            [
                'rates_for' => 'Rest Day - Special Holiday',
                'regular' => 1.5,
                'overtime' => 1.95,
                'night_differential_rate' => 1.65,
                'night_differential_ot_rate' => 2.145,
            ],
            [
                'rates_for' => 'Rest Day - Regular Holiday',
                'regular' => 2.6,
                'overtime' => 3.38,
                'night_differential_rate' => 2.86,
                'night_differential_ot_rate' => 3.718,
            ],
            [
                'rates_for' => 'Double Regular Holiday',
                'regular' => 3,
                'overtime' => 3.9,
                'night_differential_rate' => 3.3,
                'night_differential_ot_rate' => 4.29,
            ],
            [
                'rates_for' => 'Rest Day - Double Regular Holiday',
                'regular' => 3.9,
                'overtime' => 5.07,
                'night_differential_rate' => 4.29,
                'night_differential_ot_rate' => 5.577,
            ],
            [
                'rates_for' => 'Regular Holiday, Special Holiday',
                'regular' => 2.6,
                'overtime' => 3.38,
                'night_differential_rate' => 2.86,
                'night_differential_ot_rate' => 3.718,
            ],
            [
                'rates_for' => 'Rest Day - Regular Holiday, Special Holiday',
                'regular' => 3,
                'overtime' => 3.9,
                'night_differential_rate' => 3.3,
                'night_differential_ot_rate' => 4.29,
            ],
            [
                'rates_for' => 'Paid Leave',
                'regular' => 1,
                'overtime' => 1,
                'night_differential_rate' => 1,
                'night_differential_ot_rate' => 1,
            ],
            [
                'rates_for' => 'Unpaid Leave',
                'regular' => 1,
                'overtime' => 1,
                'night_differential_rate' => 1,
                'night_differential_ot_rate' => 1,
            ],
            [
                'rates_for' => 'Absent',
                'regular' => 1,
                'overtime' => 1,
                'night_differential_rate' => 1,
                'night_differential_ot_rate' => 1,
            ],
            [
                'rates_for' => 'Undertime',
                'regular' => 1,
                'overtime' => 1,
                'night_differential_rate' => 1,
                'night_differential_ot_rate' => 1,
            ],
            
            // Add more records as needed
        ]);
    }
}
