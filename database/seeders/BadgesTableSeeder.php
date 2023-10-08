<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            ['name' => 'Beginner', 'value'     => 0, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Intermediate', 'value' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Advanced', 'value'     => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Master', 'value'       => 10, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Insert the badge data into the 'badges' table
        Badge::insert($badges);
    }
}
