<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Organisation;

class OrganisationController extends Controller
{
    /**
     * Create a new authenticated controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Organisation $organisation)
    {
        // dd($organisation);
        if ($organisation->id) {
            return $organisation;
        }
        $this->authorize('view', $organisation);
        return Organisation::all();
    }

    /**
     * Store a new organisation into database.
     *
     * @param  array  $request
     * @return \App\Models\Organisation
     */
    protected function store(Request $request, Organisation $organisation)
    {
        $this->authorize('create', $organisation);
        return Organisation::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * Update an existing organisation with supplied data.
     *
     * @param  array  $request
     * @return \App\Models\Organisation
     */
    protected function update(Request $request, Organisation $organisation)
    {
        $this->authorize('update', $organisation);
        $organisation->fill($request->input());
        return $organisation->save();
    }

    /**
     * Delete an existing organisation with supplied data.
     *
     * @param  Request  $request
     * @param  Organisation $organisation
     * @return \App\Models\User
     */
    protected function delete(Request $request, Organisation $organisation)
    {
        $this->authorize('delete', $organisation);
        return $organisation->delete();
    }
}
