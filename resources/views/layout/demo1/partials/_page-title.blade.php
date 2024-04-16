@php
    $breadcrumb = \App\Core\Bootstraps\BootstrapDemo1::getBreadcrumb();
    
@endphp
<!--begin::Page title-->
<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
	<!--begin::Breadcrumb-->
	<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
		@foreach ($breadcrumb as $key=>$item)
			<!--breadcrumb bullet-->
				<li class="breadcrumb-item text-muted">
					@if($item['path'] != '' && (!$item['active']))
						<a href="/{{$item['path']}}">{{ __('breadcrumb.'.$item['title']) }}</a>
					@else
						{{ __('breadcrumb.'.$item['title']) }}
					@endif
	                
	            </li>

            	@if($key != 0)
	            <li class="breadcrumb-item">
					<span class="bullet bg-gray-400 w-5px h-2px"></span>
				</li>
            	@endif
            
        @endforeach
		
	</ul>
	<!--end::Breadcrumb-->
</div>
<!--end::Page title-->
