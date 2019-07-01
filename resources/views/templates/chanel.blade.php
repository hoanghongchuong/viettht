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
                
                <li class="active">Kênh liên kết</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-home-cate">
    <div class="container">
        <div class="row">
            <div class="box-chanel fix-chanel">
                <h4 class="title-home">Kênh hợp tác</h4>
                <ul>
                    @foreach($partners as $partner)
                    <li><img src="{{asset('upload/banner/'.$partner->photo)}}" alt=""></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection