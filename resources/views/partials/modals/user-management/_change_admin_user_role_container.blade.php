<!--begin::Modal - Change User Role-->
<div class="modal fade" id="modal_change_user_role" tabindex="-1" aria-hidden="true" role="dialog">
    <form id="get_user_role_form" class="form" method="POST" action="{{ route('admin_user_role.get') }}" >
        @csrf
        <input class="hidden-input" id="get_user_role_id" name="user_id" value=""/>
    </form>
    
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content"></div>
    </div>
</div>
<!--end::Modal - Change User Role-->