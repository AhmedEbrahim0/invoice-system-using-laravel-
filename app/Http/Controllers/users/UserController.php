<?php

namespace App\Http\Controllers\users;

use App\Models\User;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function index()
    {
        $users=User::all();
        return view("users.users")->with("users",$users);
    }

    public function create()
    {
        $permissions=Permission::all();
        $roles=Role::all();
        return view("users.create")
        ->with("roles",$roles)
        ->with("permissions",$permissions)
        ;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required",
            "email"=>"required",
            "password"=>"required",
            "role"=>"required",
            "permissions"=>"required",
            "status"=>"required",
        ],[
            "required"=>"هذا الحقل مطلوب",
        ]);
        $user=User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>hash::make($request->password),
            "Status"=>$request->status,
            "Role_name"=>$request->role,

        ]);
        $user->assignRole($request->role);
        $user->givePermissionTo($request->permissions);

        session()->flash("success","تم اضافه السمتخدم بنجاح");
        return back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $user=User::find($id);
        $permissions=Permission::all();
        $user_permissions = $user->getDirectPermissions();
        return view("users.edit")
        ->with("user",$user)
        ->with("user_permissions",$user_permissions)
        ->with("permissions",$permissions);
    }


    public function update(Request $request, $id)
    {
        $user=User::find($id);
        $user->givePermissionTo($request->get("permissions"));
        $user->update([
            "Status"=>$request->status,
        ]);
        session()->flash("success","تم حفظ التعديلات بنجااح");
        return back();
    }

    public function destroy($id)
    {
        $user=User::find($id);
        $user->delete();
        return back();
    }
    public function add_permission(){
        return view("users.permission");
    }
    public function export(){
        $export=App::make("excel");
        return  $export->download(new UsersExport,"users.xlsx");
    }
}
