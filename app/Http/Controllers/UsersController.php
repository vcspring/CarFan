<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Request;
use App\Models\User;

use Auth;

class UsersController extends Controller
{
    //用户注册
    public function create()
    {
        return view('users.create');
    }

    public function index(User $user)
    {
        //view方法会返回views目录下的视图，参数'users.show'指向views目录的下级目录users下的show.blade.php视图文件,同时向参数传递参数user
        return view('users.show', compact('user'));
    }

    //控制器方法show的参数$user（变量名user匹配路由片段）
    public function show(User $user)
    {
        //view方法会返回views目录下的视图，参数'users.show'指向views目录的下级目录users下的show.blade.php视图文件,同时向参数传递参数user
        return view('users.show', compact('user'));
    }

    //用户注册，需要对用户输入的数据进行验证
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //用户注册成功后，自动登录
        Auth::login($user);

        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        return redirect()->route('users.show', [$user]);
    }
}
