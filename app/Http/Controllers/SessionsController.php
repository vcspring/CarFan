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
    //对控制器动作进行过滤，只有guest才可以注册
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
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
           if(Auth::user()->activated) {
               session()->flash('success', '欢迎回来！');
               return redirect()->intended(route('users.show', [Auth::user()]));
           } else {
               Auth::logout();
               session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
               return redirect('/');
           }
       } else {
           session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
           return redirect()->back();
       }
    }

    //用户退出登录
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }
}
