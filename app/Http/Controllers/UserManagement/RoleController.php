<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $role_permissions = Role::with('permissions')->get();
        $locale = App::currentLocale();
        return view('pages.role.settings',compact('role_permissions','locale'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $all_permissions = Permission::all();
        $role = Role::findById($id);
        
        return view('pages.role.edit',['role'=>$role]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editPermission($id)
    {   
        $all_permissions = Permission::all();
        $role = Role::findById($id);
        $allowed_permissions = config('global.general.permissions');
        
        $locale = App::currentLocale();

        return view('pages.role.edit_permission',compact('role','allowed_permissions','all_permissions','locale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePermission(request $request)
    {
        
        $role = Role::findById($request->role_id);
        $role->syncPermissions($request->permissions);

        
        return redirect()->route('role.roles')->with('role_update_message', 'role.update.success');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(request $request)
    {

        $request->validate([
            'en' => 'required|regex:/^[ +\w-]*$/|string|max:255|unique:roles,name,'.$request->role_id,
            'zh_TW'  => 'required|string|max:255|unique:roles,chinese_name,'.$request->role_id,
        ]);

        $role = Role::findById($request->role_id)->update(['name'=>$request->en,'chinese_name'=>$request->zh_TW]);
        
        /** Activity Log START **/
            activity()->causedBy(Auth::user())->withProperty('action','user.edit_role')->log(trans('activity_log.user_edit_role'));
        /** Activity Log END **/
        
        return redirect()->route('role.roles')->with('role_update_message', 'role.update.success');

    }


    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.role.create');
    }

    /**
     * Create role
     *
     * @return Json
     */
    public function createRole(Request $request){
        // echo "<pre>";print_r($request->all());echo "</pre>";exit;
        $request->validate([
            'en' => 'required|regex:/^[ +\w-]*$/|string|max:255|unique:roles,name',
            'zh_TW'  => 'required|string|max:255',
        ]);
        $user = Auth::user();

        $role = Role::create([
            'name' => $request->en,
            'chinese_name' => $request->zh_TW,
        ]);

        /** Activity Log START **/
            activity()->causedBy($user)->withProperty('action','user.create_new_role')->log(trans('activity_log.user_create_new_role'));
        /** Activity Log END **/
        
        return json_encode(array('message'=>trans('views_role.create_success')));

    }
}
