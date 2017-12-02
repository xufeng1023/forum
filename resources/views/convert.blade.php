@extends('layouts.app')

@section('style')
    <link rel="stylesheet" type="text/css" href="css/home.css">
@endsection

@section('content')
    <nav class="navbar navbar-light bg-light justify-content-between">
        <div class="navbar-brand">
            <h1 class="font16 no-margin">属于自己的表情包</h1>
            <small class="text-muted font12">录制一段几秒钟的视频转化成表情</small>
        </div>
        <button id="record" class="btn btn-success my-2 my-sm-0">开始</button>
        <form class="form-inline" method="post" action="/convert" enctype="multipart/form-data" hidden>
            {{ csrf_field() }}
            <input type="file" accept="video/*" name="video" id="video">
            <button type="submit">submit</button>
        </form>
    </nav>
<div class="container-fluid">
   <!--  <div class="progress">
        <div class="progress-bar" style="height: 1px; display: none;" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div> -->
@if(session()->has('gif'))
    <div class="jumbotron text-center no-margin">
        <p id="output">
            <!-- <a href="weixin://viewimage/{{ asset('storage/'.session('gif')) }}"> -->
                <img src="{{ asset('storage/'.session('gif')) }}" width="50%">
            <!-- </a> -->
        </p>
        <div id="imgSize">{{ session('size') }}</div>
        <small class="form-text text-muted">按住图片保存</small>
    </div>
    <div>
        <small class="text-muted font11">小提示: 小于1M的图片还可以保存到微信自定义表情>_<</small>
    </div>
    @endif
</div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#record').click(function() {
                $("#video").click();
            });

            $("#video").change(function (e) {
                if (this.files[0]) {
                    if((this.files[0]).size >10400000) {
                        return alert('视频有点大啊...');
                    }
                    $(this).parents('form').submit();
                    // var fm = new FormData;
                    // fm.append('_token', $('[name=_token]').val());
                    // fm.append('video', this.files[0])

                    
                    // $.ajax('/convert', {
                    //     type: 'post',
                    //     data: fm,
                    //     processData: false,
                    //     contentType: false,
                    //     xhr: function() {
                    //         var xhr = new XMLHttpRequest(); 
                    //         (xhr.upload || xhr).addEventListener('progress', function(e) {
                    //             var done = e.position || e.loaded
                    //             var total = e.totalSize || e.total;
                    //             $('.progress-bar').css(
                    //                 {
                    //                     width: Math.round(done/total*100) + '%',
                    //                     display: 'block'
                    //                 }
                    //             );
                    //         }); 
                    //         return xhr;
                    //     },
                    //     success: function(data) {
                    //         // if(window.WeixinJSBridge !== undefined) {
                    //         //     WeixinJSBridge.invoke('imagePreview', {
                    //         //         current: data,
                    //         //         urls: [data]
                    //         //     }, function(e) {
                    //         //         alert('not support')
                    //         //     })
                    //         // }
                    //         $('#output img').prop('src', data.url);
                    //         $('#output a').attr('href', "weixin://viewimage/"+data.url);
                    //         $('#imgSize').text((data.size / 1024 / 1024).toFixed(2)+'M');
                    //         $('.jumbotron').css('display' ,'inherit');
                    //     },
                    //     complete: function() {
                    //         $('.progress-bar').css(
                    //             {
                    //                 display: 'none',
                    //                 width: 0
                    //             }
                    //         );
                    //         $('#video').val('')
                    //     }
                    // })
                }
            });
        });
    </script>
@endsection
