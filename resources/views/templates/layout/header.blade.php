<?php
    $setting = Cache::get('setting');
    $sliders = DB::table('slider')->where('com','gioi-thieu')->where('status',1)->get();
    $categories = \App\NewsCate::where('com','dau-gia')->where('parent_id',0)->orderBy('id','asc')->get();
?>

<header id="header" class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <a href="{{url('')}}" title=""><img src="{{asset('upload/hinhanh/'.$setting->photo)}}" class="img-logo" alt=""></a>
            </div>
            <div class="col-md-6 col-xs-12 right">
                <div class="box-search">
                    <form action="{{route('search')}}" method="get" accept-charset="utf-8">
                        <input type="text" name="txtSearch" class="input-search">
                        <input type="submit" name="" value="Search" class="btn-search">
                    </form>                                        
                </div>
            </div>
            <div class="col-md-3">
                <div class="list-icon">
                    <a href="" title=""><img src="{{asset('public/images/icon1.png')}}" alt=""></a>
                    <a href="" title=""><img src="{{asset('public/images/icon2.png')}}" alt=""></a>
                    <a href="" title=""><img src="{{asset('public/images/icon3.png')}}" alt=""></a>
                    <a href="" title=""><img src="{{asset('public/images/icon4.png')}}" alt=""></a>
                </div>

            </div>
        </div>
    </div>
</header><!-- /header -->
<div class="menu visible-lg visible-md">
    <div class="container">
        <div class="row">
            <ul class="navi">                                        
                <li><a href="{{url('')}}">Trang chủ</a></li>
                <li><a href="{{url('gioi-thieu')}}">Giới thiệu</a></li>
                <li><a href="{{url('chuong-trinh-truyen-hinh')}}">Chương trình truyền hình</a></li>
                <li><a href="{{url('tin-tuc')}}">Tin tức</a></li>
                <li><a href="{{url('lien-he')}}">Liên hệ</a></li>
                
            </ul>
            
        </div>
    </div>
</div><!-- /menu -->
<!-- menu-mobile -->
<div class="visible-xs visible-sm menu-mobile">     
    <div class="vk-header__search">
        <div class="container">                
            <a href="#menuMobile" class="menu_Mobile" data-toggle="collapse" class="_btn d-lg-none menu_title"><i class="fa fa-bars"></i> Menu</a>
        </div>
    </div>
    <nav class="vk-header__menu-mobile">
        <ul class="vk-menu__mobile collapse" id="menuMobile">            
            <li><a href="{{url('')}}">Trang chủ</a></li>
            <li><a href="{{url('gioi-thieu')}}">Giới thiệu</a></li>
            <li><a href="{{url('chuong-trinh-truyen-hinh')}}">Chương trình truyền hình</a></li>
            <li><a href="{{url('tin-tuc')}}">Tin tức</a></li>
            <li><a href="{{url('lien-he')}}">Liên hệ</a></li>           
            
        </ul>
    </nav>        
</div>    