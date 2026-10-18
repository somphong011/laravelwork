<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้างหมวดหมู่งานซ่อมเริ่มต้น
        $categories = ['ระบบไฟฟ้า', 'ระบบประปา', 'เครื่องปรับอากาศ', 'ครุภัณฑ์/เฟอร์นิเจอร์', 'งานโครงสร้าง/อาคาร'];
        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat]);
        }

        // 2. สร้างบัญชีผู้ใช้ 3 บทบาท
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => UserRole::ADMIN,
            ]
        );

        User::firstOrCreate(
            ['email' => 'tradesman@example.com'],
            [
                'name' => 'Tradesman Technician',
                'password' => Hash::make('password'),
                'role' => UserRole::TRADESMAN,
            ]
        );

        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'General User',
                'password' => Hash::make('password'),
                'role' => UserRole::USER,
            ]
        );
    }
}
