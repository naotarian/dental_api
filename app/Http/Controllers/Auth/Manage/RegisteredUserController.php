<?php

namespace App\Http\Controllers\Auth\Manage;

use App\Http\Controllers\Controller;
use App\Models\Manage;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:admin'); // 'auth:admin'に変更
    }
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        $datas = $request->all();
        $datas['email'] = openssl_encrypt($request->email, $aes_type, $aes_key);
        $datas['email_normal'] = $request->email;
        $rules = array();
        $messages = array();
        $rules['name'] = ['required', 'string', 'max:255'];
        $rules['email_normal'] = ['required', 'string', 'email:strict,dns,spoof', 'max:255'];
        $rules['email'] = ['unique:manages'];
        $rules['password'] = ['required', 'string', 'confirmed', 'min:8'];
        //name
        $messages['name.max'] = '氏名は255文字以内で入力してください。';
        $messages['name.required'] = '氏名は必須項目です。';
        $messages['name.string'] = '氏名は文字列で入力してください。';
        //email
        $messages['email_normal.string'] = 'メールアドレスは文字列で入力してください。';
        $messages['email_normal.required'] = 'メールアドレスは必須項目です。';
        $messages['email_normal.email'] = 'メールアドレスはアドレス形式で入力してください。';
        $messages['email.unique'] = 'このメールアドレスはすでに使用されています。';
        //password
        $messages['password.required'] = 'パスワードは必須項目です。';
        $messages['password.string'] = 'パスワードは文字列で入力してください。';
        $messages['password.confirmed'] = '確認用パスワードと一致しません。';
        $messages['password.min'] = 'パスワードは最低8文字で設定してください。';
        $validator = Validator::make($datas, $rules, $messages);
        if ($validator->fails()) {
            return response()->json($validator->messages());
        }
        $user = Manage::create([
            'name' => openssl_encrypt($request->name, $aes_type, $aes_key),
            'email' => openssl_encrypt($request->email, $aes_type, $aes_key),
            'password' => Hash::make($request->password),
        ]);
        Auth::guard('manages')->login($user);
        event(new Registered($user));
        return response()->noContent();
    }
}
