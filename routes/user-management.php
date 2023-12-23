<?php
use App\Http\Controllers\UserManagement\AdminController;
use App\Http\Controllers\UserManagement\AdminDatatableController;
use App\Http\Controllers\UserManagement\RoleController;
// use App\Http\Controllers\UserManagement\MemberController;
// use App\Http\Controllers\UserManagement\MemberDatatableController;


/*
|--------------------------------------------------------------------------
| 用戶管理 routes ： 後台管理員/會員
| middleware auth : \App\Http\Middleware\RedirectIfAuthenticated::class    
| middleware verified : Illuminate\Auth\Middleware\EnsureEmailIsVerified::class
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'user-management', 'middleware' => ['auth','role:admin']], function()
{
    /*
    |--------------------------------------------------------------------------
    | create user_management
    |--------------------------------------------------------------------------
    */
    Route::get('new', [AdminController::class, 'create'])->middleware(['permission:create user_management'])->name('admin-user.create');
    Route::post('store', [AdminController::class, 'store'])->middleware(['permission:create user_management'])->name('admin-user.store');

    /*
    |--------------------------------------------------------------------------
    | read user_management
    |--------------------------------------------------------------------------
    */
    //後台管理員
    //使用者列表
    Route::get('admin', [AdminController::class, 'index'])->name('user-management.admin-list');
    Route::get('get-admin-users', [AdminDatatableController::class, 'adminUsers'])->name('datatable.get-admin-users');
    Route::get('get-admin-user/{id}', [AdminController::class, 'adminUser']);
    Route::post('get-admin-user-role', [AdminController::class, 'getUserRole'])->name('admin_user_role.get');
    Route::post('delete-admin-user', [AdminController::class, 'destroy'])->middleware(['permission:read user_management|delete user_management']);

    //角色列表
    Route::get('roles', [RoleController::class, 'index'])->middleware(['permission:read role'])->name('role.roles');

    /*
    |--------------------------------------------------------------------------
    | update user_management
    |--------------------------------------------------------------------------
    */
    // Route::post('process-transfer-user', [MemberController::class, 'processTransferUser'])->name('member.process-transfer-user');

    Route::post('update-admin-user-role', [AdminController::class, 'updateUserRole'])->name('admin_user_role.update');

    Route::post('update-admin-datatable-row', [AdminDatatableController::class, 'updateRow'])->name('datatable.update-admin-row');

    Route::get('edit-permission/{id}', [RoleController::class, 'editPermission'])->middleware(['permission:update role'])->name('role.edit_permission');

    Route::post('update-permission', [RoleController::class, 'updatePermission'])->middleware(['permission:update role'])->name('role.update_permission');

    // Route::post('update', [MemberController::class, 'update'])->middleware(['permission:update user_management'])->name('member.update');

    // Route::get('edit/{id}', [MemberController::class, 'edit'])->middleware(['permission:update user_management'])->name('member.edit');

    

    // Route::post('update-member-user-role', [MemberController::class, 'updateUserRole'])->middleware(['permission:update user_management'])->name('member_user_role.update');

    // Route::post('update-member-datatable-row', [MemberDatatableController::class, 'updateRow'])->middleware(['permission:update user_management'])->name('datatable.update-member-row');

    // Route::post('update-member-users-table-header-columns', [MemberDatatableController::class, 'updateMemberUsersTableHeaderColumns'])->middleware(['permission:update user_management'])->name('datatable.update-member-users-table-header-columns');


});




Route::get('/user-management', function () {
    return redirect('/');
});

?>