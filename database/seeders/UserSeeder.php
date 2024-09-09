<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Admin 1', 'email' => 'admin@freshmoe.com', 'phone' => '+95942350858', 'is_admin' => 1, 'password' => Hash::make('admin')],
            [
                'customized_number' => 'FMUN-1718875574',
                'name' => 'Kham En Khai',
                'phone' => '+959422138010',
                'email' => 'testing@freshmoe.com',
                'password' => Hash::make('password'),
                'gender' => 'male',
                'address' => 'north dagon', // Assuming 'address' is the key for the user's address
            ]
        ];
        foreach ($data as $value) {
            User::updateOrCreate($value);
        }
    }
}
