@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/home.css">
@endsection

@section('content')
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="/advertising">广告</a>
            </li>
            @if(Auth::check())
            <li class="nav-item">
              <form action="{{ route('logout') }}" method="POST">
                {{ csrf_field() }}
                  <button type="submit">Logout</button>
              </form>
            </li>
            @endif
          </ul>
        </nav>
        <h3 class="text-muted">微论</h3>
      </div>

      <div class="jumbotron">
        <p><a class="btn btn-lg btn-success" href="#" role="button">Ad your business today</a></p>  
      </div>
      @foreach($posts->chunk(2) as $chunks)
          <div class="row">
              @foreach($chunks as $post)
                <div class="col-lg-6">
                  <h4>{{ $post->title }}</h4>
                  <p>
                    {{ str_limit($post->body, 100) }}
                    <a href="/post/{{ $post->slug }}"><small>更多</small></a>
                  </p>
                </div>
            @endforeach
          </div>
      @endforeach
      <br>
      {{ $posts->links('vendor.pagination.bootstrap-4') }}

      @include('footer')

    </div>
@endsection
