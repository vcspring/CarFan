<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

/*
|--------------------------------------------------------------------------
|登录、登出会话控制器
|--------------------------------------------------------------------------
|
*/
class SessionsController extends Controller
{
    //到达登录页面
    public function create()
    {
        return view('sessions.create');
    }

    //用户登录请求的处理
    public function store(Request $request)
    {
       $credentials = $this->validate($request, [
           'email' => 'required|email|max:255',
           'password' => 'required'
       ]);

       if (Auth::attempt($credentials, $request->has('remember'))) {
           // 登录成功后的相关操作
           session()->flash('success', '欢迎回来！');
           return redirect()->route('users.show', [Auth::user()]);
       } else {
           // 登录失败后的相关操作
           session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
           return redirect()->back();
       }

       return;
    }

    //用户退出登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
