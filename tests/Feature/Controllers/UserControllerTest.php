<?php

namespace Tests\Feature\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserControllerTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminCanGetUserById()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])->get('/users');

        $response->assertStatus(200);
    }

    public function testAdminCanSeeEmployeesAndAdmins()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])->get('/users');

        $response->assertStatus(200);

        $data = new Collection($response->getData());

        $this->assertTrue($data->contains('is_admin', true));
        $this->assertTrue($data->contains('is_admin', false));
    }

    public function testEmployeeCannotSeeOtherEmployeesAndAdmins()
    {
        // $this->withoutExceptionHandling();
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->withSession(['foo' => 'bar'])->get('/users');

        $response->assertStatus(403);
    }

    public function testAdminCanCreateEmployeesForValidData()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('POST', '/users', [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

        $response->assertStatus(201);
    }

    public function testAdminCannotCreateEmployeesForInvalidData()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('POST', '/users', [
                'name' => 'q',
                'email' => '',
                'remember_token' => Str::random(10),
            ]);

        $response->assertStatus(422);
    }

    public function testAdminCanCreateAdminsForValidData()
    {
        $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('POST', '/users', [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'is_admin' => true,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]);

        $response->assertStatus(201);
    }

    public function testAdminCanUpdateEmployees()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);
        $employee = Employee::first();
        $employeeId = $employee->id;
        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('POST', "/users/$employeeId", [
                'name' => 'Test Employee',
                'email' => $this->faker->unique()->safeEmail,
            ]);

        $response->assertStatus(200);
    }

    public function testAdminCanUpdateHimself()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);
        $adminId = $admin->id;
        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('POST', "/users/$adminId", [
                'name' => 'Test Update',
                'email' => $this->faker->unique()->safeEmail,
            ]);

        $response->assertStatus(200);
    }

    public function testAdminCannotUpdateOtherAdmins()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $otherAdmin = Admin::first();
        $otherAdminId = $otherAdmin->id;

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('POST', "/users/$otherAdminId", [
                'name' => 'Test Update',
                'email' => $this->faker->unique()->safeEmail,
            ]);

        $response->assertStatus(403);
    }

    public function testAdminCannotDeleteHimself()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);
        $adminId = $admin->id;
        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('DELETE', "/users/$adminId");

        $response->assertStatus(403);
    }

    public function testAdminCannotDeleteOtherAdmins()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $otherAdmin = Admin::first();
        $otherAdminId = $otherAdmin->id;

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('DELETE', "/users/$otherAdminId");

        $response->assertStatus(403);
    }

    public function testAdminCanDeleteEmployees()
    {
        // $this->withoutExceptionHandling();
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $employee = Employee::first();
        $employeeId = $employee->id;

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])
            ->json('DELETE', "/users/$employeeId");

        $response->assertStatus(200);
    }
}
