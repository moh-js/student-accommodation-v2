<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('user-view');

        return view('users.index', [
            'users' => User::getUsers()
        ]);
    }

    public function create()
    {
        $this->authorize('user-add');

        return view('users.add', [
            'groups' => Role::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('user-add');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
        ]);

        User::firstOrCreate($request->except(['groups', '_token']))->syncRoles($request->groups);

        toastr()->success('User added successfully');
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('user-update');

        return view('users.edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('user-update');

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,$user->id,id"],
        ]);

        $user->update($request->except(['groups', '_token']));
        $user->syncRoles($request->groups);

        toastr()->success('User updated successfully');
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->trashed()) {
            $this->authorize('user-activate');
            $user->restore();
            $action = 'restored';
        } else {
            $this->authorize('user-deactivate');
            $user->delete();
            $action = 'deleted';
        }

        toastr()->success("User $action successfully");
        return redirect()->route('users.index');
    }


    // public function getUsername($user_id = null)
    // {
    //     $username = strtolower(substr(request('first_name'), 0, 1).request('last_name'));

    //     $userFound = User::where([['username', $username], ['id', '!=', $user_id]])->count();

    //     if ($userFound) {
    //         $username = $username.'-'.rand(50);
    //     }

    //     return $username;
    // }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'old_password' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, request()->user()->password)) {
                    $fail('The '.str_replace('_', ' ', $attribute).' incorrect .');
                }
            }]
        ]);

        request()->user()->update([
            'password' => bcrypt($request->password)
        ]);

        toastr()->success('Password updated successfully');
        return back();
    }
}
