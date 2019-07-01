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
                <li class="active">Giới thiệu</li>
            </ol>
        </div>
    </div>
</div>
<div class="box-home">
    <div class="container">
        <h1 class="title_home">Giới thiệu</h1>
        <div class="dongke"><span></span></div>
        <div class="box-about">
            {!! $about->content !!}
        </div>
    </div>
</div>
@endsection

