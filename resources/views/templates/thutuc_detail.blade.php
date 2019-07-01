@extends('index')
@section('content')
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb breadcrumbx">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                <li><a href="{{url('thu-tuc')}}">Thủ tục</a></li>
                <li class="active">{{$news_detail->name}}</li>
            </ol>
        </div>
    </div>
</div>
<div class="box-home box-cate-news">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="name_detail">{{$news_detail->name}}</h1>                
                <div class="content_detail">
                    {!! $news_detail->content !!}
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <h3 class="news_hot">Tin nổi bật</h3>
                <div class="list-hot-news">
                    @foreach($newsSameCate as $post)
                    <p><a href="{{url('thu-tuc/'.$post->alias.'.html')}}" title="{{$post->name}}">{{$post->name}}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

