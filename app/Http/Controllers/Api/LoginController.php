<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * ログイン
     */
    public function login(Request $request) {
        $result = false;
        $message = '';
        $user = [];
        // dd($request);
        // dd($request->parameters);
        // dd($request->email,$request->password);
        $credentials = $request->only('email', 'password');
        // dd($credentials);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $result = true;
        } else {
            $message = 'EmailまたはPasswordが間違っています。';
        }
        return response()->json(['result' => $result, 'message' => $message]);
    }
    /**
     * ログアウト
     */
    public function logout(Request $request) {
        $result = true;
        $message = 'ログアウトしました。';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['result' => $result, 'message' => $message]);
    }
    /**
     * ユーザ情報
     */
    public function auth() {
        $result = false;
        $user = [];
        if (Auth::check()) {
            $user = Auth::user();
            $result = true;
        }
        return response()->json(['result' => $result, 'user' => $user]);
    }
}