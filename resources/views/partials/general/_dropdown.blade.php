@foreach($channel_groups as $key=>$channel_group)
	<option value="{{$channel_group->id}}">{{$channel_group->name}}</option>
@endforeach