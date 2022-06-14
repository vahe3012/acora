<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        {
            User::truncate();
            if (config('admin.admin_name')) {
                User::firstOrCreate(
                    ['email' => config('admin.admin_email')], [
                        'name' => config('admin.admin_name'),
                        'password' => Hash::make(config('admin.admin_password')),
                    ]
                );
            }
        }
    }
}
