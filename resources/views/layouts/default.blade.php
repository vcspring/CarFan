<!DOCTYPE html>
<html>
  <head>
    <title>
      @yield('title','默认标题')-汽车迷的家园
    </title>
    <link rel="stylesheet" href="/css/app.css">
  </head>
  <body>
    @include('layouts._header')
    <div class="container">
      <div class="col-md-offset-1 col-md-10">
        @include('shared._messages')
        @section('content')
        默认的内容
        @show
        @include('layouts._footer')
      </div>
    </div>
    <div id='app'></div>

    <script src="/js/app.js"></script>
  </body>
</html>