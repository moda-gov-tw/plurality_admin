<?php

namespace App\Repositories;

use App\Models\Exhibition;
use App\Contracts\ExhibitionContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ExhibitionRepository
 *
 * @package \App\Repositories
 */
class ExhibitionRepository extends BaseRepository implements ExhibitionContract
{

    public function __construct(Exhibition $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getAll($status = ''){
        if($status != ''){
            return $this->model::orderBy('exhibition_start_time', 'desc')
            ->where('status', $status)
            ->get(); 
        }
        else{
            return $this->model::orderBy('exhibition_start_time', 'desc')->get();     
        }
        
    }

    public function getByRequests($order_by, $order_by_dir, $offset, $limit, $search_value=''){

        if(!is_null($search_value)){
            $results = Exhibition::select('*')
            ->having(function ($results) use ($search_value) {
                $results->having('exhibition_start_time', 'LIKE', '%'.$search_value.'%')
                ->orhaving('exhibition_end_time', 'LIKE', '%'.$search_value.'%')
                ->orhaving('title', 'LIKE', '%'.$search_value.'%')
                ->orhaving('content', 'LIKE', '%'.$search_value.'%')
                ->orhaving('location', 'LIKE', '%'.$search_value.'%')
                ->orhaving('link', 'LIKE', '%'.$search_value.'%')
                ;
            })
            ->orderBy($order_by,$order_by_dir)
            ->offset($offset)
            ->limit($limit)
            ->get(); 
             
        }
        else{
            $results = Exhibition::select('*')
            ->orderBy($order_by,$order_by_dir)
            ->offset($offset)
            ->limit($limit)
            ->get();  
        }
        


         // Log::info(DB::getQueryLog());

        return $results;
    }

    public function create($params){
        $exhibition_date_time = explode('-', $params['exhibition_date']);
        unset($params['exhibition_date']);

        $params['exhibition_start_time'] = date("Y-m-d H:i:s",strtotime($exhibition_date_time[0]));
        $params['exhibition_end_time'] = date("Y-m-d H:i:s",strtotime($exhibition_date_time[1]));
        
        $exhibition = new Exhibition($params);
        return $exhibition->save();
    }

    public function edit($id,$params){
        $exhibition = $this->model::where('id', $id)->first();

        $exhibition_date_time = explode('-', $params['exhibition_date']);
        unset($params['exhibition_date']);

        $params['exhibition_start_time'] = date("Y-m-d H:i:s",strtotime($exhibition_date_time[0]));
        $params['exhibition_end_time'] = date("Y-m-d H:i:s",strtotime($exhibition_date_time[1]));

        // echo "<pre>";print_r($params);echo "</pre>";exit;
        return $exhibition->update($params);
    }

    public function findExhibitionById($id){
        try {
            return $this->model::where('id',$id)->first();

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function deleteExhibition($exhibition_id){
        return $this->model::where('id', $exhibition_id)->firstorfail()->delete();
    }

    /***********************************************/

    
    
}