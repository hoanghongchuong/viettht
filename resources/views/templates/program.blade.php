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
                <li class="active"><a href="#">Chương trình truyền hình</a></li>
            </ol>
        </div>
    </div>
</div>
<div class="content-home-cate">
    <div class="container">
        <div class="row list-item-program">
            @foreach($products as $item)
            <div class="col-md-3 col-xs-6 pdl-0">
                <div class="item">
                    <a href="{{url('chuong-trinh/'.$item->alias.'.html')}}" title=""><img src="{{asset('upload/product/'.$item->photo)}}" alt=""></a>
                    <p>
                        <span class="pull-left">{{$item->phathanh}}</span>
                        <span class="pull-right"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection