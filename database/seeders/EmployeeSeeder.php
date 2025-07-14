<?php

namespace Database\Seeders;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;



class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Ambil semua divisions
        $divisions = Division::all();

        // Pastikan divisions sudah ada
        if ($divisions->isEmpty()) {
            $this->command->warn('No divisions found. Run DivisionSeeder first.');
            return;
        }

        // Dummy data Employee
        $employees = [
            ['name' => 'John Doe', 'phone' => '081111111111', 'position' => 'Senior Developer', 'email' => 'john.doe@example.com'],
            ['name' => 'Jane Smith', 'phone' => '082222222222', 'position' => 'QA Analyst', 'email' => 'jane.smith@example.com'],
            ['name' => 'Mike Johnson', 'phone' => '083333333333', 'position' => 'UI/UX Designer', 'email' => 'mike.johnson@example.com'],
            ['name' => 'Alice Brown', 'phone' => '084444444444', 'position' => 'Backend Developer', 'email' => 'alice.brown@example.com'],
            ['name' => 'Bob Taylor', 'phone' => '085555555555', 'position' => 'Frontend Developer', 'email' => 'bob.taylor@example.com'],
        ];

        foreach ($employees as $emp) {
            Employee::create([
                'name' => $emp['name'],
                'email' => $emp['email'],
                'phone' => $emp['phone'],
                'position' => $emp['position'],
                'division_id' => $divisions->random()->id,
                'image' => null, // bisa diupdate nanti saat upload
            ]);
        }
    }
}
