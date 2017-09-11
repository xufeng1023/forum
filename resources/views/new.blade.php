@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="/css/home.css">
@endsection

@section('content')
<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Project name</h3>
      </div>

      <div class="row marketing">
        <div class="col-sm-12">
          <form action="/post" method="POST">
          {{ csrf_field() }}
            <div class="form-group">
              <label>title</label>
              <input type="text" name="title" class="form-control">
            </div>

            <div class="form-group">
              <label>body</label>
              <textarea name="body" class="form-control" rows="6"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>

      <footer class="footer">
        <p>© Company 2017</p>
      </footer>

    </div>
@endsection
