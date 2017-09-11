@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="/css/post.css">
@endsection

@section('content')
<div class="container">
      <div class="blog-masthead">
      <div class="container">
        <nav class="nav">
          <a class="nav-link" href="/">主页</a>
          <a class="nav-link" href="/advertising">广告</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="row">

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title">{{ $post->title }}</h2>
            <p class="blog-post-meta">发布于: {{ $post->created_at }}</p>

            <p>{{ $post->body }}</p>
          </div>
        </div>

        <div class="col-sm-3 offset-sm-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
          <div class="jumbotron">
              <p><a href="#">Your ad here</a></p>  
              </div>
          </div>
        </div>

      </div>

    </div>
    <hr>
      <footer class="footer">
        <p>© {{ date('Y') }} 微论</p>
      </footer>

    </div>
@endsection
