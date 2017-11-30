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
                <input type="file" accept="video/*" name="video" id="video">
                <input type="text" name="ratio" id="ratio" hidden>
                <button type="submit">submit</button>
            </form>
            @if(session()->has('gif'))
                <img src="{{ asset('storage/'.session('gif')) }}" width="50">
            @endif
      </div>


      @include('footer')

    </div>
@endsection

@section('script')
  <script>
    $(function() {
        $("#video").change(function (e) {
            if (this.files[0]) {
                var vd = document.createElement('video');
                vd.onprogress = function () {
                    var width = this.videoWidth;
                    var height = this.videoHeight;
                    while((width % 2 === 0) && (height % 2 === 0)) {
                        width = width / 2;
                        height = height / 2;
                    }
                    while((width % 5 === 0) && (height % 5 === 0)) {
                        width = width / 5;
                        height = height / 5;
                    }
                    while((width % 3 === 0) && (height % 3 === 0)) {
                        width = width / 3;
                        height = height / 3;
                    }
                    $('#ratio').val(width + '/' + height);
                }
                vd.src = (window.URL || window.webkitURL).createObjectURL(this.files[0]);
                vd.remove();
            }
        });
    });
  </script>
@endsection
