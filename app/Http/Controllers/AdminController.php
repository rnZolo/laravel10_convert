<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Inertia\Inertia;

// models
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     function index()
    {
        return Inertia::render('Admin/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return back();
    }

    /**
     * Store a newly created resource in storage.
     */
    // StoreAdminRequest $request
    public function store()
    {
        // create permissions
        Permission::create(['name' => 'view students']);
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);
        Permission::create(['name' => 'add students']);

        // create roles and assign existing permissions
        // $permissions = ['view students', 'edit student', 'delete student', 'delete multiple student'];
        $admin_permission = ['view students', 'edit student', 'delete student', 'delete multiple student','add students'];
        $sub_admin_permission = ['view students', 'edit student', 'delete student','add students'];
        $student_permission = ['view students', 'edit student',];
        Role::create(['name' => 'student'])->syncPermissions($student_permission);

        // $role1 = Role::create(['name' => 'student'])->givePermissionTo('view students');
        // $role2 = Role::create(['name' => 'admin'])->givePermissionTo('view students');
        // $role2->givePermissionTo('edit students');
        // $role2->givePermissionTo('add students');
        // $role3 = Role::create(['name' => 'Super-Admin']);
        // $role3->givePermissionTo('view students');
        // $role3->givePermissionTo('edit students');
        // $role3->givePermissionTo('delete students');
        // $role3->givePermissionTo('add students');

        // create demo users
        // User::create([
        //     'name' => 'viewer',
        //     'email' => 'viewer@example.com',
        //     'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        // ])->assignRole($role1);
        // User::create([
        //     'name' => 'admin',
        //     'email' => 'admin@example.com',
        //     'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        // ])->assignRole($role2);
        // User::create([
        //     'name' => 'superadmin',
        //     'email' => 'superadmin@example.com',
        //     'password' => '$2y$10$7WZW2WGa9AjA367wZvQ4y.miBvC78jo5MgtKhdbVScxnIXCsTTnoq'
        // ])->assignRole($role3);

        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit articles']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
