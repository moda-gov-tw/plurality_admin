<x-base-layout>
@if (session('role_update_message') === 'role.update.success')

    <script type="text/javascript">alert("{{ __('role.role_update_success') }}");</script>

    @elseif(session('role_update_message') === 'role.update.failed')

    <script type="text/javascript">alert("{{ __('role.role_update_failed') }}");</script>

    @endif
<!--begin::Card-->
<div class="card card-custom example example-compact gutter-b">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">{{trans('user-management.roles')}}</h3>
        </div>
        <div class="card-toolbar">
            
        </div>
    </div>
    <!--begin::Card body-->
    <div class="card-body">
        <!--begin::Table-->
        <form id="reload_datatable_form" class="form" method="POST" action="{{ route('datatable.update-admin-row') }}" >
            <input style="display:none" id="update_row_id" name="row_id" value=""/>
            <input style="display:none" id="update_row_user_id" name="user_id" value=""/>
        </form>
        <!-- <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users"> -->
        <table class="table table-head-custom" id="roles_table">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                    <th class="min-w-125px">{{trans('table.thead_role')}}</th>
                    <th class="min-w-125px">{{trans('table.thead_permission')}}</th>
                    <th class="min-w-100px">{{trans('table.thead_actions')}}</th>
                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            @foreach($role_permissions as $key=>$role)
            <tr>
                <td><a href="{{route('role.edit_permission',$role->id)}}" >{{($locale=='zh_TW')?$role->chinese_name:$role->name;}}</a></td>
                <td>
                    @foreach($role->permissions as $p_key => $permission)
                    <span class="badge badge-success badge-inline mr-2 mb-2">{{trans('role.'.$permission->name)}}</span>
                    @endforeach
                </td>
                <td>
                    <div class="d-flex">
<span><a href="{{route('role.edit_permission',$role->id)}}" ><button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" ><i class="nav-icon la la-edit"></i></button></a></span>
                    </div>
                </td>
            </tr>
            @endforeach
            <!--begin::Table body-->
            <tbody>

            </tbody>
            <!--end::Table body-->
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
<!--end::Card-->

</x-base-layout>