@extends('layouts.default')

@section('content')
  <div class="jumbotron">
    <h1>Hello CarFans!</h1>
    <p class="lead">
        你所看到的是 <a href="https://laravel-china.org/courses/laravel-essential-training-5.1">Laravel 入门教程</a> 的示例项目主页。
    </p>
    <p>
        everything will begin from here.
    </p>
    <p>
        <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">现在注册</a>
    </p>

  </div>
@stop