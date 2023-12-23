<?php
use App\Http\Controllers\Account\NameController;
use App\Http\Controllers\Account\EmailController;
use App\Http\Controllers\Account\PasswordController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Account\TwoFactorController;



/*
|--------------------------------------------------------------------------
| 帳號 routes
| middleware auth : \App\Http\Middleware\Authenticate::class
| middleware verified : Illuminate\Auth\Middleware\EnsureEmailIsVerified::class
| 
|
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'account', 'middleware' => ['auth','role.assigned']], function()
{
    Route::get('settings', [SettingsController::class, 'index'])->name('account.settings');

    
    Route::group(['prefix' => '{user}', 'middleware' => ['can:update,user']],function(){
        
        // update profile password
        Route::post('update-profile-password', [PasswordController::class, 'update'])->name('profile_password.update');


    });

});


Route::get('/account', function () {
    return redirect('/account/settings');
});

?>