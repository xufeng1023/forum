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
        <iframe src="//rcm-na.amazon-adsystem.com/e/cm?o=1&p=12&l=ur1&category=hmjewelry2016&banner=10V9Y46HA62YCVDW4Y02&f=ifr&linkID=5153815c013fc2c387d04a91d0e1b794&t=nanafo1985-20&tracking_id=nanafo1985-20" width="300" height="250" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>  
      </div>
      @foreach($blogs->chunk(2) as $chunks)
          <div class="row">
              @foreach($chunks as $blog)
                <div class="col-lg-6">
                  <a href="/blog/{{ $blog->title }}"><h4>{{ $blog->title }}</h4></a>
                  <p>
                    {{ str_limit($blog->body, 100) }}
                    <a href="/blog/{{ $blog->title }}"><small>更多</small></a>
                  </p>
                </div>
            @endforeach
          </div>
      @endforeach
      <br>
      {{ $blogs->links('vendor.pagination.bootstrap-4') }}

      @include('footer')

    </div>
@endsection
