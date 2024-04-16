<?php

namespace App\Http\Controllers\ContentManagement\News;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Requests\News\StoreNewsFormRequest;
use App\Http\Requests\News\ModifyNewsFormRequest;
use App\Contracts\NewsContract;

class NewsController extends Controller
{
    protected $newsRepository;
    
    public function __construct(NewsContract $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }
    
    public function list()
    {
        return view('pages.content-management.news.list');
    }

    public function create(Request $request){
        return view('pages.content-management.news.create');
    }

    public function edit(Request $request){
        
        $news = $this->newsRepository->findNewsById($request->news_id);

        return view('pages.content-management.news.edit',['news'=>$news]);
    }

    public function store(StoreNewsFormRequest $request){

        if(isset($request->status) && $request->status == 'on'){
            $request->merge(['status' => 1]);
        }
        else $request->merge(['status' => 0]);

        if($this->newsRepository->create($request->all())){
            return redirect()->route('content-management.news-list')->with('news_create_message', 'success');
        }
        else{
            return redirect()->route('content-management.news-list')->with('news_create_message', 'failed');
        }
        
    }

    public function modify(ModifyNewsFormRequest $request){

        if(isset($request->status) && $request->status == 'on'){
            $request->merge(['status' => 1]);
        }
        else $request->merge(['status' => 0]);

        
        // echo "<pre>";print_r($request->except(['_token','news_id']));echo "</pre>";exit;

        if($this->newsRepository->edit($request->news_id, $request->except(['_token','news_id']))){
            return redirect()->route('content-management.news-list')->with('news_edit_message', 'success');
        }
        else{
            return redirect()->route('content-management.news-list')->with('news_edit_message', 'failed');
        }
        
    }

    public function delete(Request $request)
    {
        try
        {
            $news = $this->newsRepository->deleteNews($request->id);

            if ($news) {
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

    public function news($id)
    {   
        $return = array();
        $news = $this->newsRepository->findNewsById($id);

        $return['message'] = __('content-management.are_you_sure_to_delete');
        $return['button_text'] = __('content-management.confirm_delete');
        $return['cancel_button_text'] = __('content-management.cancel_delete');
        $return['news_title'] = '<br /><br /><div><b>'.$news->title.'</b></div>';
        $return['news_id'] = $news->id;
        return json_encode($return);
    }

    public function newsForApi()
    {   
        $news = $this->newsRepository->getAll(1);

        return response()->json($news);

    }

    public function findNewsForApi(Request $request)
    {   
        $news = $this->newsRepository->findNewsById($request->id);

        return response()->json($news);

    }

    public function tableHeader()
    {
        $header = config('global.table.headers.news_list');    

        $return = array();
        $return['headers'] = view('partials.tables.content-management._news-list-table-headers',['header'=>$header])->render();
        $return['columns'] = array();

        foreach($header as $key=>$val){
            $return['columns'][] = array('data'=>$val);
        }

        
        return json_encode($return);
    }


    public function table(Request $request)
    {
        $all_news_list = $this->newsRepository->getAll();

        $datatable_head = config('global.table.headers.news_list');    

        $order_by = $datatable_head[$request->order[0]['column']];

        
        $order_by_dir = $request->order[0]['dir'];
        $offset = $request->start;

        if($request->length == '-1'){// table length : show all
            $limit = count($all_news_list);
        }
        else{
            $limit = $request->length;
        }

        $search_value = $request->search['value'];

        $filtered_list = $this->newsRepository->getByRequests($order_by, $order_by_dir, $offset, $limit, $search_value);  

        foreach($filtered_list as $key => $news_list){
            
            foreach($datatable_head as $head_key => $head){
                if (view()->exists('partials/tables/content-management/_news-list-table-'.$head)) {
                    $return['data'][$key][$head] = view('partials/tables/content-management/_news-list-table-'.$head,['data'=>$news_list[$head],'news'=>$news_list])->render();
                }
                else{
                    $return['data'][$key][$head] = view('partials/tables/content-management/_news-list-table',['data'=>$news_list[$head]])->render();
                }
                
            }

        }

        if(isset($request->draw)){
            $return['draw'] = $request->draw;
        }
        else $return['draw'] = 1;

        $return['recordsTotal'] = count($filtered_list);

        if(is_null($search_value)){
            $return['recordsFiltered'] = count($all_news_list);
        }
        else{
            $return['recordsFiltered'] = count($filtered_list);
        }
        
        return json_encode($return);


    }

    public function uploadContentImage(Request $request){
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
      
            $request->file('upload')->move(public_path('files'), $fileName);
      
            $url = asset('files/' . $fileName);
  
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }

}
