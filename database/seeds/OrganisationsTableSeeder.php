<?php

use App\Models\Organisation;
use Illuminate\Database\Seeder;

class OrganisationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // TODO: Create Organisations
        factory(Organisation::class, 20)->create();
    }
}
