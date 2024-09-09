<?php

namespace Database\Seeders;

use App\Models\Medal;
use Illuminate\Database\Seeder;

class MedalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['language_id' => 1, 'name' => 'Standard'],
            ['language_id' => 1, 'name' => 'Bronze'],
            ['language_id' => 1, 'name' => 'Silver'],
            ['language_id' => 1, 'name' => 'Gold'],
            ['language_id' => 1, 'name' => 'Platinum'],
        ];
        foreach ($data as $value) {
            Medal::updateOrCreate($value);
        }
    }
}
