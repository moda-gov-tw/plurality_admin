<x-base-layout>
<div class="card">
    <!--begin: News Form-->
    <form action="{{ route('content-management.store-news') }}" method="POST" role="form" id="news_form">
    @csrf
    
    <div class="card-body">
            <div class="row mb-10">
                <div class="col-xl-2">
                    <div class="form-group">
                        <label>{{__('content-management.news_date')}}<span class="text-danger">*</span></label>
                        <input type="text" class="date form-control @error('news_date') is-invalid @enderror" name="news_date" placeholder="" value="{{ old('news_date') }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="news_date_error" data-field="news_date" data-validator="notEmpty" class="fv-help-block @error('news_date') errors @enderror">{{ $errors->first('news_date') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-12">
                    <!--begin::Input-->
                    <div class="form-group">
                        <label>{{__('content-management.title')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="" value="{{ old('title') }}" />
                        
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
                        <input type="text" class="form-control @error('excerpt') is-invalid @enderror" name="excerpt" placeholder="" value="{{ old('excerpt') }}" />
                        
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
                        <textarea class="form-control @error('content') is-invalid @enderror" rows="10" id="news_content" name="content">{{ old('content') }}</textarea>
                        
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
                            <input class="form-check-input" type="checkbox" id="flexSwitchDefault" name="status" @if(old('status')=='on') checked @endif/>
                            <label class="form-check-label" for="flexSwitchDefault"></label>
                        </div>
                    </div>
                </div>
            </div>
        <!--end: News Details-->
                        
    </div>
    <div class="card-footer d-flex justify-content-center py-6 px-9">
        <!--begin::Submit button-->
                <button type="button" id="news_form_submit" class="btn btn-light-success font-weight-bolder text-uppercase" data-wizard-type="action-submit">
                @include('partials.general._button-indicator', ['label' => __('content-management.create')])
                </button>
        <!--end::Submit button-->
        
    </div>
    </form>
    <!--end: News Form-->
</div>

</x-base-layout>