@extends('base.base')

@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
            
            <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Aside-->
                <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <!--begin::Aside-->
                    <div class="d-flex flex-center flex-lg-start flex-column">
                        <!--begin::Logo-->
                        <!-- <a href="#" class="mb-7">
                            <img style="width:326px;"alt="Logo" src="{{ asset(theme()->getMediaUrlPath() . 'logos/dos-logo-1.svg') }}" />
                        </a> -->
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <!-- <h2 class="text-white fw-normal m-0">Branding tools designed for your business</h2> -->
                        <!--end::Title-->
                    </div>
                    <!--begin::Aside-->
                </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <!--begin::Form-->
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        {{ $slot }}
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Form-->
                
            </div>
            <!--end::Body-->
            
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
@endsection
