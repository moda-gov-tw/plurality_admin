@foreach($regions as $key=>$region)
	<option value="{{$region->id}}">{{$region->name}}</option>
@endforeach