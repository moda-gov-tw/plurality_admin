<div class="d-flex">
	<a href="{{route('content-management.edit-news').'?news_id='.$news['id']}}" 
	>{{__('table.edit')}}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="javascript:;" class="delete-news" data-news-id="{{$news['id']}}"
	>{{__('table.delete')}}</a>
	
</div>
