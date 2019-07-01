@extends('index')
@section('content')
<?php
$setting = Cache::get('setting');
$sliders = DB::table('slider')->where('status',1)->where('com','gioi-thieu')->orderBy('id','desc')->get();
?>
<div class="slider">
    <div id="carousel-id1" class="carousel slide" data-ride="carousel">                    
        <div class="carousel-inner">
            @foreach($sliders as $k=>$slider)
            <div class="item @if($k ==0) active @endif">
                <img  alt="Third slide" src="{{asset('upload/hinhanh/'.$slider->photo)}}">                    
            </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#carousel-id1" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a class="right carousel-control" href="#carousel-id1" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div>
</div>
<!-- slogan home -->
<div class="slogan-home">
    <div class="container">
        <div class="row">
            <h3>Lan tỏa những giá trị nhân văn - Mang lại tiếng cười sảng khoái - Format đa dạng - Đối tác tin cậy của đài truyền hình</h3>
        </div>
    </div>
</div>
<div class="box-content">
    <div class="container">
        <div class="row">
            <div class="box-title">
                <p>Chương trình truyền hình</p>
            </div>
            <div class="list-program">
                <ul>
                    <li><a href="" title="" class="special">Đặc sắc</a></li>
                    @foreach($productHot as $hot)
                    <li><a href="{{url('chuong-trinh/'.$hot->alias)}}" title="">{{$hot->name}}</a></li>
                    @endforeach
                </ul>
                
            </div>
            <div class="box-program-hot">
                <div class="col-md-6 pdl-0 pdr-0">
                    <div class="box-left" >
                        <a href="https://www.youtube.com/embed/{{@$productHot[0]->code}}" data-fancybox="video" title="" class="background-item" style="background-image: url('https://i.ytimg.com/vi/{{@$productHot[0]->code}}/maxresdefault.jpg')">
                            <span class="plus-icon">
                                <img src="{{asset('public/images/play.png')}}">
                            </span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6 pdl-0">
                    <div class="box-right">
                        <h4 class="name-program"><a href="" title="">{{@$productHot[0]->name}}</a></h4>
                        <div class="item">
                            <div class="col-x-2 col-md-2 pdr-0 pdl-0">
                                <span class="title">Cốt truyện:</span>
                            </div>
                            <div class="col-md-19 col-xs-10 pdl-0">
                                {!! @$productHot[0]->mota !!}
                            </div>
                        </div>
                        <!-- end-box -->
                        <div class="item">
                            <div class="col-x-2 col-md-2 pdr-0 pdl-0">
                                <span class="title">Phát hành:</span>
                            </div>
                            <div class="col-md-19 col-xs-10 pdl-0">                                
                                {{@$productHot[0]->phathanh}}
                            </div>
                        </div>                        
                        <!-- end-box -->
                        <div class="item">
                            <div class="col-x-2 col-md-2 pdr-0 pdl-0">
                                <span class="title">Thể loại:</span>
                            </div>
                            <div class="col-md-19 col-xs-10 pdl-0">
                                {{@$productHot[0]->theloai}}
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
            <div class="slider-program">
                <div class="owl-carousel owl-carousel-product owl-theme popup">
                    @foreach($products as $item)
                    <div class="item">
                        <img src="{{asset('upload/product/'.$item->photo)}}" alt="">
                        <p>
                            <span class="pull-left">{{$item->phathanh}}</span>
                            <span class="pull-right"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></span>
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box-content">
    <div class="container">
        <div class="row">
            <div class="box-title">
                <p>Tin tức - dịch vụ - liên kết</p>
            </div>
            <div class="list-program">
                <ul>
                    <li> <a href="" title="" class="special">Đặc sắc</a></li>
                    <li><a href="{{url('tin-tuc')}}" title="">Tin tức</a></li>
                    <li><a href="" title="">Dịch vụ</a></li>
                    <li><a href="{{url('kenh-lien-ket')}}" title="">Liên kết, kênh hợp tác</a></li>
                </ul>
                
            </div>
            <div class="content-box-news">
                <div class="col-md-7 col-xs-12 pdl-0">
                    @foreach($newsHot as $n)
                    <div class="item-box-news">
                        <div class="col-md-6 pdl-0 pdr-0">
                            <a href="{{url('tin-tuc/'.$n->alias.'.html')}}" title=""><img src="{{asset('upload/news/'.$n->photo)}}" class="img-100" alt=""></a>
                        </div>
                        <div class="col-md-6">
                            <p class="name-news">{{$n->name}}</p>
                            <div class="des">{!! $n->mota !!}</div>
                            <p class="xemthem"><a href="{{url('tin-tuc/'.$n->alias.'.html')}}" title="">Xem tiếp</a></p>
                        </div>
                    </div>
                    @endforeach

                    <div class="box-ke"><span></span></div>
                    <div class="box-list-news">                        
                        <ul>
                            @foreach($news as $item)
                            <li class="col-md-6 col-xs-12"><a href="{{url('tin-tuc/'.$item->alias.'.html')}}">{{$item->name}}</a></li>
                            @endforeach
                        </ul>
                        
                    </div>
                </div>
                <div class="col-md-5 col-xs-12">
                    <h4 class="title-home">Thư viện video</h4>
                    <div class="box-video-gallery">
                        @foreach($videos as $video)
                        <div class="col-md-6">
                            <div class="item-video" >
                                <a href="https://www.youtube.com/embed/{{$video->link}}" data-fancybox="video" title="" class="bg-video" style="background-image: url('https://i.ytimg.com/vi/{{$video->link}}/maxresdefault.jpg')">
                                    <span class="plus-icon">
                                        <img src="{{ asset('public/images/play1.png')}}">
                                    </span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="box-chanel">
                        <h4 class="title-home">Kênh hợp tác</h4>
                        <ul>
                            @foreach($partners as $partner)
                            <li><img src="{{asset('upload/banner/'.$partner->photo)}}" alt=""></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="link-box">
                <div class="col-md-3">
                    <a href="{{url('gioi-thieu')}}" title=""><span class="item">viet tht</span></a>
                </div>
                <div class="col-md-3">
                    <a href="" title=""><span class="item">marketing online</span></a>
                </div>
                <div class="col-md-3">
                    <a href="" title=""><span class="item">Video chanel</span></a>
                </div>
                <div class="col-md-3">
                    <span class="last-link">Link liên kết</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
