<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Skip if courses already exist
        if (Course::count() > 0) {
            return;
        }

        collect([
            ["Bachelor of Science in Accountancy", "BSA"],
            ["Bachelor of Secondary Education - Math", "BSED Math"],
            ["Bachelor of Secondary Education - Science", "BSED Science"],
            ["Bachelor of Secondary Education - English", "BSED English"],
            ["Bachelor of Secondary Education - Social Studies", "BSED SocStud"],
            ["Bachelor of Early Childhood Education", "BECED"],
            ["Bachelor of Science in Social Work", "BSSW"],
            ["Bachelor Arts in Communication", "BAC"],
            ["Bachelor of Science in Public Administration", "BSPA"],
            ["Bachelor of Science in Psychology", "BSP"],
            ["BSBA - Financial Management", "BSBA FM"],
            ["BSBA - Marketing Management", "BSBA MM"],
            ["BSBA - Human Resource Development Management", "BSBA HRDM"],
            ["Bachelor of Science in Information Technology", "BSIT"],
            ["Bachelor of Science in Civil Engineering", "BSCE"],
            ["Bachelor of Science in Electrical Engineering", "BSEE"]
        ])->each(function ($course) {
            Course::create([
                'name' => $course[0],
                'abbreviation' => $course[1]
            ]);
        });
    }
}
