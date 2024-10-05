<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Inertia\Inertia;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        // dd(vars: $users);

        return Inertia::render('Admin/Users/Index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();

        return Inertia::render('Admin/Users/Create', compact(['roles']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('1234'),
        ]);

        RoleUser::create([
            'role_id' => $request->role,
            'user_id' => $user->id
        ]);

        return to_route('admin.users.index')->with('success', 'User added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = User::whereId($user->id)->with('roles')->first();
        $roles = Role::get();

        return Inertia::render('Admin/Users/Edit', compact(['roles', 'user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // dd($request->all());

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
        ]);

        $roleUser = RoleUser::whereUserId($user->id)->first();

        $roleUser->update(['role_id' => $request->role]);

        // $user->roles()->sync([$request->role]);

        return to_route('admin.users.index')->with('success', 'User updated.');
    }

    public function delete(User $user)
    {
        return Inertia::render('Admin/Users/Delete', compact(['user']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('admin.users.index')->with('success', 'User deleted.');
    }
}
