<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Define controller middleware for Laravel 12.
     *
     * @return array
     */
    public static function middleware(): array
    {
        return [
            'guest' => ['except' => ['logout']],
            'auth' => ['only' => ['logout']],
        ];
    }

    protected function credentials(Request $request)
    {
        return [
            'email' => $request->{$this->username()},
            'password' => $request->password,
            'status' => 'active',
        ];
    }


    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->scopes(['email'])->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->CreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect('/');
    }

    public function CreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->where('drop_status', '=', 'no')->first();
        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => 'customer',
            'verified' => 1,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }
}
