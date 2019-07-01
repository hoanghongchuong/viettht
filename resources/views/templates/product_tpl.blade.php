@extends('index')
@section('content')
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb breadcrumbx">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                <li class="active"><a href="{{url('san-pham')}}">Sản phẩm</a></li>
            </ol>
        </div>
    </div>
</div>
<div class="content-cate-product">
    <div class="container">
        <!-- <h2 class="title_home">Sản phẩm</h2>
        <div class="dongke"><span></span></div> -->
        <div class="box-product-home">
            <div class="col-md-3 left pdr-0 pdl-0">
                <!-- <div class="title-cate"><h4>Danh mục sản phẩm</h4></div>
                <div class="list-category">
                    @foreach($cate_pro as $category)
                        <p class=""><a href="{{url('san-pham/'.$category->alias)}}" title="{{$category->name}}">{{$category->name}}</a></p>
                    @endforeach
                </div> -->
                <!-- <div class="list-category box-support">
                    <div class="title-cate"><h4>Hỗ trợ trực tuyến</h4></div>
                    <div class="box1">
                        <p><img src="images/a1.png" alt=""></p>
                        <p>SĐT: 0987654321</p>
                        <p>Email: abcd@gmail.com</p>
                    </div>
                    <div class="box1">
                        <p><img src="images/a1.png" alt=""></p>
                        <p>SĐT: 0987654321</p>
                        <p>Email: abcd@gmail.com</p>
                    </div>
                </div> -->
            </div>
            <div class="col-md-12 right">
                <div class="box-cate1">
                    <!-- <div class="top-head">
                        <div class="pull-left"><span class="name-cate">Chè loại 1</span></div>
                    </div> -->
                    <div class="list-item-product">
                        @foreach($products as $item)
                        <div class="col-md-3 mb-30">
                            <div class="fix-animation">
                                <a href="{{url('san-pham/'.$item->alias.'.html')}}" title="{{$item->name}}">
                                    <img src="{{asset('upload/product/'.$item->photo)}}" alt="">
                                    <p class="name_product"><a href="{{url('san-pham/'.$item->alias.'.html')}}" title="{{$item->name}}">{{$item->name}}</a></p>
                                </a>
                                <div class="price tac">
                                    @if($item->price_old > $item->price)
                                    <span class="price_old">{{number_format($item->price_old)}} vnđ</span>
                                    @endif
                                    <span class="price_news">{{number_format($item->price)}} vnđ</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="paginations">{!! $products->links() !!}</div>
            </div>
        </div>
    </div>
</div>
@endsection
