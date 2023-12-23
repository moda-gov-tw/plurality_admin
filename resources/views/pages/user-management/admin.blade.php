<x-base-layout>
    @if (session('user_create_message') === 'success')

    <script type="text/javascript">alert("{{ __('user-management.create_user_success') }}");</script>

    @elseif (session('user_create_message') === 'failed')

    <script type="text/javascript">alert("{{ __('user-management.create_user_failed') }}");</script>

    @endif
<!--begin::Modal Container-->
{{ theme()->getView('partials/modals/user-management/_change_admin_user_role_container') }}
<!--end::Modal Container-->
<!--begin::Card-->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">&nbsp;</h3>
        <div class="card-toolbar">
            <a class="btn btn-sm btn-success" href="{{route('admin-user.create')}}">
                {{__('user-management.create-user')}}
            </a>
        </div>
    </div>
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Table-->
        <form id="reload_datatable_form" class="form" method="POST" action="{{ route('datatable.update-admin-row') }}" >
            <input style="display:none" id="update_row_id" name="row_id" value=""/>
            <input style="display:none" id="update_row_user_id" name="user_id" value=""/>
        </form>
        <table class="table table-separate table-head-custom" id="kt_table_users">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{trans('table.thead_user')}}</th>
                    <th class="min-w-125px">{{trans('table.thead_role')}}</th>
                    <th class="min-w-125px">{{trans('table.thead_joined_date')}}</th>
                    <th class="min-w-100px">{{trans('table.thead_actions')}}</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->
            
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

</x-base-layout>