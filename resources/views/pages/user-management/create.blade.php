<x-base-layout>
<div class="card">
    <!--begin: News Form-->
    <form action="{{ route('admin-user.store') }}" method="POST" role="form" id="create_user_form">
    @csrf
    
    <div class="card-body">
            <div class="row mb-10">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{__('user-management.name')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="" value="{{ old('name') }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="name_error" data-field="name" data-validator="notEmpty" class="fv-help-block @error('name') errors @enderror">{{ $errors->first('name') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{__('user-management.email')}}<span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="" value="{{ old('email') }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="email_error" data-field="email" data-validator="notEmpty" class="fv-help-block @error('email') errors @enderror">{{ $errors->first('email') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{__('user-management.role')}}<span class="text-danger">*</span></label>
                        <select class="form-control" name="role">
                            @foreach($all_roles as $key=>$role)
                                <option value="{{$role->name}}" @if(old('role') == $role->name) selected @endif>
                                    {{ ($locale=='zh_TW')?(($role->name=='not_assigned')?trans('user-management.'.$role->name):$role->chinese_name):$role->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        <div class="fv-plugins-message-container">
                                <div id="role_error" data-field="role" data-validator="notEmpty" class="fv-help-block @error('role') errors @enderror">{{ $errors->first('role') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-10">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{__('user-management.password')}}<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="" value="" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="password_error" data-field="password" data-validator="notEmpty" class="fv-help-block @error('password') errors @enderror">{{ $errors->first('password') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>{{__('user-management.password_confirmation')}}<span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="" value="{{ old('password_confirmation') }}" />
                        
                        <div class="fv-plugins-message-container">
                                <div id="password_confirmation_error" data-field="password_confirmation" data-validator="notEmpty" class="fv-help-block @error('password_confirmation') errors @enderror">{{ $errors->first('password_confirmation') }}</div>
                        </div>
                    </div>
                </div>
            </div>
           
        <!--end: News Details-->
                        
    </div>
    <div class="card-footer d-flex justify-content-center py-6 px-9">
        <!--begin::Submit button-->
                <button type="button" id="create_user_form_submit" class="btn btn-light-success font-weight-bolder text-uppercase" data-wizard-type="action-submit">
                @include('partials.general._button-indicator', ['label' => __('user-management.create')])
                </button>
        <!--end::Submit button-->
        
    </div>
    </form>
    <!--end: News Form-->
</div>

</x-base-layout>
