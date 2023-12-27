<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Models\AdminUser as User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthenticatedSessionController extends Controller
{

    public function AADCallback(Request $request){
        // echo "<pre>";print_r($request->all());echo "</pre>";exit;

        $user = Socialite::driver('azure')->user();
        // echo "<pre>";print_r($user);echo "</pre>";
        
        $email = explode("#EXT#@", $user->email);

        $user_email = str_replace('_', '@', $email[0]);
        
        $admin_user = User::where('email',$user_email)->first();

        if(!is_null($admin_user)){
            $admin_user->update(['name'=>$user->name, 'token'=>$user->token]);
        }
        else{
            $admin_user = User::create([
                'name'              => $user->name,
                'email'             => $user_email,
                'email_verified_at' => now(),
                'token'=>$user->token
            ]);

            $admin_user->syncRoles('editor');
        }

        

        Auth::login($admin_user);

        $request->session()->regenerate();

        
        
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return Socialite::driver('azure')->redirect();
        // return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Handle an incoming api authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function apiStore(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect']
            ]);
        }

        $user = User::where('email', $request->email)->first();
        return response($user);
    }

    /**
     * Verifies user token.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function apiVerifyToken(Request $request)
    {
        $request->validate([
            'api_token' => 'required'
        ]);

        $user = User::where('api_token', $request->api_token)->first();

        if(!$user){
            throw ValidationException::withMessages([
                'token' => ['Invalid token']
            ]);
        }
        return response($user);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $request->session()->flush();
        
        $azureLogoutUrl = Socialite::driver('azure')->getLogoutUrl(route('login'));

        Auth::guard('web')->logout();

        return redirect($azureLogoutUrl);

        // return redirect('/');
    }
}
