<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'English'],
            ['name' => 'Myanmar'],
        ];
        foreach ($data as $value) {
            Language::updateOrCreate($value);
        }
    }
}
