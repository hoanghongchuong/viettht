@extends('index')
@section('content')
<div class="crumb">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb breadcrumbx">
                <li>
                    <a href="{{url('')}}">Trang chủ</a>
                </li>
                <li><a href="{{url('san-pham')}}">Sản phẩm</a></li>
                <li class="active">{{$product_cate->name}}</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-cate-product">
    <div class="container">
        <!-- <h2 class="title_home">Sản phẩm</h2>
        <div class="dongke"><span></span></div> -->
        <div class="box-product-home">
            <!-- <div class="col-md-3 left pdr-0 pdl-0">
                <div class="title-cate"><h4>Danh mục sản phẩm</h4></div>
                <div class="list-category">
                    
                    <nav class="sidebar-menu">
                        <ul class= collapse" id="menuMobile2">
                            @foreach($cate_pro as $k=>$category)
                            <li>
                                <a href="{{url('san-pham/'.$category->alias)}}">{{$category->name}}</a>
                                <a href="#cate{{$k}}" data-toggle="collapse" class="_arrow-mobile flr"><i class="_icon fa fa-angle-down"></i></a>
                                <ul class="collapse" id="cate{{$k}}">                                    
                                    @foreach($category->categoryChild as $child)
                                    <li><a href="{{url('san-pham/'.$child->alias)}}" title="{{$child->name}}">{{$child->name}}</a></li>
                                    @endforeach                                      
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                </div> -->
                
            </div>
            <div class="col-md-12 right">
                <div class="box-cate1">
                    <!-- <div class="top-head">
                        <div class="pull-left"><span class="name-cate">Chè loại 1</span></div>
                    </div> -->
                    <div class="list-item-product">
                        @foreach($products as $item)
                        <div class="col-md-3 col-xs-6 mb-30">
                            <div class="fix-animation">
                                <a href="{{url('san-pham/'.$item->alias.'.html')}}" title="{{$item->name}}">
                                    <img src="{{asset('upload/product/'.$item->photo)}}" alt="">
                                    <p class="name_product"><a href="{{url('san-pham/'.$item->alias.'.html')}}" title="{{$item->name}}">{{$item->name}}</a></p>
                                </a>
                            </div>
                                <div class="price tac">
                                    @if($item->price_old > $item->price)
                                    <span class="price_old">{{number_format($item->price_old)}} vnđ</span>
                                    @endif
                                    <span class="price_news">{{number_format($item->price)}} vnđ</span>
                                </div>
                            
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pagination"></div>
            </div>
        </div>
    </div>
</div>
@endsection
