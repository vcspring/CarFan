<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Request;
use App\Models\User;

use Auth;

class UsersController extends Controller
{
    //在构造函数中添加中间件，指明过滤机制
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
    //用户注册
    public function create()
    {
        return view('users.create');
    }

    public function index(User $user)
    {
        //view方法会返回views目录下的视图，参数'users.show'指向views目录的下级目录users下的show.blade.php视图文件,同时向参数传递参数user
        $users = User::paginate(10);
        return view('users.index', compact('users'));
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

    //用户信息编辑
    public function edit(User $user)
    {
        $this->authorize('update', $user);//授权策略需要
        return view('users.edit', compact('user'));
    }

    //用户信息更新，并重定向
    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);//授权策略需要

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');

        return redirect()->route('users.show', $user->id);
    }
    //删除用户动作
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}
