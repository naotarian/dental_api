<?php

namespace App\Http\Controllers\Auth\Portal;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended(config('app.frontend_url').RouteServiceProvider::HOME)
                    : redirect(config('app.frontend_url').'/email/verify');
    }
}
