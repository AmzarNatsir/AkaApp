<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
        // $this->middleware('permission:create-role', ['only' => ['create','store']]);
        // $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
        // $this->middleware('permission:delete-role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('roles.index', [
            'roles' => Role::orderBy('id','DESC')->paginate(3)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('roles.create', [
            'permissions' => Permission::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request);
        $role = Role::findOrCreate($request->name);
        $menuSelect = $request->has('menu') ? $request->menu : [];
        foreach ($menuSelect as $mn) {
            $result_permission = Permission::where('name', $mn)->get();

            if($result_permission->count() == 0)
            {
                $permission = Permission::create(['name' => $mn]);
                $role->givePermissionTo($permission);
            } else {
                foreach ($result_permission as $key => $val) {
                    $id_permission = $val['id'];
                }
                $role->givePermissionTo($id_permission);
            }
        }

        // $role = Role::create(['name' => $request->name]);

        // $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();

        // $role->syncPermissions($permissions);

        return redirect()->route('roles.index')
                ->withSuccess('New role is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): View
    {
        $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")
            ->where("role_id",$role->id)
            ->select('name')
            ->get();
        return view('roles.show', [
            'role' => $role,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
        }

        $rolePermissions = DB::table("role_has_permissions")
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where("role_has_permissions.role_id",$role->id)
            ->pluck('permissions.name')
            ->all();

        return view('roles.edit', [
            'role' => $role,
            'permissions' => Permission::get(),
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        $input = $request->only('name');
        $role->update($input);
        //menghapus data sebelumnya
        $role->syncPermissions([]);
        // Ambil input menu
        $menuSelect = $request->input('menu', []);
        // Loop dan assign permission
        $permissions = [];
        foreach ($menuSelect as $mn) {
            $permission = Permission::firstOrCreate(['name' => $mn]);
            $permissions[] = $permission;
        }
        // Sinkronisasi permission baru
        $role->syncPermissions($permissions);
        return redirect()->back()
                ->withSuccess('Role is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role): RedirectResponse
    {
        if($role->name=='Super Admin'){
            abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
        }
        if(auth()->user()->hasRole($role->name)){
            abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
        }
        $role->delete();
        return redirect()->route('roles.index')
                ->withSuccess('Role is deleted successfully.');
    }
}
