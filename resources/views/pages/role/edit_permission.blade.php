<x-base-layout>
<div class="row">
    <div class="col-lg-12">
        <!--begin::Card-->
                                        <div class="card card-custom gutter-b example example-compact">
                                            <div class="card-header">
                                                <h3 class="card-title">{{($locale=='zh_TW')?$role->chinese_name:$role->name}}</h3>
                                            </div>
                                            <!--begin::Form-->
                                            <form id="update_permissions_form" class="form" method="POST" action="{{ route('role.update_permission',) }}" >
                                            <input name="role_id" value="{{$role->id}}" style="display:none;" />
                                            @csrf
                                                <div class="card-body">
                                                    @foreach($allowed_permissions as $key=>$allowed_permission)
                                                    <div class="form-group">
                                                        <label><h4>{{($locale=='zh_TW')?trans('role.'.$allowed_permission):$allowed_permission}}</h4></label>
                                                        <div class="flex d-flex">
                                                            @foreach($all_permissions as $p_key=>$permission)
                                                                @if(strpos($permission->name,$allowed_permission) !== false)
                                                                
                                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                                    <input class="form-check-input" type="checkbox" value="{{$permission->name}}" 
                                                                    name="permissions[]"
                                                                    @if($role->hasPermissionTo($permission->name)) checked @endif
                                                                    />
                                                                    <label class="form-check-label me-5 ms-1" >
                                                                        {{($locale=='zh_TW')?trans('role.'.$permission->name):$permission->name}}
                                                                    </label>
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="separator separator-dashed my-10"></div>
                                                    @endforeach
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row text-lg-center">
                                                        <div class="col-12">
                                                            <!--begin::Submit button-->
                                                            <button type="submit" id="update_role_submit" class="btn btn-light-primary font-weight-bold">
                                                            @include('partials.general._button-indicator', ['label' => trans('role.update_role')])
                                                            </button>
                                                           
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Card-->
    </div>
</div>
</x-base-layout>