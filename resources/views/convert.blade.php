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
              <a class="nav-link active" href="#">广告</a>
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
            <form method="post" action="/convert" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" accept="video/*" name="video">
                <button type="submit">submit</button>
            </form>
            @if(session()->has('gif'))
                <img src="{{ asset('storage/'.session('gif')) }}" width="50">
            @endif
      </div>


      @include('footer')

    </div>
@endsection
