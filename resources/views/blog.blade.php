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
          <a class="nav-link" href="#">广告</a>
        </nav>
      </div>
    </div>

    <div class="container">

      <div class="row">

        <div class="col-sm-8 blog-main">

          <div class="blog-post">
            <h2 class="blog-post-title">{{ $blog->title }}</h2>
            <p class="blog-post-meta">发布于: {{ $blog->created_at }}</p>

            <p>{{ $blog->body }}</p>
          </div>
        </div>

        <div class="col-sm-3 offset-sm-1 blog-sidebar">
          <div class="sidebar-module sidebar-module-inset">
            <div>
                <p>
                    <a target="_blank"  href="https://www.amazon.com/gp/product/B073H7L61P/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B073H7L61P&linkCode=as2&tag=amazoncheapbuy.com-20&linkId=92da50ced95c57b654e0fa9577588526"><img width="100%" border="0" src="//ws-na.amazon-adsystem.com/widgets/q?_encoding=UTF8&MarketPlace=US&ASIN=B073H7L61P&ServiceVersion=20070822&ID=AsinImage&WS=1&Format=_SL250_&tag=amazoncheapbuy.com-20" ></a><img src="//ir-na.amazon-adsystem.com/e/ir?t=amazoncheapbuy.com-20&l=am2&o=1&a=B073H7L61P" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />
                </p>  
                <a target="_blank"  href="https://www.amazon.com/gp/product/B073H7L61P/ref=as_li_tl?ie=UTF8&camp=1789&creative=9325&creativeASIN=B073H7L61P&linkCode=as2&tag=amazoncheapbuy.com-20&linkId=92da50ced95c57b654e0fa9577588526">
                <h4>
                    Cadier卡迪尔女性手包原价$121.89现在只要$26.99
                </h4>
                <h5>9种颜色可选</h5>
                <h5>点这里到店购买</h5>
            </a>
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
