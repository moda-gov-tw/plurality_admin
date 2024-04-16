@if($news['status'] == 1)
<span class="badge badge-square badge-success" >{{__('content-management.status_'.$news['status'])}}
</span>
@else
<span class="badge badge-square badge-draft border-dashed" >{{__('content-management.status_'.$news['status'])}}
</span>
@endif
