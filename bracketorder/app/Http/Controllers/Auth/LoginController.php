<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect()->with('copyright', Carbon::now()->year);
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if($authUser) {
            return $authUser;
        }

        return User::create([
            'name'   => $user->name,
            'email'       => $user->email,
            'provider'    => strtoupper($provider),
            'provider_id' => $user->id,
            'last_login' => Carbon::now(),
            'user_ip_address' => request()->ip()
        ]);
    }

    /**
     * The user has been authenticated. Overrides AuthenticatesUsers trait
     *
     * @param  mixed $user
     * @return mixed
     * @internal param Request $request
     */
    public function authenticated(Request $request, $user)
    {
        $user->last_login = Carbon::now();
        $user->user_ip_address = $request->ip();

        try {
            $user->save();
            return redirect('/dashboard');
        } catch (Exception $e) {
            echo 'Message: ' .$e->getMessage();
            return redirect('/');
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }
}
