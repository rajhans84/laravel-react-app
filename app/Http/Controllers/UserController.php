<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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

    /**
     * Get list of all users.
     *
     * @return void
     */
    public function index(User $user)
    {
        if ($user->id) {
            return $user;
        }
        $admin = Admin::all()->first();
        $this->authorize('view', $admin);
        return User::all();
    }

    /**
     * Store a new admin or employee into database depending upon the is_admin value.
     *
     * @param  Request  $request
     * @return \App\Models\Admin
     */
    protected function store(Request $request, Admin $admin, Employee $employee)
    {
        $validation = Validator::make($request->input(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validation->fails()) {
            return (new Response($validation->errors(), 422));
        } else {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            if ($request->is_admin == 1) {
                $this->authorize('create', $admin);
                $createdUser =  Admin::create($userData);
            } else {
                $this->authorize('create', $employee);
                $createdUser =  Employee::create($userData);
            }

            return (new Response($createdUser, 201));
        }
    }

    /**
     * Update an existing user with supplied data.
     *
     * @param  Request  $request
     * @param  Admin  $admin
     * @param  Employee  $employee
     * @return \App\Models\User
     */
    protected function update(Request $request, User $user)
    {
        $validation = Validator::make($request->input(), [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
        ]);
        if ($validation->fails()) {
            return (new Response($validation->errors(), 422));
        } else {
            $userData = $request->input();
            if ($user->is_admin) {
                $admin = Admin::find($user->id);
                $this->authorize('update', $admin);
                return $admin->fill($userData)->save();
            }
            $employee = Employee::find($user->id);
            $this->authorize('update', $employee);
            return $employee->fill($userData)->save();
        }
    }

    /**
     * Update an existing user with supplied data.
     *
     * @param  Request  $request
     * @param  Admin  $admin
     * @param  Employee  $employee
     * @return \App\Models\User
     */
    protected function delete(Request $request, User $user)
    {
        if ($user->is_admin) {
            $admin = Admin::find($user->id);
            $this->authorize('delete', $admin);
            return $admin->delete();
        }
        $employee = Employee::find($user->id);
        $this->authorize('delete', $employee);
        return $employee->delete();
    }
}
