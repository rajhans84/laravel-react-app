<?php

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a default user for testing
        factory(Admin::class)->create([
            'email' => 'admin@example.com',
        ]);

        factory(Admin::class, 10)->create();
        factory(Employee::class, 10)->create();
    }
}
