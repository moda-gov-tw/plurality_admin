@if($performance_ads->count()>0)
	@foreach($performance_ads as $key=>$ad)
		<option value="{{$ad->id}}">{{$ad->name}}</option>
	@endforeach
@else
	<option value="">{{__('ad-schedule.no-related-performance-ads')}}</option>
@endif
