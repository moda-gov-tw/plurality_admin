<!--begin::Navbar-->
<div class="app-navbar flex-shrink-0">
	<!--begin::User menu-->
	<div class="app-navbar-item ms-1 ms-md-3" id="kt_header_user_menu_toggle">
		<!--begin::Menu wrapper-->
		<div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <img src="{{ auth()->user()->avatarUrl }}" alt="user" />
        </div>
		@include('partials/menus/_user-account-menu')
		<!--end::Menu wrapper-->
	</div>
	<!--end::User menu-->
</div>
<!--end::Navbar-->
