
<button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3" 
data-kt-users-table-filter="change_user_row" 
data-bs-toggle="modal" 
data-bs-target="#modal_change_user_role" 
data-user-id={{$user->id}} 
data-row-id={{$row_id}}>
															<i class="nav-icon la la-edit"></i>
														</button>

<button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3 delete-user" data-kt-users-table-filter="delete_user_row" data-user-id={{$user->id}}>
															<i class="nav-icon la la-trash"></i>
														</button>

