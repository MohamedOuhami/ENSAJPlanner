<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'telephone'      => '0707705313',
                'remember_token' => null,
            ],
            [
                'id'             => 2,
                'name'           => 'Teacher',
                'email'          => 'teacher@teacher.com',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'telephone'      => '0707705313',
                'remember_token' => null,
            ],
            [
                'id'             => 3,
                'name'           => 'Teacher 2',
                'email'          => 'teacher2@teacher2.com',
                'telephone'      => '0707705313',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
            ],
            [
                'id'             => 4,
                'name'           => 'Teacher 3',
                'email'          => 'teacher3@teacher3.com',
                'telephone'      => '0707705313',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
            ],
            [
                'id'             => 5,
                'name'           => 'Teacher 4',
                'email'          => 'teacher4@teacher4.com',
                'telephone'      => '0707705313',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
            ],
            [
                'id'             => 6,
                'name'           => 'Teacher 5',
                'email'          => 'teacher5@teacher5.com',
                'telephone'      => '0707705313',
                'password'       => '$2y$10$HvSDJRBDVWwRd18qj5oaQOF0DBXqnZcyFJ4dJA8hcQGAfmyZ7xkei',
                'remember_token' => null,
            ],
        ];

        User::insert($users);
        // Inserting random students

        // Create a new instance of Faker library
        $faker = FakerFactory::create();

        // Generate random data for 100 users
        for ($i = 0; $i < 150; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make($faker->password),
                'telephone' => $faker->phoneNumber,
                'Semester' => 'S1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 100; $i++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make($faker->password),
                'telephone' => $faker->phoneNumber,
                'Semester' => 'S3',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
