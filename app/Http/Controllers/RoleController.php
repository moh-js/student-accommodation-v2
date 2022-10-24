<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('role-view');

        return view('roles.index', [
            'roles' => Role::withTrashed()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('role-add');

        return view('roles.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('role-add');

        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name', 'max:50']
        ]);

        Role::firstOrCreate([
            'name' => $request->input('name'),
            'guard_name' => 'web'
        ]);

        toastr()->success('role created successfully');
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $this->authorize('role-grant-permission');

        $permissions = Permission::query()->get();
        $permissions = $permissions
        ->groupBy(function ($item) {
            return str_before($item['name'], '-', 0);
        })->sortKeys();

        return view('roles.permissions', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function grantPermission(Request $request, Role $role)
    {
        $this->authorize('role-grant-permission');

        $permissions = $request->except('_token');
        
        $role->syncPermissions($permissions);

        toastr()->success('Permissions granted successfully');
        return redirect()->route('roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $this->authorize('role-update');

        return view('roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('role-update');

        $request->validate([
            'name' => ['required', 'string', "unique:roles,name,$role->id,id", 'max:50']
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        toastr()->success('role updated successfully');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Role $role)
    {
        if ($role->trashed()) {
            $this->authorize('role-activate');
            $role->restore();
            $action = 'restored';
        } else {
            $this->authorize('role-deactivate');
            $role->delete();
            $action = 'deleted';
        }

        toastr()->success("group $action successfully");
        return redirect()->route('roles.index');
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroyPermanently(Role $role)
    {
        $this->authorize('role-delete');
        $role->delete();

        toastr()->success("group removed permanently successfully");
        return redirect()->route('roles.index');
    }
}
