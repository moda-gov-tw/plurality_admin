<x-base-layout>
<div class="card">
    <!--begin: exhibition Form-->
    <form action="{{ route('content-management.modify-exhibition') }}" method="POST" role="form" id="exhibition_form">
    @csrf
    <input name="exhibition_id" value="{{$exhibition['id']}}" class="hidden-input"/>
    <div class="card-body">
            <div class="row mb-10">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{__('content-management.exhibition_date_time')}}<span class="text-danger">*</span></label>
                        <input type="text" class="date form-control @error('exhibition_date') is-invalid @enderror" name="exhibition_date" placeholder="" value="{{ old('exhibition_date',date('Y/m/d H:i a',strtotime($exhibition['exhibition_start_time'])).' - '.date('Y/m/d H:i a',strtotime($exhibition['exhibition_end_time']))) }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="exhibition_date_error" data-field="exhibition_date" data-validator="notEmpty" class="fv-help-block @error('exhibition_date') errors @enderror">{{ $errors->first('exhibition_date') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>{{__('content-management.exhibition_location')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" name="location" placeholder="" value="{{ old('location',$exhibition['location']) }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="location_error" data-field="location" data-validator="notEmpty" class="fv-help-block @error('location') errors @enderror">{{ $errors->first('location') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>{{__('content-management.exhibition_link')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" placeholder="" value="{{ old('link',$exhibition['link']) }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="location_error" data-field="link" data-validator="notEmpty" class="fv-help-block @error('link') errors @enderror">{{ $errors->first('link') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-12">
                    <!--begin::Input-->
                    <div class="form-group">
                        <label>{{__('content-management.title')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ old('title',$exhibition['title']) }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="title_error" data-field="title" data-validator="notEmpty" class="fv-help-block @error('title') errors @enderror">{{ $errors->first('title') }}</div>
                        </div>
                        
                    </div>
                    <!--end::Input-->
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-12">
                    <!--begin::Input-->
                    <div class="form-group">
                        <label>{{__('content-management.excerpt')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" placeholder="" value="{{ old('excerpt',$exhibition['excerpt']) }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="excerpt_error" data-field="excerpt" data-validator="notEmpty" class="fv-help-block @error('excerpt') errors @enderror">{{ $errors->first('excerpt') }}</div>
                        </div>
                        
                    </div>
                    <!--end::Input-->
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>{{__('content-management.content')}}<span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" rows="10" id="exhibition_content" name="content">{{ old('content',$exhibition['content']) }}</textarea>
                        
                        <div class="fv-plugins-message-container">
                                <div id="content_error" data-field="title" data-validator="notEmpty" class="fv-help-block @error('content') errors @enderror">{{ $errors->first('content') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>{{__('content-management.status')}}</label>
                        <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                            @if(old('status',$exhibition['status']) == 'on' ||  old('status',$exhibition['status']) == 1)
                            <input class="form-check-input" type="checkbox" id="flexSwitchDefault" name="status" checked ="checked"/>
                            @else
                            <input class="form-check-input" type="checkbox" id="flexSwitchDefault" name="status"/>
                            @endif
                            
                            <label class="form-check-label" for="flexSwitchDefault"></label>
                        </div>
                    </div>
                </div>
            </div>
        <!--end: exhibition Details-->
                        
    </div>
    <div class="card-footer d-flex justify-content-center py-6 px-9">
        <!--begin::Submit button-->
                <button type="button" id="exhibition_form_submit" class="btn btn-light-warning font-weight-bolder text-uppercase" data-wizard-type="action-submit">
                @include('partials.general._button-indicator', ['label' => __('content-management.edit')])
                </button>
        <!--end::Submit button-->
        
    </div>
    </form>
    <!--end: exhibition Form-->
</div>

</x-base-layout>
