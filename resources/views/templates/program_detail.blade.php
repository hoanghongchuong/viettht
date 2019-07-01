@extends('index')
@section('content')
<?php
    $setting = Cache::get('setting');
?>
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb breadcrumbx">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                <li class="active"><a href="#">{{$data->name}}</a></li>
            </ol>
        </div>
    </div>
</div>
<div class="content-home-cate">
    <div class="container">
        <div class="">
            <div class="box-program-hot mt-0">
                <div class="col-md-6 pdl-0 pdr-0">
                    <div class="box-left" >
                        <a href="https://www.youtube.com/embed/{{$data->code}}" data-fancybox="video" title="" class="background-item" style="background-image: url('https://i.ytimg.com/vi/{{@$data->code}}/maxresdefault.jpg')">
                            <span class="plus-icon">
                                <img src="{{asset('public/images/play.png')}}">
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 pdl-0">
                    <div class="box-right">
                        <h4 class="name-program"><a href="" title="">{{$data->name}}</a></h4>
                        <div class="item">
                            <div class="col-xs-12 col-md-2 pdr-0 pdl-0">
                                <span class="title">Cốt truyện:</span>
                            </div>
                            <div class="col-md-19 col-xs-12 pdl-0">
                                <div class="cottruyen">{!! $data->mota !!}</div>
                            </div>
                        </div>
                        <!-- end-box -->
                        <div class="item">
                            <div class="col-xs-4 col-md-2 pdr-0 pdl-0">
                                <span class="title">Phát hành:</span>
                            </div>
                            <div class="col-md-19 col-xs-8 pdl-0">
                                {{$data->phathanh}}
                            </div>
                        </div>                        
                        <!-- end-box -->
                        <div class="item">
                            <div class="col-xs-4 col-md-2 pdr-0 pdl-0">
                                <span class="title">Thể loại:</span>
                            </div>
                            <div class="col-md-19 col-xs-8 pdl-0">
                                {{$data->theloai}}
                            </div>
                        </div>
                        <!-- end-box -->
                        <div class="item">
                            <div class="col-x-2 col-md-2 pdr-0 pdl-0">
                                <span class="title">Xếp hạng:</span>
                            </div>
                            <div class="col-md-19 col-xs-10 pdl-0">
                                <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-detail">
            {!! $data->content !!}
        </div>
    </div>
</div>
@endsection