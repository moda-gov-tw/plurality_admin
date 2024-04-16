@php
function get_chinese_weekday($datetime)
{
    $weekday  = date('w', strtotime($datetime));
    $weeklist = array('日', '一', '二', '三', '四', '五', '六');
    return $weeklist[$weekday];
}

$repetitions = config('global.general.repetitions');
@endphp
<div class="tab-content">
    @foreach($regions as $key=>$region)
    <div class="tab-pane fade show @if($key==0) active @endif" id="region_{{$region['id']}}" role="tabpanel">
        @if(count($region['adslots']) > 0)
        <div class="wrapper">
            <div class="adslots_gantt_container">
                <div class="gantt_left_column">
                    <div class="gantt_info_header">
                        <span>
                            {{__('ad-schedule.channel')}}
                        </span>
                        <span>
                            {{__('ad-schedule.adslot')}}
                        </span>
                        <span>
                            {{__('ad-schedule.allowed-counts')}}
                        </span>
                    </div>
                    <div class="gantt_info_body">
                                            <!--
                                                different height of row for allowed counts
                                            -->
                                            @php
                                                $extra_horizontal_lines = 0;
                                            @endphp
                                            @foreach($region['adslots'] as $adslot_key=>$adslot)
                                                <div class="gantt_info_row" style="height:{{40*(($adslot['repetitions']==0 || $adslot['repetitions']==-1)?1:$adslot['repetitions'])}}px;">
                                                    <span>
                                                        {{$adslot['channel_group']}}
                                                    </span>
                                                    <span>
                                                        {{$adslot['adslot_group']}}
                                                    </span>
                                                    <span>
                                                        {{
                                                            $repetitions[$adslot['repetitions']]
                                                        }}
                                                    </span>
                                                </div>
                                                @if(!is_null($adslot['standbys']))
                                                    @for($i=1;$i<=count($adslot['standbys']);$i++)
                                                    <div class="gantt_info_row" style="height:40px;">
                                                        <span>
                                                            {{$adslot['channel_group']}}
                                                        </span>
                                                        <span>
                                                            standby
                                                        </span>
                                                        <span>
                                                            {{
                                                                $i;
                                                            }}
                                                        </span>
                                                    </div>
                                                    @endfor
                                                    @php
                                                        $extra_horizontal_lines += count($adslot['standbys']);
                                                    @endphp
                                                @endif
                                            @endforeach
                                            
                                            
                                        </div>
                                        <!-- <div class="gantt_info_lines" >
                                            <span></span><span></span><span></span>
                                        </div> -->
                                    </div>
                                    <div class="gantt_right_content">
                                        <div class="gantt_content_header" style="grid-template-columns: repeat({{$data_for_entire_range['all_columns_count']}}, 30px);">

                                            
                                            @foreach($month_data as $month_key=>$val)
                                            
                                                <div class="year_month" style="grid-column: {{$val['start_from_index']}}/{{$val['index_to_end']}};">
                                                    <span >
                                                        {{$val['month_label']}}
                                                    </span>
                                                </div>
                                            @endforeach
                                            
                                            
                                            <div class="weekdays" style="grid-column: 1/{{$data_for_entire_range['all_columns_count']+1}};grid-template-columns: repeat({{$data_for_entire_range['all_columns_count']}}, 30px);">
                                                @for($i=0; $i<$data_for_entire_range['all_columns_count']; $i++)
                                                <span>
                                                    @php
                                                    echo get_chinese_weekday(date('Y-m-d',strtotime($data_for_entire_range['start_date']." +".$i."days")));
                                                    @endphp
                                                </span>
                                                @endfor
                                            </div>
                                            <div class="days_of_month" style="grid-column: 1/{{$data_for_entire_range['all_columns_count']+1}};grid-template-columns: repeat({{$data_for_entire_range['all_columns_count']}}, 30px);">

                                                @foreach($month_data as $month_key=>$val)

                                                    @for($d=$val['month_start_day']; $d<($val['month_start_day']+$val['days_of_month']); $d++)
                                                        <span>{{$d}}</span>
                                                    @endfor
                                                @endforeach

                                            </div>
                                        </div>
                                        <div class="gantt_content_body" style="width:fit-content;">
                                            @foreach($region['adslots'] as $adslot_key=>$adslot)
                                            <ul class="adslot_row" 
                                            style="
                                            grid-template-columns: repeat({{$data_for_entire_range['all_columns_count']}}, 30px);
                                            grid-template-rows:  repeat({{ (($adslot['repetitions']==0 || $adslot['repetitions']==-1)?1:$adslot['repetitions']) }}, 40px);
                                            height:{{40*(($adslot['repetitions']==0 || $adslot['repetitions']==-1)?1:$adslot['repetitions'])}}px;
                                            "
                                            >
                                                

                                                <!--display empty selectable here-->

                                                <!--暫時整row 都帶空的，以利測試-->
                                                @for($row_count = 1;$row_count<=(($adslot['repetitions']==0 || $adslot['repetitions']==-1)?1:$adslot['repetitions']);$row_count++)

                                                <!--拿來暫放此row 所選的起始日-->
                                                <input value="" id="{{$region['id']}}_{{$adslot['channel_group_id']}}_{{$adslot['adslot_group_id']}}_{{$row_count}}_start_date" style="display:none;"/>

                                                <input value="" id="{{$region['id']}}_{{$adslot['channel_group_id']}}_{{$adslot['adslot_group_id']}}_{{$row_count}}_end_date" style="display:none;"/>
                                                <!--拿來暫放此row 所選的起始日-->

                                                <!--拿來暫放此row 要被移除的起始日-->
                                                <input value="" id="{{$region['id']}}_{{$adslot['channel_group_id']}}_{{$adslot['adslot_group_id']}}_{{$row_count}}_start_date_remove" style="display:none;"/>

                                                <input value="" id="{{$region['id']}}_{{$adslot['channel_group_id']}}_{{$adslot['adslot_group_id']}}_{{$row_count}}_end_date_remove" style="display:none;"/>
                                                <!--拿來暫放此row 要被移除的起始日-->

                                               
                                                <li 
                                                style="
                                                    grid-column: 1/{{ $data_for_entire_range['all_columns_count']+1 }};
                                                    grid-template-columns: repeat({{ $data_for_entire_range['all_columns_count'] }}, 30px);
                                                    display: grid;"

                                                    class="{{$region['id']}}_{{$adslot['channel_group_id']}}_{{$adslot['adslot_group_id']}}_{{$row_count}}" 
                                                    id=""
                                                    
                                                    >
                                                    @for($empty_cell_key = 1; $empty_cell_key<=$data_for_entire_range['all_columns_count']; $empty_cell_key++)
                                                        <a 
                                                        href="javascript:;" 
                                                        class="selectable_cell"
                                                        
                                                        date="{{ date('Y-m-d',strtotime($adslot['gantt_start_date'].' +'.($empty_cell_key-1).' days')) }}"
                                                        region_id="{{$region['id']}}"
                                                        channel_group_id="{{$adslot['channel_group_id']}}"
                                                        adslot_group_id="{{$adslot['adslot_group_id']}}"
                                                        row="{{$row_count}}"
                                                        >
                                                            &nbsp;
                                                        </a>
                                                    @endfor
                                                </li>   
                                                     
                                                @endfor

                                                <!--display empty selectable here-->

                                            </ul>
                                            @foreach($adslot['standbys'] as $row=>$row_contents)
                                            <ul class="adslot_row" 
                                            style="
                                            grid-template-columns: repeat({{$data_for_entire_range['all_columns_count']}}, 30px);
                                            height:{{40}}px;
                                            "
                                            >
                                                @php
                                                    $empty_start_index=1;
                                                    $empty_end_index=1;
                                                @endphp

                                                @for($i=1;$i<=$data_for_entire_range['all_columns_count'];$i++)
                                                    

                                                    @if(!isset($row_contents[$i]))
                                                        @php
                                                            $empty_end_index++;
                                                        @endphp
                                                    @else

                                                        @if($empty_start_index == $row_contents[$i]['start_index'])
                                                            <li 
                                                                style="grid-column: {{ $row_contents[$i]['start_index'] }}/{{ $row_contents[$i]['end_index'] }};"
                                                                class="badge-standby"
                                                            >
                                                                {{$row_contents[$i]['customer_name']}}
                                                            </li>
                                                        @else
                                                            <li style="grid-column: {{ $empty_start_index }}/{{ $empty_end_index }};">
                                                                @for($j=1;$j<=($empty_end_index-$empty_start_index);$j++)
                                                                <a 
                                                                href="javascript:;" 
                                                                class=""
                                                                >
                                                                    &nbsp;
                                                                </a>
                                                                @endfor
                                                            </li>
                                                            <li 
                                                                style="grid-column: {{ $row_contents[$i]['start_index'] }}/{{ $row_contents[$i]['end_index'] }};"
                                                                class="badge-standby"
                                                            >
                                                                {{$row_contents[$i]['customer_name']}}
                                                            </li>
                                                        @endif
                                                    
                                                        @php
                                                            $empty_start_index=$row_contents[$i]['end_index'];
                                                            $empty_end_index=$row_contents[$i]['end_index'];
                                                        @endphp
                                                    @endif
                                                @endfor
                                                
                                            </ul>
                                            @endforeach
                                            
                                            @endforeach

                                        <!-- <div class="gantt_content_lines" style="grid-template-columns: repeat({{$data_for_entire_range['all_columns_count']}}, 30px);">
                                            @for($i=1; $i<=$data_for_entire_range['all_columns_count']; $i++)
                                            <span>
                                            </span>
                                            @endfor
                                        </div> -->
                                        <div class="gantt_content_horizontal_lines" style="grid-template-rows: repeat({{$data_for_entire_range[$region['id']]['all_repetitions_count'] + $extra_horizontal_lines}}, 40px);">
                                            @for($i=1; $i<=($data_for_entire_range[$region['id']]['all_repetitions_count']+$extra_horizontal_lines); $i++)
                                            <div>
                                            </div>
                                            @endfor
                                        </div>

                                    </div>
                    </div>
                </div>
            </div>

        @endif
    </div>
    @endforeach
</div>