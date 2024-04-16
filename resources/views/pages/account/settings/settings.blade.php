<x-base-layout>
<!--begin::Card-->
<div class="card card-custom">
    <!--begin::Card header-->
    <div class="card-header card-header-tabs-line nav-tabs-line-3x">
        <!--begin::Toolbar-->
        <div class="card-toolbar">
            <ul class="nav nav-tabs nav-bold nav-tabs-line nav-tabs-line-3x">
                <!--begin::Item-->
                
                    
                    <!--begin::Item-->
                    <li class="nav-item mr-3">
                        <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_2">
                            <span class="nav-icon">
                                <span class="svg-icon">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Shield-user.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path d="M4,4 L11.6314229,2.5691082 C11.8750185,2.52343403 12.1249815,2.52343403 12.3685771,2.5691082 L20,4 L20,13.2830094 C20,16.2173861 18.4883464,18.9447835 16,20.5 L12.5299989,22.6687507 C12.2057287,22.8714196 11.7942713,22.8714196 11.4700011,22.6687507 L8,20.5 C5.51165358,18.9447835 4,16.2173861 4,13.2830094 L4,4 Z" fill="#000000" opacity="0.3" />
                                            <path d="M12,11 C10.8954305,11 10,10.1045695 10,9 C10,7.8954305 10.8954305,7 12,7 C13.1045695,7 14,7.8954305 14,9 C14,10.1045695 13.1045695,11 12,11 Z" fill="#000000" opacity="0.3" />
                                            <path d="M7.00036205,16.4995035 C7.21569918,13.5165724 9.36772908,12 11.9907452,12 C14.6506758,12 16.8360465,13.4332455 16.9988413,16.5 C17.0053266,16.6221713 16.9988413,17 16.5815,17 C14.5228466,17 11.463736,17 7.4041679,17 C7.26484009,17 6.98863236,16.6619875 7.00036205,16.4995035 Z" fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                            <span class="nav-text font-size-lg">{{trans('account.password_details')}}</span>
                        </a>
                    </li>
                    <!--end::Item-->
                    
                </ul>
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card header-->
        <!--begin::Card body-->
        <div class="card-body">
            
                <div class="tab-content">
                    
                    <!--begin::Tab-->
                    <div class="tab-pane show active px-7" id="kt_user_edit_tab_2" role="tabpanel">
                        <form id="kt_signin_change_password" class="form" method="POST" action="{{ route('profile_password.update', Auth::user()) }}" >
                                                    @csrf
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Row-->
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-7">
                                    
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">{{trans('account.current_password')}}</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-lg form-control-solid mb-1" type="password" name="currentpassword" id="currentpassword" />
                                            <div class="fv-plugins-message-container">
                                                <div data-field="currentpassword" data-validator="notEmpty" id="currentpassword_error" class="fv-help-block errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">{{trans('account.new_password')}}</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-lg form-control-solid" type="password" name="newpassword" id="newpassword" />
                                            <div class="fv-plugins-message-container">
                                                <div data-field="newpassword" data-validator="notEmpty" id="newpassword_error" class="fv-help-block errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                    <!--begin::Group-->
                                    <div class="form-group row">
                                        <label class="col-form-label col-3 text-lg-right text-left">{{trans('account.confirme_password')}}</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-lg form-control-solid" type="password" name="newpassword_confirmation" id="newpassword_confirmation" />
                                            <div class="fv-plugins-message-container">
                                                <div data-field="newpassword_confirmation" data-validator="notEmpty" id="newpassword_confirmation_error" class="fv-help-block errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Group-->
                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Body-->
                        <!--begin::Footer-->
                        <div class="card-footer pb-0">
                            <div class="row text-lg-center">
                                <div class="col-12">
                                    <!--begin::Submit button-->
                                    <button type="submit" id="kt_password_submit" class="btn btn-light-primary font-weight-bold">
                                    @include('partials.general._button-indicator', ['label' => trans('account.update_password')])
                                    </button>
                                    <!--end::Submit button-->
                                </div>
                            </div>
                        </div>
                        <!--end::Footer-->
                        </form>
                    </div>
                    <!--end::Tab-->
                    
                    
                    </div>
                    </div>
                    <!--begin::Card body-->
            </div>
            <!--end::Card-->
</x-base-layout>