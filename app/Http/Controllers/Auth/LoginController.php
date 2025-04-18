<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Controllers\Middleware;

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
}
