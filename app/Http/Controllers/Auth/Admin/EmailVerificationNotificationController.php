<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return;
        }
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        $decode_user = json_decode($request->user(), true);
        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson() ?
            response()->json(['status' => 'verification-link-sent']) :
            back()->with('status', 'verification-link-sent');
    }
}
