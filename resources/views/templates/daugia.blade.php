@extends('index')
@section('content')
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb breadcrumbx">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                
                <li class="active">Tin đấu giá</li>
            </ol>
        </div>
    </div>
</div>
<div class="box-home box-cate-news">
    <div class="container">
        <div class="row">
            @foreach($categories as $data)
            <div class="col-md-4">
                <div class="item-cate grids_in">
                    <div class="img-right-pro">
                        <a href="{{url('tin-dau-gia/'.$data->alias)}}" class="effect_hover" title="{{$data->name}}"><img src="{{asset('upload/news/'.$data->photo)}}" class="img-pro"></a>
                    </div>
                    <div class="name-pro-right">
                        <a href="{{url('tin-dau-gia/'.$data->alias)}}" title="{{$data->name}}">
                            <h3>{{$data->name}}</h3>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection