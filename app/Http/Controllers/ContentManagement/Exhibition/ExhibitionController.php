<?php

namespace App\Http\Controllers\ContentManagement\Exhibition;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;
use Illuminate\Http\Request;
use App\Http\Requests\Exhibition\StoreExhibitionFormRequest;
use App\Http\Requests\Exhibition\ModifyExhibitionFormRequest;
use App\Contracts\ExhibitionContract;

class ExhibitionController extends Controller
{
    protected $exhibitionRepository;
    
    public function __construct(ExhibitionContract $exhibitionRepository)
    {
        $this->exhibitionRepository = $exhibitionRepository;
    }
    
    public function list()
    {
        return view('pages.content-management.exhibition.list');
    }

    public function create(Request $request){
        return view('pages.content-management.exhibition.create');
    }

    public function edit(Request $request){

        $exhibition = $this->exhibitionRepository->findExhibitionById($request->exhibition_id);

        return view('pages.content-management.exhibition.edit',['exhibition'=>$exhibition]);
    }

    public function store(StoreExhibitionFormRequest $request){

        if(isset($request->status) && $request->status == 'on'){
            $request->merge(['status' => 1]);
        }
        else $request->merge(['status' => 0]);

        $request->merge(['link' => str_replace(array('http://','https://'), '', $request->link)]);

        if($this->exhibitionRepository->create($request->except(['_token']))){
            return redirect()->route('content-management.exhibition-list')->with('exhibition_create_message', 'success');
        }
        else{
            return redirect()->route('content-management.exhibition-list')->with('exhibition_create_message', 'failed');
        }
        
    }

    public function modify(ModifyExhibitionFormRequest $request){

        if(isset($request->status) && $request->status == 'on'){
            $request->merge(['status' => 1]);
        }
        else $request->merge(['status' => 0]);

        $request->merge(['link' => str_replace(array('http://','https://'), '', $request->link)]);

        if($this->exhibitionRepository->edit($request->exhibition_id, $request->except(['_token','exhibition_id']))){
            return redirect()->route('content-management.exhibition-list')->with('exhibition_edit_message', 'success');
        }
        else{
            return redirect()->route('content-management.exhibition-list')->with('exhibition_edit_message', 'failed');
        }
        
    }

    public function delete(Request $request)
    {
        try
        {
            $exhibition = $this->exhibitionRepository->deleteExhibition($request->id);

            if ($exhibition) {
                return response()->json(['success' => true, 'message' => __('content-management.delete_success')], 200);
            }
            else{
                return response()->json(['success' => false,'errors' => __('content-management.delete_error')], 200);   
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

    public function exhibition($id)
    {   
        $return = array();
        $exhibition = $this->exhibitionRepository->findExhibitionById($id);

        $return['message'] = __('content-management.are_you_sure_to_delete');
        $return['button_text'] = __('content-management.confirm_delete');
        $return['cancel_button_text'] = __('content-management.cancel_delete');
        $return['exhibition_title'] = '<br /><br /><div><b>'.$exhibition->title.'</b></div>';
        $return['exhibition_id'] = $exhibition->id;
        return json_encode($return);
    }

    public function exhibitionForApi()
    {   
        $exhibition = $this->exhibitionRepository->getAll(1);

        foreach($exhibition as $key=>$item){
            $exhibition[$key]['exhibition_date'] = date('Y/m/d H:i',strtotime($item['exhibition_start_time'])).' - '.date('Y/m/d H:i',strtotime($item['exhibition_end_time']));

            $exhibition[$key]['exhibition_link'] = 'https://'.$item['link'];
        }

        return response()->json($exhibition);

    }

    public function tableHeader()
    {
        $header = config('global.table.headers.exhibition_list');    

        $return = array();
        $return['headers'] = view('partials.tables.content-management._exhibition-list-table-headers',['header'=>$header])->render();
        $return['columns'] = array();

        foreach($header as $key=>$val){
            $return['columns'][] = array('data'=>$val);
        }

        
        return json_encode($return);
    }


    public function table(Request $request)
    {
        $all_exhibition_list = $this->exhibitionRepository->getAll();

        $datatable_head = config('global.table.headers.exhibition_list');    

        $order_by = $datatable_head[$request->order[0]['column']];

        
        $order_by_dir = $request->order[0]['dir'];
        $offset = $request->start;

        if($request->length == '-1'){// table length : show all
            $limit = count($all_exhibition_list);
        }
        else{
            $limit = $request->length;
        }

        $search_value = $request->search['value'];

        $filtered_list = $this->exhibitionRepository->getByRequests($order_by, $order_by_dir, $offset, $limit, $search_value);  

        foreach($filtered_list as $key => $exhibition_list){
            // echo "<pre>";print_r($item);echo "</pre>";exit;
            foreach($datatable_head as $head_key => $head){
                if (view()->exists('partials/tables/content-management/_exhibition-list-table-'.$head)) {
                    $return['data'][$key][$head] = view('partials/tables/content-management/_exhibition-list-table-'.$head,['data'=>$exhibition_list[$head],'exhibition'=>$exhibition_list])->render();
                }
                else{
                    $return['data'][$key][$head] = view('partials/tables/content-management/_exhibition-list-table',['data'=>$exhibition_list[$head]])->render();
                }
                
            }

        }

        if(isset($request->draw)){
            $return['draw'] = $request->draw;
        }
        else $return['draw'] = 1;

        $return['recordsTotal'] = count($filtered_list);

        if(is_null($search_value)){
            $return['recordsFiltered'] = count($all_exhibition_list);
        }
        else{
            $return['recordsFiltered'] = count($filtered_list);
        }
        
        return json_encode($return);


    }

}
