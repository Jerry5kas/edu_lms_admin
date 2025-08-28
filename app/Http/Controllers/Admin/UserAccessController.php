<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users.edit');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get()->groupBy(function ($p) {
            return explode('.', $p->name)[0] ?? 'other';
        });

        $userRoles = $user->roles->pluck('name')->toArray();
        $userDirectPermissions = $user->getDirectPermissions()->pluck('name')->toArray();

        return view('admin.users.access', compact(
            'user', 'roles', 'permissions', 'userRoles', 'userDirectPermissions'
        ));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'roles' => ['array'],
            'roles.*' => ['string','exists:roles,name'],
            'permissions' => ['array'],
            'permissions.*' => ['string','exists:permissions,name'],
        ]);

        $user->syncRoles($data['roles'] ?? []);
        $user->syncPermissions($data['permissions'] ?? []);

        return redirect()->route('admin.users.access.edit', $user)
            ->with('success', 'User access updated successfully.');
    }
}
