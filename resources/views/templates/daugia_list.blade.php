@extends('index')
@section('content')
<?php
    $setting = Cache::get('setting');
?>
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                <li class="active">{{$tintuc_cate->name}}</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-home-cate mt-0">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="list-item-news news-fix">
                    @foreach($tintuc as $item)
                    <div class="box-item">
                        <div class="col-md-3 pdl-0">
                            <a href="{{url('tin-dau-gia/'.$item->alias.'.html')}}"><img src="{{asset('upload/news/'.$item->photo)}}"></a>
                        </div>
                        <div class="col-md-9 pdl-0 pdr-0">
                            <p class="name_news"><a href="{{url('tin-dau-gia/'.$item->alias.'.html')}}" title="{{$item->name}}">{{$item->name}}</a></p>
                            <div class="des-news">{!! $item->mota !!}</div>                            
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <h3 class="news_hot">Tin nổi bật nổi bật</h3>
                <div class="list-hot-news">
                    @foreach($hot_news as $hot)
                    <p><a href="{{url('tin-dau-gia/'.$hot->alias.'.html')}}" title="{{$hot->name}}">{{$hot->name}}</a></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection