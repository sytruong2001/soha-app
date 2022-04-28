<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supAdmin = User::create(
        [
            'name' => 'Trương Văn Sỹ',
            'email' => 'vanyyy2001@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);
        $supAdmin2 = User::create([
            'name' => 'Đặng Quang Đức',
            'email' => 'dangquangduc99@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);
        $supAdmin->assignRole('sup admin', 'admin', 'user');
        $supAdmin2->assignRole('sup admin', 'admin', 'user');

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('admin', 'user');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
        ]);
        $user->assignRole('user');
    }
}
