@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="/css/home.css">
@endsection

@section('content')
<div class="container">
      <div class="header clearfix">
        <h3 class="text-muted">微论</h3>
      </div>

      <div class="row marketing">
        <div class="col-sm-12">
          <form action="/post" method="POST">
          {{ csrf_field() }}
            <div class="form-group">
              <label>Image title</label>
              <input type="text" name="title" class="form-control">
            </div>

            <div class="form-group">
              <label>Start date</label>
              <input type="date" name="date-start" class="form-control">
            </div>

            <div class="form-group">
              <label>End date</label>
              <input type="date" name="date-end" class="form-control">
            </div>

            <div class="form-group">
              <label>Image</label>
              <input type="file" name="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Next</button>
          </form>
        </div>
      </div>

      @include('footer')

    </div>
@endsection
