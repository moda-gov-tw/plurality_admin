
                                                <form id="update_user_role_form" class="form" method="POST" action="{{ route('admin_user_role.update')}}" >
                                                    @csrf
                                                    <input style="display:none;" id="update_user_role" name="user_id" value="{{$user->id}}"/>
                                                
                                                        <!--begin::Modal header-->
                                                        <div class="modal-header" id="kt_modal_add_user_header">
                                                            <!--begin::Modal title-->
                                                            <h2 class="fw-bolder">{{trans('user-management.change_user_role')}}</h2>
                                                            <!--end::Modal title-->
                                                            <!--begin::Close-->
                                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-label="close" data-dismiss="modal">
                                                                <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
                                                                <span class="svg-icon svg-icon-1">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                        <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
                                                                            <rect fill="#000000" x="0" y="7" width="16" height="2" rx="1" />
                                                                            <rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1" />
                                                                        </g>
                                                                    </svg>
                                                                </span>
                                                                <!--end::Svg Icon-->
                                                            </div>
                                                            <!--end::Close-->
                                                        </div>
                                                        <!--end::Modal header-->
                                                        <!--begin::Modal body-->
                                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                                            <!--begin::Form-->
                                                            <form id="kt_modal_add_user_form" class="form" action="{{ route('admin_user_role.update', Auth::user()->id) }}">
                                                                <!--begin::Scroll-->
                                                                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                                                                    <!--begin::Input group-->
                                                                    <div class="fv-row mb-7">
                                                                        <!--begin::Name-->
                                                                            <a href="javascript:;" class="d-flex align-items-center fs-5 fw-bolder text-dark text-hover-primary">{{$user->name}}</a>
                                                                            <!--end::Name-->
                                                                            <!--begin::Email-->
                                                                            <div class="fw-bold text-gray-400">{{$user->email}}</div>
                                                                            <!--end::Email-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                    <div class='separator separator-dashed my-5'></div>
                                                                    <!--begin::Input group-->
                                                                    <div class="mb-7">
                                                                        <!--begin::Label-->
                                                                        <label class="fw-bold fs-6 mb-5">{{trans('user-management.role')}}</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Roles-->
                                                                        @foreach($all_roles as $key => $role)
                                                                            <!--begin::Input row-->
                                                                            <div class="d-flex fv-row">
                                                                                <!--begin::Radio-->
                                                                                <div class="form-check form-check-custom form-check-solid">
                                                                                    <!--begin::Input-->
                                                                                    <input class="form-check-input me-3" name="role" type="radio" value="{{$role->name}}" 
                                                                                    {{ ($current_role == $role->name ) ?'checked':(($current_role== '')?'checked':'') }}
                                                                                    />
                                                                                    <!--end::Input-->
                                                                                    <!--begin::Label-->
                                                                                    <label class="form-check-label" for="kt_modal_update_role_option_0">
                                                                                        <div class="fw-bolder text-gray-800">{{ ($locale=='zh_TW')?(($role->name=='not_assigned')?trans('user-management.'.$role->name):$role->chinese_name):$role->name }}</div>
                                                                                    </label>
                                                                                    <!--end::Label-->
                                                                                </div>
                                                                                <!--end::Radio-->
                                                                            </div>
                                                                            <!--end::Input row-->
                                                                            <div class='separator separator-dashed my-5'></div>
                                                                        @endforeach
                                                                        <!--end::Roles-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--end::Scroll-->
                                                                <!--begin::Actions-->
                                                                <div class="text-center pt-15">
                                                                    <button type="button" class="btn btn-primary" id="update_user_role_submit">
                                                                         @include('partials.general._button-indicator', ['label' => trans('user-management.submit')])
                                                                    </button>
                                                                    <button type="reset" class="btn btn-white me-3" data-label="close" data-bs-dismiss="modal">{{trans('user-management.discard')}}</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </form>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Modal body-->
                                                        </form>