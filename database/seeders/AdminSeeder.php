<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        DB::table('admin')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => password_hash('admin', PASSWORD_DEFAULT),
                'created_at' => time(),
                'updated_at' => time(),
            ],
        ]);
    }
}
