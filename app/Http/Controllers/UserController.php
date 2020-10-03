<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoyalCustomer;//user model can kiem tra
use Auth; //use thư viện auth

class UserController extends Controller
{
    public function getLogin()
    {
        return view('login');//return ra trang login để đăng nhập
    }

    public function postLogin(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'bail|required|email',
            'password' => 'bail|required',
        ]);
        $arr = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if ($request->remember == trans('remember.Remember Me')) {
            $remember = true;
        } else {
            $remember = false;
        }
        //kiểm tra trường remember có được chọn hay không
        
        if (Auth::guard('web')->attempt($arr)) {

            return redirect()->route("admin.dashboard");

            //..code tùy chọn
            //đăng nhập thành công thì hiển thị thông báo đăng nhập thành công
        } else {

            return redirect()->route("admin.login");
            //...code tùy chọn
            //đăng nhập thất bại hiển thị đăng nhập thất bại
        }
    }
    public function logout(Request $req) {
        Auth::logout();
        return redirect()->route("admin.login");
    }
    
}