<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserManagement\StoreUserFormRequest;
use App\Models\AdminUser as User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.user-management.admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $locale = App::currentLocale();
        $all_roles = Role::all();
        //merge not assigned role
        $not_assigned = new Role();
        $not_assigned->name = 'not_assigned';
        $not_assigned->id = ''; 
        $all_roles[] = $not_assigned;
        return view('pages.user-management.create',['all_roles'=>$all_roles, 'locale'=>$locale]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserFormRequest $request)
    {
       $params = array();
       $params['name'] = $request->name;
       $params['email'] = $request->email;
       $params['email_verified_at'] = now();
       $params['password'] = Hash::make($request->password);
       $params['api_token'] = Hash::make($request->email);


        if($user = User::create($params)){
            $user->syncRoles($request->role);
            return redirect()->route('user-management.admin-list')->with('user_create_message', 'success');
        }
        else{
            return redirect()->route('user-management.admin-list')->with('user_create_message', 'failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try
        {
            $user = User::find($request->id)->delete();

            if ($user) {
                return response()->json(['success' => true], 200);
            }
            else{
                return response()->json(['success' => false,'errors' => trans('views_product.delete_error')], 200);   
            }
            
        }
        catch(Exception $e)
        {
            return response()->json([
                'success' => false,
                'errors'  => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get specified user role by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserRole(Request $request){

        $user = User::find($request->user_id);
        $locale = App::currentLocale();
        $current_role = json_decode($user->roles->pluck('name'));

        $all_roles = Role::all();

        //merge not assigned role
        $not_assigned = new Role();
        $not_assigned->name = 'not_assigned';
        $not_assigned->id = ''; 
        $all_roles[] = $not_assigned;

        if(empty($current_role)){
            $current_role = '';
        }
        else $current_role = $current_role[0];

        $return = array();
        $return['modelContent'] = view('partials.modals.user-management._change_admin_user_role',['user'=>$user,'current_role'=>$current_role,'all_roles'=>$all_roles,'locale'=>$locale])->render();

        return json_encode($return);
    }

    /**
     * Get specified user for confirming deletion
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmUserDelete(Request $request){
        $user = User::find($request->user_id);


        return view('partials.modals.user-management._change_admin_user_role',['user'=>$user]);
    }

    /**
     * update specified user role by id
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateUserRole(Request $request){

        $user = User::find($request->user_id);

        if($request->role == 'not_assigned'){
            $user->syncRoles([]);
        }
        else{
            $user->syncRoles($request->role);
        }
        

        

        return json_encode(array('message'=>trans('user-management.update_success')));
    }

    public function adminUser($id)
    {   
        $return = array();
        $user = User::find($id);

        $return['message'] = trans('user-management.are_you_sure_to_delete');
        $return['button_text'] = trans('user-management.confirm_delete_user');
        $return['cancel_button_text'] = trans('user-management.cancel_delete_user');
        $return['user_name'] = '<div><b>'.$user->name.'</b></div>';
        $return['user_id'] = $user->id;
        return json_encode($return);
    }
}
