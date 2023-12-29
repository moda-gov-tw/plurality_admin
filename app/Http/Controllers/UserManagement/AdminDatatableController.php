<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUser as User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;

class AdminDatatableController extends Controller
{

    /**
     * 對應datatables 欄位
     *
     * @var array
     */
    public $datatable_head = [
        'name',
        'role',
        'created_at',
        'actions',
    ];

    /**
     * reload datatable content
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRow(Request $request)
    {

        $user = User::find($request->user_id);

        return view('partials.tables.user-management._admin_json',['user'=>$user])->render();
        
    }

    /**
     * get admin users : ajax usage
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function adminUsers(Request $request)
    {   
        // DB::enableQueryLog();

        // get current authenticated user
        $user = Auth::user();
        $user_table_name = Auth::user()->getTable();
        // Log::info($request);

        $return = array();
        $return['data'] = array();
        
        // $all_admin_user_count = count(User::whereNotNull('email_verified_at')->get());//不顯示尚未豋入的註冊者
        $all_admin_user_count = count(User::get());//會一併顯示尚未豋入的註冊者
        $all_admin_user_filtered_count = $all_admin_user_count;

        if($this->datatable_head[$request->order[0]['column']] != 'role'){
            $order_by = $user_table_name.'.'.$this->datatable_head[$request->order[0]['column']];
        }
        else{
            $order_by = 'roles.id';
        }

        if($request->length == '-1'){// tabletable length : show all
            $limit = $all_admin_user_count;
        }
        else{
            $limit = $request->length;
        }

        if(is_null($request->search['value'])){

            $all_admin_user = User::select(array('*',$user_table_name.'.id as id','roles.name as roles_name',$user_table_name.'.name as name',$user_table_name.'.created_at as created_at'))
                // ->whereNotNull('email_verified_at')
                ->leftJoin('model_has_roles', function ($join) {
                    $join->on('model_has_roles.model_id', '=', Auth::user()->getTable().'.id')->where('model_has_roles.model_type', '=', 'App\Models\AdminUser');
                })
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->orderBy($order_by,$request->order[0]['dir'])
                ->offset($request->start)
                ->limit($limit)->get();

            
        }
        else{ // for search purposes

            $search_value = $request->search['value'];
            $all_admin_user = User::select(array('*',$user_table_name.'.id as id','roles.name as roles_name',$user_table_name.'.name as name',$user_table_name.'.created_at as created_at'))
                ->leftJoin('model_has_roles', function ($join) {
                        $join->on('model_has_roles.model_id', '=', Auth::user()->getTable().'.id')->where('model_has_roles.model_type', '=', 'App\Models\AdminUser');
                    })
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->orderBy($order_by,$request->order[0]['dir'])
                // ->whereNotNull('email_verified_at')->offset($request->start)->limit($limit)
                ->where(function ($all_admin_user) use ($search_value) {
                    $all_admin_user->where(Auth::user()->getTable().'.name', 'LIKE', '%'.$search_value.'%')
                    ->orwhere(Auth::user()->getTable().'.email', 'LIKE', '%'.$search_value.'%')
                    ->orwhere(Auth::user()->getTable().'.created_at', 'LIKE', '%'.$search_value.'%');
                })
                ->get();

            $all_admin_user_filtered_count = count($all_admin_user);
        }
        

        
        // Log::info(DB::getQueryLog());
        
        $locale = App::currentLocale();
        foreach($all_admin_user as $key => $user){
            foreach($this->datatable_head as $head_key => $head){

                if($head == 'actions'){
                    $return['data'][$key][$head] = view('partials/tables/user-management/_admin_table_'.$head,['user'=>$user,'row_id'=>$key])->render();;
                }
                else{
                    $return['data'][$key][$head] = view('partials/tables/user-management/_admin_table_'.$head,['user'=>$user,'locale'=>$locale])->render();
                }
            }

        }

        if(isset($request->draw)){
            $return['draw'] = $request->draw;
        }
        else $return['draw'] = 1;

        $return['recordsTotal'] = $all_admin_user_count;
        $return['recordsFiltered'] = $all_admin_user_filtered_count;

        // $return['recordsTotal'] = 0;
        // $return['recordsFiltered'] = 0;
        // $return['data'] = array();

        return json_encode($return);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
