@if($exhibition['status'] == 1)
<span class="badge badge-square badge-success" >{{__('content-management.status_'.$exhibition['status'])}}
</span>
@else
<span class="badge badge-square badge-draft border-dashed" >{{__('content-management.status_'.$exhibition['status'])}}
</span>
@endif
