
<html>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<link rel="stylesheet" href="{{ asset('demo1/plugins/global/plugins.bundle.css') }}">
	<link rel="stylesheet" href="{{ asset('demo1/plugins/global/plugins-custom.bundle.css') }}">
	<link rel="stylesheet" href="{{ asset('demo1/css/style.bundle.css') }}">
	<style>
		.preview_gantt_left_column {
  flex: 0.1;
  border-left: 1px solid grey;
  border-top: 1px solid grey;
  border-bottom: 1px solid grey;
  position: relative;
  flex-direction: column;
}

.preview_gantt_info_header {
  background-color: grey !important;
  height: 100px;
  display: grid;
  grid-template-columns: 80px 240px 40px;
}
.preview_gantt_info_header span {
  text-align: center;
  color: white !important;
  place-self: center;
}

.preview_gantt_info_lines {
  position: absolute;
  bottom: 0;
  height: 100%;
  width: 100%;
  background-color: transparent;
  display: grid;
}
.preview_gantt_info_lines span {
  display: block;
  border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.preview_gantt_info_row {
  display: grid;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.preview_gantt_info_row span {
  text-align: center;
  place-self: center;
}

.preview_gantt_right_content {
  flex: 0.9;
  border-right: 1px solid grey;
  border-top: 1px solid grey;
  border-bottom: 1px solid grey;
  border-left: 0px;
  overflow-x: scroll;
}

.preview_gantt_content_header {
  height: 80px;
  display: grid;
}
.preview_gantt_content_header span {
  text-align: center;
  color: white !important;
  place-self: center;
}
.preview_gantt_content_header .year_month {
  display: grid;
  background-color: grey !important;
}
.preview_gantt_content_header .weekdays {
  display: grid;
  background-color: grey !important;
}
.preview_gantt_content_header .days_of_month {
  display: grid;
  background-color: grey !important;
}

.preview_gantt_content_body {
  display: grid;
  position: relative;
}

	</style>
@php
function get_chinese_weekday($datetime)
{
    $weekday  = date('w', strtotime($datetime));
    $weeklist = array('日', '一', '二', '三', '四', '五', '六');
    return $weeklist[$weekday];
}

$repetitions = config('global.general.repetitions');
@endphp
@foreach($all_month_records as $year_month=>$rows)

<div class="adslots_gantt_container">
    <div class="preview_gantt_left_column">
		<div class="preview_gantt_info_body">
            <div class="preview_gantt_info_row" style="height:{{ count($rows)*40+80 }}px;">
                <span>
                    {{ date('Y年m月', strtotime($year_month)) }}
                </span>
            </div>
        </div>
        <div class="preview_gantt_info_lines" >
            <span></span>
        </div>
    </div>
    <div class="preview_gantt_right_content">
        <div class="preview_gantt_content_header" style="grid-template-columns: repeat({{date('t',strtotime($year_month))}}, 50px);">

            
            <div class="weekdays" style="grid-column: 1/{{ date('t',strtotime($year_month))+1 }};grid-template-columns: repeat({{date('t',strtotime($year_month))}}, 50px);">
                @for($i=0; $i< date('t',strtotime($year_month)) ; $i++)
                <span>
                    @php
                    echo get_chinese_weekday(date('Y-m-d',strtotime($year_month.'-01'." +".$i."days")));
                    @endphp
                </span>
                @endfor
            </div>
            <div class="days_of_month" style="grid-column: 1/{{ date('t',strtotime($year_month))+1 }};grid-template-columns: repeat({{date('t',strtotime($year_month))}}, 50px);">

                @for($i=1; $i<=date('t',strtotime($year_month)); $i++)
                <span>
                    @php
                    echo date('m/d',strtotime($year_month.'-'.$i));
                    @endphp
                </span>
                @endfor

            </div>
        </div>
        <div class="preview_gantt_content_body" style="width:fit-content;">
        	@foreach($rows as $row_key=>$row)
            <ul class="adslot_row" 
            style="
            grid-template-columns: repeat({{ date('t',strtotime($year_month)) }}, 50px);
            grid-template-rows:  repeat(1, 40px);
            height:40px;
            "
            >
                @foreach($row as $ad_key=>$ad)
            	<li 
                style="
                    grid-column: {{ date('j',strtotime($ad['dates'][array_key_first($ad['dates'])]))  }}/{{ date('j',strtotime($ad['dates'][array_key_last($ad['dates'])]))+1 }};
                    "
                    class="badge-standby" 
                    id=""
                    
                    >
                    {{$ad['name']}}
                </li>
                @endforeach

            </ul>
            @endforeach
            
            <div class="preview_gantt_content_lines" style="grid-template-columns: repeat({{ date('t',strtotime($year_month)) }}, 50px);">
                @for($i=1; $i<= date('t',strtotime($year_month)); $i++)
                <span>
                </span>
                @endfor
            </div>
           
        	 <div class="preview_gantt_content_horizontal_lines" style="grid-template-rows: repeat({{count($rows)}}, 40px);">
                @for($i=1; $i<= count($rows) ; $i++)
                <div>
                </div>
                @endfor
            </div>

        </div>
    </div>
</div>
@endforeach
</html>>
