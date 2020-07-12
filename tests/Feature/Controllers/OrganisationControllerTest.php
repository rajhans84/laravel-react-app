<?php

namespace Tests\Feature\Controllers;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class OrganisationControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testOrganisationsRouteReturnsAllOrgainisationsForAuthenticatedAdminUser()
    {
        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])->get('/organisations');

        $response->assertStatus(200);
    }

    public function testOrganisationsRouteRedirectsForUnAuthenticatedUser()
    {
        $response = $this->get('/organisations');

        $response->assertStatus(302);
    }

    public function testOrganisationsRouteDoesNotCreateOrgainisationForNonAdminUser()
    {

        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->withSession(['foo' => 'bar'])->json('POST', '/organisations', ['name' => 'testOrg', 'description' => 'Test Organisation']);

        $response->assertStatus(403);
    }

    public function testOrganisationsRouteCanCreateOrgainisationForAuthenticatedAdminUser()
    {
        $admin = factory(Admin::class)->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->withSession(['foo' => 'bar'])->json('POST', '/organisations', ['name' => 'testOrg', 'description' => 'Test Organisation']);

        $response->assertStatus(201);
    }
}
