<?php

namespace App\Repositories;

use App\Models\News;
use App\Contracts\NewsContract;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Log;

/**
 * Class ProductRepository
 *
 * @package \App\Repositories
 */
class NewsRepository extends BaseRepository implements NewsContract
{

    public function __construct(News $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function getAll($status = ''){
        if($status != ''){
            return $this->model::orderBy('news_date', 'desc')
            ->where('status', $status)
            ->get(); 
        }
        else{
            return $this->model::orderBy('news_date', 'desc')->get();     
        }
        
    }

    public function getByRequests($order_by, $order_by_dir, $offset, $limit, $search_value=''){

        if(!is_null($search_value)){
            $results = News::select('*')
            ->having(function ($results) use ($search_value) {
                $results->having('news_date', 'LIKE', '%'.$search_value.'%')
                ->orhaving('title', 'LIKE', '%'.$search_value.'%')
                ->orhaving('content', 'LIKE', '%'.$search_value.'%')
                ;
            })
            ->orderBy($order_by,$order_by_dir)
            ->offset($offset)
            ->limit($limit)
            ->get(); 
             
        }
        else{
            $results = News::select('*')
            ->orderBy($order_by,$order_by_dir)
            ->offset($offset)
            ->limit($limit)
            ->get();  
        }
        


         // Log::info(DB::getQueryLog());

        return $results;
    }

    public function create($params){
        $news = new News($params);
        return $news->save();
    }

    public function edit($id,$params){
        $news = $this->model::where('id', $id)->first();
        return $news->update($params);
    }

    public function findNewsById($id){
        try {
            return $this->model::where('id',$id)->first();

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function deleteNews($news_id){
        return $this->model::where('id', $news_id)->firstorfail()->delete();
    }

    /***********************************************/

    

    public function getAllStandbyInsertionDetailsByCombinationKey($combination_key){
        return InsertionDetail::where('combination_key', $combination_key)
        ->where('status', 'standby')
        ->get();
    }

    public function findInsertionById($id){
        try {
            return $this->model::where('id',$id)->first();

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function turnToStandby($insertion_id){
        try {
            /**
             * 將insertion table 的status 變更為stand by
             * */
            $insertion = $this->model::where('id', $insertion_id)->first();
            $insertion->update(['status'=>'standby']);

            /**
             * 決定insertion 裡每筆版位standby 的位置(at_which_row)
             * */
            foreach($insertion->details as $key=>$detail){
                $at_which_row = $this->determineAtWhichRow($detail);
                $detail->status = 'standby';
                $detail->at_which_row = $at_which_row;
                $detail->save();    
            }
            
            return $insertion;

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function turnToStandbyWithInsertion($insertion_id){
        try {
            /**
             * 將insertion table 的status 變更為stand by
             * */
            $insertion = $this->model::where('id', $insertion_id)->first();
            $insertion->update(['status'=>'standbyWithInsertion']);

            /**
             * 決定insertion 裡每筆版位standby 的位置(at_which_row)
             * */

            foreach($insertion->details as $key=>$detail){
                if(!is_null($detail->adslot_group_id)){
                    $at_which_row = $this->determineAtWhichRow($detail);
                    $detail->status = 'standbyWithInsertion';
                    $detail->at_which_row = $at_which_row;
                    $detail->save();    
                }
            }
            
            return $insertion;

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    public function determineAtWhichRow($insertion_detail){

        
        // echo $insertion_detail->channel->name;exit;

        
            /**
             * 此時委刊單狀態已進入standby
             * 則需各別判斷其下之版位的狀態
             * */
            $insertion_detail_date_range = $insertion_detail->dateRanges->first()->date_ranges;

            $insertion_detail_combination_key = $insertion_detail->combination_key;
            

            /**
             * 檢查是否有其它insertion detail 是相同的combination key 且是相同的date range
             * 如果有：表示standby 要往下排
             * */

            $same_insertion_details = InsertionDetail::where('combination_key', $insertion_detail->combination_key)
            ->where('status', 'standby')
            ->where('insertion_id', '!=', $insertion_detail->insertion->id)
            ->get();

            $standby_count = 1;
            foreach($same_insertion_details as $key=>$individual_insertion_detail){
                    
                    // echo 'individual_insertion_detail_id'.$individual_insertion_detail->id."<br />";
                    // echo 'individual_insertion_detail_dateRanges'.$individual_insertion_detail->dateRanges->date_ranges."<br />";
                    // echo 'insertion_detail_date_range'.$insertion_detail_date_range."<br />";

                if($individual_insertion_detail->dateRanges->date_ranges == $insertion_detail_date_range){
                    $standby_count++;
                }
            }

            return $standby_count;
        
       
    }

    public function updateInsertionById($insertion_id, $params, $details, $status = '')
    {
        // echo "<pre>";print_r($details);echo "</pre>";
        try {
            $status = 'temp';
            $params['create_date'] = date('Y-m-d');
            $params['insertion_number'] = $status.'-'.time();
            $params['customer_name'] = !empty($params['customer_name'])?$params['customer_name']:'';
            $params['product_name'] = !empty($params['product_name'])?$params['product_name']:'';
            $params['product_detail_name'] = !empty($params['product_detail_name'])?$params['product_detail_name']:'';
            $params['note'] = !empty($params['note'])?$params['note']:'';
            $params['city'] = !empty($params['city'])?$params['city']:'';
            $params['district'] = !empty($params['district'])?$params['district']:'';
            $temp_dates = array();
            $total_sale_price = 0;
            $total_list_price = 0;
            $total_discount = 0;
            $quantity_of_adslots = 0;

            //站內廣告 & 數字廣告
            if(isset($details['D'])){
                foreach($details['D'] as $key=>$adslot_group){
                    foreach($adslot_group['info']['dateRanges'] as $date_range_key=>$dates){
                        $temp_dates = array_merge($temp_dates, $dates);
                    }

                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    $total_list_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']));
                    $total_sale_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']))*(1-($adslot_group['info']['discount_percentage']/100));
                    $total_discount += $adslot_group['info']['discount_percentage'];
                    $quantity_of_adslots++;
                }
            }
            
            if(isset($details['M'])){
                foreach($details['M'] as $key=>$adslot_group){
                    foreach($adslot_group['info']['dateRanges'] as $date_range_key=>$dates){
                        $temp_dates = array_merge($temp_dates, $dates);
                    }

                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    $total_list_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']));
                    $total_sale_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']))*(1-($adslot_group['info']['discount_percentage']/100));
                    $total_discount += $adslot_group['info']['discount_percentage'];
                    $quantity_of_adslots++;
                }
            }

            if(isset($details['R'])){
                foreach($details['R'] as $key=>$adslot){
                    foreach($adslot['info'] as $info_key=>$ad){
                        $temp_dates = array_merge($temp_dates, $ad['dateRanges'][0]);
                        $total_list_price += @$ad['subtotal_sale_price'];
                        $total_sale_price += @$ad['subtotal_sale_price'];
                        $quantity_of_adslots++;
                    }
                }
            }

            if(isset($details['A'])){
                foreach($details['A'] as $key=>$adslot){
                    foreach($adslot['info'] as $info_key=>$ad){
                        $temp_dates = array_merge($temp_dates, $ad['dateRanges'][0]);
                        $total_list_price += @$ad['subtotal_sale_price'];
                        $total_sale_price += @$ad['subtotal_sale_price'];
                        $quantity_of_adslots++;
                    }
                }
            }
            

            sort($temp_dates);

            // echo "<pre>";print_r($temp_dates);echo "</pre>";exit;

            $params['start_date'] = $temp_dates[array_key_first($temp_dates)];
            $params['end_date'] = $temp_dates[array_key_last($temp_dates)];
            
            
            $params['quantity_of_adslots'] = $quantity_of_adslots;

            $params['total_sale_price'] = $total_sale_price;
            $params['total_discount'] = 1-($total_sale_price/$total_list_price);

            //此時委刊單狀態為暫存
            $params['status'] = $status;
            $params['reserved_by'] = 1;
            $params['sales'] = 1;
            $params['expiration_date'] = date('Y-m-d', strtotime('+14 days'));


            unset($params['store_by_assistant']);
            unset($params['_token']);
            
            // echo "<pre>params : ";print_r($params);echo "</pre>";exit;

            $insertion = Insertion::where('id', $insertion_id)->first();

            $insertion->update($params);

            // echo $insertion->id;exit;


            /**
             * record insertion details
             * 如果是暫存，不需記錄判斷at_which_row
             * */
            // InsertionDetail::where('insertion_id', $insertion->id)->delete();
            if(isset($details['D'])){
                foreach($details['D'] as $combination_key=>$adslot_group){
                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    foreach($adslot_group['info']['dateRanges'] as $key=>$date_range){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $adslot_group['info']['channelId'];
                        $params['region_id'] = $adslot_group['info']['regionId'];
                        $params['channel_group_id'] = $adslot_group['info']['channelGroupId'];
                        $params['adslot_group_id'] = $adslot_group['info']['adslotGroupId'];
                        $params['days'] = count($date_range);

                        

                        $params['total_list_price'] = $adslot_group['info']['list_price'];

                        $params['total_sale_price'] = $params['total_list_price']*(1-($adslot_group['info']['discount_percentage']/100));

                        $params['discount_percentage'] = $adslot_group['info']['discount_percentage'];
                        $params['note'] = $adslot_group['info']['note'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = InsertionDetail::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_id'=>$insertion_id],
                            $params
                        );

                        $date_range_params = array();
                        $date_range_params['date_ranges'] = json_encode($date_range);

                        InsertionDetailDateRange::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_detail_id'=>$insertion_detail->id],
                            $date_range_params
                        );
                    }
                }
            }

            if(isset($details['M'])){
                foreach($details['M'] as $combination_key=>$adslot_group){
                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    foreach($adslot_group['info']['dateRanges'] as $key=>$date_range){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $adslot_group['info']['channelId'];
                        $params['region_id'] = $adslot_group['info']['regionId'];
                        $params['channel_group_id'] = $adslot_group['info']['channelGroupId'];
                        $params['adslot_group_id'] = $adslot_group['info']['adslotGroupId'];
                        $params['days'] = count($date_range);

                        

                        $params['total_list_price'] = $adslot_group['info']['list_price'];

                        $params['total_sale_price'] = $params['total_list_price']*(1-($adslot_group['info']['discount_percentage']/100));

                        $params['discount_percentage'] = $adslot_group['info']['discount_percentage'];
                        $params['note'] = $adslot_group['info']['note'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = InsertionDetail::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_id'=>$insertion_id],
                            $params
                        );

                        $date_range_params = array();
                        $date_range_params['date_ranges'] = json_encode($date_range);

                        InsertionDetailDateRange::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_detail_id'=>$insertion_detail->id],
                            $date_range_params
                        );
                    }
                }
            }

            if(isset($details['R'])){
                foreach($details['R'] as $combination_key=>$ads){


                    foreach($ads['info'] as $info_key=>$ad){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $ad['channelId'];
                        $params['region_id'] = $ad['regionId'];
                        $params['ad_id'] = $ad['adId'];
                        $params['sales_unit'] = $ad['sales_unit'];
                        $params['days'] = count($ad['dateRanges'][0]);

                        $params['total_list_price'] = isset($ad['subtotal_sale_price'])?$ad['subtotal_sale_price']:0;
                        $params['total_sale_price'] = $params['total_list_price'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = InsertionDetail::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_id'=>$insertion_id],
                            $params
                        );

                        $date_range_params = array();
                        $date_range_params['date_ranges'] = json_encode($ad['dateRanges'][0]);

                        InsertionDetailDateRange::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_detail_id'=>$insertion_detail->id],
                            $date_range_params
                        );
                    }
                }
            }

            if(isset($details['A'])){
                foreach($details['A'] as $combination_key=>$ads){

                    foreach($ads['info'] as $info_key=>$ad){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $ad['channelId'];
                        $params['region_id'] = $ad['regionId'];
                        $params['ad_id'] = $ad['adId'];
                        $params['sales_unit'] = $ad['sales_unit'];
                        $params['days'] = count($ad['dateRanges'][0]);

                        $params['total_list_price'] = isset($ad['subtotal_sale_price'])?$ad['subtotal_sale_price']:0;
                        $params['total_sale_price'] = $params['total_list_price'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = InsertionDetail::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_id'=>$insertion_id],
                            $params
                        );

                        $date_range_params = array();
                        $date_range_params['date_ranges'] = json_encode($ad['dateRanges'][0]);

                        InsertionDetailDateRange::updateOrCreate(
                            ['combination_key'=>$combination_key, 'insertion_detail_id'=>$insertion_detail->id],
                            $date_range_params
                        );
                    }
                }
            }

            
            return $insertion;

        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    public function saveToTemp($params, $details)
    {
        // echo "<pre>";print_r($details);echo "</pre>";exit;

        try {
            $status = 'temp';
            $params['create_date'] = date('Y-m-d');
            $params['insertion_number'] = $status.'-'.time();
            $params['customer_name'] = !empty($params['customer_name'])?$params['customer_name']:'';
            $params['product_name'] = !empty($params['product_name'])?$params['product_name']:'';
            $params['product_detail_name'] = !empty($params['product_detail_name'])?$params['product_detail_name']:'';
            $params['note'] = !empty($params['note'])?$params['note']:'';
            $params['city'] = !empty($params['city'])?$params['city']:'';
            $params['district'] = !empty($params['district'])?$params['district']:'';
            $temp_dates = array();
            $total_sale_price = 0;
            $total_list_price = 0;
            $total_discount = 0;
            $quantity_of_adslots = 0;

            //站內廣告 & 數字廣告
            if(isset($details['D'])){
                foreach($details['D'] as $key=>$adslot_group){
                    foreach($adslot_group['info']['dateRanges'] as $date_range_key=>$dates){
                        $temp_dates = array_merge($temp_dates, $dates);
                    }

                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    $total_list_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']));
                    $total_sale_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']))*(1-($adslot_group['info']['discount_percentage']/100));
                    $total_discount += $adslot_group['info']['discount_percentage'];
                    $quantity_of_adslots++;
                }
            }
            
            if(isset($details['M'])){
                foreach($details['M'] as $key=>$adslot_group){
                    foreach($adslot_group['info']['dateRanges'] as $date_range_key=>$dates){
                        $temp_dates = array_merge($temp_dates, $dates);
                    }

                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    $total_list_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']));
                    $total_sale_price += ($adslot_group['info']['list_price']*count($adslot_group['info']['dateRanges']))*(1-($adslot_group['info']['discount_percentage']/100));
                    $total_discount += $adslot_group['info']['discount_percentage'];
                    $quantity_of_adslots++;
                }
            }

            if(isset($details['R'])){
                foreach($details['R'] as $key=>$adslot){
                    foreach($adslot['info'] as $info_key=>$ad){
                        $temp_dates = array_merge($temp_dates, $ad['dateRanges'][0]);
                        $total_list_price += @$ad['subtotal_sale_price'];
                        $total_sale_price += @$ad['subtotal_sale_price'];
                        $quantity_of_adslots++;
                    }
                }
            }

            if(isset($details['A'])){
                foreach($details['A'] as $key=>$adslot){
                    foreach($adslot['info'] as $info_key=>$ad){
                        $temp_dates = array_merge($temp_dates, $ad['dateRanges'][0]);
                        $total_list_price += @$ad['subtotal_sale_price'];
                        $total_sale_price += @$ad['subtotal_sale_price'];
                        $quantity_of_adslots++;
                    }
                }
            }
            

            sort($temp_dates);

            // echo "<pre>";print_r($temp_dates);echo "</pre>";exit;

            $params['start_date'] = $temp_dates[array_key_first($temp_dates)];
            $params['end_date'] = $temp_dates[array_key_last($temp_dates)];
            
            
            $params['quantity_of_adslots'] = $quantity_of_adslots;

            $params['total_sale_price'] = $total_sale_price;
            $params['total_discount'] = 1-($total_sale_price/$total_list_price);

            //此時委刊單狀態為暫存
            $params['status'] = $status;
            $params['reserved_by'] = 1;
            $params['sales'] = 1;
            $params['expiration_date'] = date('Y-m-d', strtotime('+14 days'));


            unset($params['store_by_assistant']);
            unset($params['_token']);

            // echo "<pre>params : ";print_r($params);echo "</pre>";exit;
            $insertion = new Insertion($params);
            $insertion->save();

            // echo $insertion->id;exit;

            /**
             * record insertion details
             * 如果是暫存，不需記錄判斷at_which_row
             * */
            if(isset($details['D'])){
                foreach($details['D'] as $combination_key=>$adslot_group){
                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    foreach($adslot_group['info']['dateRanges'] as $key=>$date_range){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $adslot_group['info']['channelId'];
                        $params['region_id'] = $adslot_group['info']['regionId'];
                        $params['channel_group_id'] = $adslot_group['info']['channelGroupId'];
                        $params['adslot_group_id'] = $adslot_group['info']['adslotGroupId'];
                        $params['days'] = count($date_range);

                        

                        $params['total_list_price'] = $adslot_group['info']['list_price'];

                        $params['total_sale_price'] = $params['total_list_price']*(1-($adslot_group['info']['discount_percentage']/100));

                        $params['discount_percentage'] = $adslot_group['info']['discount_percentage'];
                        $params['note'] = $adslot_group['info']['note'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = new InsertionDetail($params);
                        $insertion_detail->save();

                        $date_range_params = array();
                        $date_range_params['combination_key'] = $combination_key;
                        $date_range_params['insertion_detail_id'] = $insertion_detail->id;
                        $date_range_params['date_ranges'] = json_encode($date_range);

                        $insertion_detail_date_range = new InsertionDetailDateRange($date_range_params);
                        $insertion_detail_date_range->save();
                    }
                }
            }

            if(isset($details['M'])){
                foreach($details['M'] as $combination_key=>$adslot_group){
                    $specific_adslot_group = $this->adslotGroupRepository->findAdslotGroupById($adslot_group['info']['adslotGroupId']);


                    foreach($adslot_group['info']['dateRanges'] as $key=>$date_range){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $adslot_group['info']['channelId'];
                        $params['region_id'] = $adslot_group['info']['regionId'];
                        $params['channel_group_id'] = $adslot_group['info']['channelGroupId'];
                        $params['adslot_group_id'] = $adslot_group['info']['adslotGroupId'];
                        $params['days'] = count($date_range);

                        

                        $params['total_list_price'] = $adslot_group['info']['list_price'];

                        $params['total_sale_price'] = $params['total_list_price']*(1-($adslot_group['info']['discount_percentage']/100));

                        $params['discount_percentage'] = $adslot_group['info']['discount_percentage'];
                        $params['note'] = $adslot_group['info']['note'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = new InsertionDetail($params);
                        $insertion_detail->save();

                        $date_range_params = array();
                        $date_range_params['combination_key'] = $combination_key;
                        $date_range_params['insertion_detail_id'] = $insertion_detail->id;
                        $date_range_params['date_ranges'] = json_encode($date_range);

                        $insertion_detail_date_range = new InsertionDetailDateRange($date_range_params);
                        $insertion_detail_date_range->save();
                    }
                }
            }

            if(isset($details['R'])){
                foreach($details['R'] as $combination_key=>$ads){


                    foreach($ads['info'] as $info_key=>$ad){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $ad['channelId'];
                        $params['region_id'] = $ad['regionId'];
                        $params['ad_id'] = $ad['adId'];
                        $params['sales_unit'] = $ad['sales_unit'];
                        $params['days'] = count($ad['dateRanges'][0]);

                        $params['total_list_price'] = isset($ad['subtotal_sale_price'])?$ad['subtotal_sale_price']:0;
                        $params['total_sale_price'] = $params['total_list_price'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = new InsertionDetail($params);
                        $insertion_detail->save();

                        $date_range_params = array();
                        $date_range_params['combination_key'] = $combination_key;
                        $date_range_params['insertion_detail_id'] = $insertion_detail->id;
                        $date_range_params['date_ranges'] = json_encode($ad['dateRanges'][0]);

                        $insertion_detail_date_range = new InsertionDetailDateRange($date_range_params);
                        $insertion_detail_date_range->save();
                    }
                }
            }

            if(isset($details['A'])){
                foreach($details['A'] as $combination_key=>$ads){


                    foreach($ads['info'] as $info_key=>$ad){
                        $params = array();

                        $params['insertion_id'] = $insertion->id;
                        $params['combination_key'] = $combination_key;
                        $params['channel_id'] = $ad['channelId'];
                        $params['region_id'] = $ad['regionId'];
                        $params['ad_id'] = $ad['adId'];
                        $params['sales_unit'] = $ad['sales_unit'];
                        $params['days'] = count($ad['dateRanges'][0]);

                        $params['total_list_price'] = isset($ad['subtotal_sale_price'])?$ad['subtotal_sale_price']:0;
                        $params['total_sale_price'] = $params['total_list_price'];

                        //此時版位狀態為暫存
                        $params['status'] = $status;

                        $insertion_detail = new InsertionDetail($params);
                        $insertion_detail->save();

                        $date_range_params = array();
                        $date_range_params['combination_key'] = $combination_key;
                        $date_range_params['insertion_detail_id'] = $insertion_detail->id;
                        $date_range_params['date_ranges'] = json_encode($ad['dateRanges'][0]);

                        $insertion_detail_date_range = new InsertionDetailDateRange($date_range_params);
                        $insertion_detail_date_range->save();
                    }
                }
            }
            
            
            return $insertion;

        } catch (\Exception $e) {
            echo $e->getMessage();exit;
        }
    }

    public function updateChannelGroup($id, $params){
        try {
            return $this->model::where('id', $id)->update($params);

        } catch (ModelNotFoundException $e) {

            throw new ModelNotFoundException($e);
        }
    }

    

    

    public function getAllByChannelAndRegion($display_in_menu = null, $channel_id = null, $region_id){
        if(!is_null($display_in_menu)){
            if(!is_null($channel_id)){
                if(!is_null($region_id)){
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_groups.channel_id', $channel_id)
                    ->where('channel_groups.display_in_menu', $display_in_menu)
                    ->where('channel_group_regions.region_id', $region_id)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }
                else{
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_groups.channel_id', $channel_id)
                    ->where('channel_groups.display_in_menu', $display_in_menu)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }
                
            }
            else{
                if(!is_null($region_id)){
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_groups.display_in_menu', $display_in_menu)
                    ->where('channel_group_regions.region_id', $region_id)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }
                else{
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_groups.display_in_menu', $display_in_menu)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }    
            }
            
        }
        else{
            if(!is_null($channel_id)){
                if(!is_null($region_id)){
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_groups.channel_id', $channel_id)
                    ->where('channel_group_regions.region_id', $region_id)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }
                else{
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_groups.channel_id', $channel_id)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }
                
            }
            else{
                if(!is_null($region_id)){
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->where('channel_group_regions.region_id', $region_id)
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }
                else{
                    return ChannelGroup::select(
                        'channel_groups.id as id',
                        'channel_groups.name as name',
                        'channel_groups.order as order'
                    )
                    ->distinct()
                    ->leftJoin('channel_group_regions', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->orderBy('order', 'asc')
                    ->get();  
                }    
            }
            
        }
        
    }

    

    public function getChannelGroupRegionsByRequests($order_by, $order_by_dir, $offset, $limit, $search_value, $channel_group_id=null){

        if(!is_null($search_value)){
            if(!is_null($channel_group_id)){
                $results = ChannelGroupRegion::select(
                        'regions.order as order',
                        'channels.name as channel',
                        'channel_groups.name as channel_group',
                        'regions.name as region',
                        'channel_groups.type as channel_group_type',
                        DB::raw('DATE_FORMAT(channel_groups.created_at, "%Y-%c-%d") as create_date'),
                        DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as created_by")
                    )
                    ->leftJoin('channel_groups', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->leftJoin('channels', function ($join) {
                        $join->on('channels.id', '=', 'channel_groups.channel_id');
                    })
                    ->leftJoin('users', function ($join) {
                        $join->on('users.id', '=', 'channel_groups.created_by');
                    })
                    ->leftJoin('regions', function ($join) {
                        $join->on('regions.id', '=', 'channel_group_regions.region_id');
                    })
                    ->having(function ($results) use ($search_value) {
                        $results->having('create_date', 'LIKE', '%'.$search_value.'%')
                        ->orhaving('channel', 'LIKE', '%'.$search_value.'%')
                        ->orhaving('channel_group', 'LIKE', '%'.$search_value.'%')
                        ->orhaving('created_by', 'LIKE', '%'.$search_value.'%');
                    })
                    ->where('channel_group_regions.channel_group_id',$channel_group_id)
                    ->orderBy($order_by,$order_by_dir)
                    ->offset($offset)
                    ->limit($limit)
                    ->get(); 

                return $results;
            }
            else{
                $results = ChannelGroupRegion::select(
                    'regions.order as order',
                    'channels.name as channel',
                    'channel_groups.name as channel_group',
                    'regions.name as region',
                    'channel_groups.type as channel_group_type',
                    DB::raw('DATE_FORMAT(channel_groups.created_at, "%Y-%c-%d") as create_date'),
                    DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as created_by")
                )
                ->leftJoin('channel_groups', function ($join) {
                    $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                })
                ->leftJoin('channels', function ($join) {
                    $join->on('channels.id', '=', 'channel_groups.channel_id');
                })
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', 'channel_groups.created_by');
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', 'channel_group_regions.region_id');
                })
                ->having(function ($results) use ($search_value) {
                    $results->having('create_date', 'LIKE', '%'.$search_value.'%')
                    ->orhaving('channel', 'LIKE', '%'.$search_value.'%')
                    ->orhaving('channel_group', 'LIKE', '%'.$search_value.'%')
                    ->orhaving('created_by', 'LIKE', '%'.$search_value.'%');
                })
                ->orderBy($order_by,$order_by_dir)
                ->offset($offset)
                ->limit($limit)
                ->get(); 

                return $results;
            }
            
        }
        else{
            if(!is_null($channel_group_id)){
                $results = ChannelGroupRegion::select(
                        'regions.order as order',
                        'channels.name as channel',
                        'channel_groups.name as channel_group',
                        'regions.name as region',
                        'channel_groups.type as channel_group_type',
                        DB::raw('DATE_FORMAT(channel_groups.created_at, "%Y-%c-%d") as create_date'),
                        DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as created_by")
                    )
                    ->leftJoin('channel_groups', function ($join) {
                        $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                    })
                    ->leftJoin('channels', function ($join) {
                        $join->on('channels.id', '=', 'channel_groups.channel_id');
                    })
                    ->leftJoin('users', function ($join) {
                        $join->on('users.id', '=', 'channel_groups.created_by');
                    })
                    ->leftJoin('regions', function ($join) {
                        $join->on('regions.id', '=', 'channel_group_regions.region_id');
                    })
                    ->where('channel_group_regions.channel_group_id',$channel_group_id)
                    ->orderBy($order_by,$order_by_dir)
                    ->offset($offset)
                    ->limit($limit)
                    ->get(); 

                return $results;
            }
            else{
                $results = ChannelGroupRegion::select(
                    'regions.order as order',
                    'channels.name as channel',
                    'channel_groups.name as channel_group',
                    'regions.name as region',
                    'channel_groups.type as channel_group_type',
                    DB::raw('DATE_FORMAT(channel_groups.created_at, "%Y-%c-%d") as create_date'),
                    DB::raw("CONCAT(`users`.`first_name`,' ',`users`.`last_name`) as created_by")
                )
                ->leftJoin('channel_groups', function ($join) {
                    $join->on('channel_groups.id', '=', 'channel_group_regions.channel_group_id');
                })
                ->leftJoin('channels', function ($join) {
                    $join->on('channels.id', '=', 'channel_groups.channel_id');
                })
                ->leftJoin('users', function ($join) {
                    $join->on('users.id', '=', 'channel_groups.created_by');
                })
                ->leftJoin('regions', function ($join) {
                    $join->on('regions.id', '=', 'channel_group_regions.region_id');
                })
                ->orderBy($order_by,$order_by_dir)
                ->offset($offset)
                ->limit($limit)
                ->get(); 

                return $results;
            }
            
        }
        
    }

    public function recordCount(){
        return ChannelGroup::count();
    }

    
}