@extends('index')
@section('content')
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                
                <li class=""><a href="{{url('tin-tuc')}}" title="">Tin tức</a></li>
                <li class="active">{{$news_detail->name}}</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-home-cate">
    <div class="container">
        <div class="row">
            <div class="content_detail">
                {!! $news_detail->content !!}
            </div>
            
        </div>
        <div class="row" style="margin-top: 30px;">
        <h3>Bài viết liên quan</h3>
        <div class="owl-carousel owl-carousel-slider owl-carousel-product owl-theme">
            @foreach($newsSameCate as $post)
            <div class="item">
                <a href="{{url('tin-tuc/'.$post->alias.'.html')}}" title="{{$post->name}}">
                    <img src="{{asset('upload/news/'.$post->photo)}}" alt="{{$post->name}}">
                    <p class="name">{{$post->name}}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</div>
@endsection