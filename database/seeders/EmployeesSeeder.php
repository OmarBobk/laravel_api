<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [];
        $fake = Factory::create();

        for ($i = 0; $i <= 50; $i++) {
            $employees[] = [
                'name' => $fake->name,
                'age' => $fake->numberBetween(20, 30),
                'job' => "JobName Number: " . $i+1,
                'salary' => $fake->numberBetween(2000, 5000),
            ];
        }

        $chunks = array_chunk($employees, 50);

        foreach($chunks as $chunk) {
            Employee::insert($chunk);
        }

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('123'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
