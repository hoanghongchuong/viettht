<?php
    $setting = Cache::get('setting');
    $chinhanh = DB::table('chinhanh')->get();
?>

<footer>
    <div class="container">
        <div class="row top-footer">
            <div class="col-md-4">
                <h4>{{$setting->company}}</h4>
                <div class="mt-30">
                    <p>Địa chỉ: {{$setting->address}}</p>
                    <p>Điện thoại: {{$setting->hotline}} - Email: {{$setting->email}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <h4>Theo dõi chúng tôi</h4>
                <div class="box-newletter mt-30">
                    <form action="" method="get" accept-charset="utf-8">
                        <input type="text" name="newletter" value="" class="input-newletter" placeholder="Your email">
                        <input type="submit" name="" class="btn-submit-newletter" value="Gửi">
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <p class="tac"><a href="" title=""><img src="{{asset('upload/hinhanh/'.$setting->photo_footer)}}" alt=""></a></p>
            </div>
        </div>
        <div class="row bottom-footer">
            <ul>
                <li><a href="{{url('')}}">Trang chủ</a></li>
                <li><a href="{{url('gioi-thieu')}}">Giới thiệu</a></li>
                <li><a href="{{url('chuong-trinh-truyen-hinh')}}">Chương trình truyền hình</a></li>
                <li><a href="{{url('tin-tuc')}}">Tin tức</a></li>
                <li><a href="{{url('lien-he')}}">Liên hệ</a></li>
            </ul>
            <p class="copyright">Copyright 2019 viettht</p>
        </div>
    </div>
</footer>