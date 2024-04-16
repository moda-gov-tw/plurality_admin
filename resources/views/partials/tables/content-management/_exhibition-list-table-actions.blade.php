<div class="d-flex">
	<a href="{{route('content-management.edit-exhibition').'?exhibition_id='.$exhibition['id']}}" 
	>{{__('table.edit')}}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:;" class="delete-exhibition" data-exhibition-id="{{$exhibition['id']}}"
	>{{__('table.delete')}}</a>
	
</div>
