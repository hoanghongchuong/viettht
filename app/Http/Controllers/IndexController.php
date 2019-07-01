<?php 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Products;
use App\ProductCate;
use App\NewsCate;
use App\News;
use App\NewsLetter;
use App\Recruitment;
use DB,Cache,Mail, Session;
use Cart;
use App\Campaign;
use App\Bill;
use App\CampaignCard;
use App\District;
use App\ChiNhanh;
class IndexController extends Controller {
	protected $setting = NULL;

	
	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		session_start();
    	$setting = DB::table('setting')->select()->where('id',1)->get()->first();
    	
    	$about = DB::table('about')->where('com','gioi-thieu')->get();
    	Cache::forever('setting', $setting);
        
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
				
		$newsCate = NewsCate::where('parent_id',0)->where('com','dau-gia')->orderBy('id','asc')->get();
		$productHot = Products::where('com','san-pham')->where('status',1)->where('noibat',1)->orderBy('id','desc')->take(4)->get();
		$products = Products::where('com','san-pham')->where('status',1)->orderBy('id','desc')->take(20)->get();
		$newsHot = News::where('com','tin-tuc')->where('status',1)->where('noibat',1)->orderBy('id','desc')->take(2)->get();
		$news = News::where('com','tin-tuc')->where('status',1)->orderBy('id','desc')->take(8)->get();
		$partners = DB::table('partner')->get();
		$setting =DB::table('setting')->select()->where('id',1)->get()->first();
		$about = DB::table('about')->where('com','gioi-thieu')->first();
		$videos = DB::table('video')->orderBy('id','desc')->get();
		$title = $setting->title;
		$keyword = $setting->keyword;
		$description = $setting->description;		
		$com = 'index';
		// End cấu hình SEO
		$img_share = asset('upload/hinhanh/'.$setting->photo);
		return view('templates.index_tpl', compact('com','keyword','description','title','img_share','partners','products','about','newsCate','productHot','news','videos','newsHot'));
	}
	public function getProduct(Request $req)
	{
		$cate_pro = ProductCate::where('status',1)->where('parent_id',0)->orderby('stt','asc')->get();
		$partners = DB::table('partner')->get();
		$products = DB::table('products')->where('status',1)->where('com','san-pham')->paginate(18);
		$com='san-pham';		
		$title = "Sản phẩm";
		$keyword = "Sản phẩm";
		$description = "Sản phẩm";
		// $img_share = asset('upload/hinhanh/'.$banner_danhmuc->photo);
		
		return view('templates.product_tpl', compact('title','keyword','description','products', 'com','cate_pro','partners'));
	}


	public function getProductList($id, Request $req)
	{		
		
		$cate_pro = ProductCate::where('status',1)->where('parent_id',0)->orderby('id','asc')->get();
		$partners = DB::table('partner')->get();
        $com = 'san-pham';
        $product_cate = ProductCate::select('*')->where('status', 1)->where('alias', $id)->where('com','san-pham')->first();        
        if (!empty($product_cate)) {            
        	$cate_parent = DB::table('product_categories')->where('id', $product_cate->parent_id)->first();

        	$cateChilds = DB::table('product_categories')->where('parent_id', $product_cate->id)->get();
        	
        	$array_cate[] = $product_cate->id;
        	if($cateChilds){
        		foreach($cateChilds as $cate){
        			$array_cate[] = $cate->id;
        		}
        	}        	
        	

        	$products = Products::whereIn('cate_id', $array_cate)->orderBy('id','desc')->paginate(18);
            
            if (!empty($product_cate->title)) {
                $title = $product_cate->title;
            } else {
                $title = $product_cate->name;
            }
            $keyword = $product_cate->keyword;
            $description = $product_cate->description;
            $img_share = asset('upload/product/' . $product_cate->photo);
            return view('templates.productlist_tpl', compact('products', 'product_cate', 'keyword', 'description', 'title', 'img_share', 'cate_pro', 'cate_parent', 'com','partners'));
        } else {
            return redirect()->route('getErrorNotFount');
        }
	}

	public function getProductListOld($id)
	{
		$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();
        $com = 'san-pham';
        $product_cate = ProductCate::select('*')->where('status', 1)->where('alias', $id)->where('com','san-pham')->first();        
        if (!empty($product_cate)) {            
        	$cate_parent = DB::table('product_categories')->where('id', $product_cate->parent_id)->first();

        	$cateChilds = DB::table('product_categories')->where('parent_id', $product_cate->id)->get();
        	
        	$array_cate[] = $product_cate->id;
        	if($cateChilds){
        		foreach($cateChilds as $cate){
        			$array_cate[] = $cate->id;
        		}
        	}        	
        	

        	$products = Products::whereIn('cate_id', $array_cate)->orderBy('id','desc')->paginate(18);
            
            if (!empty($product_cate->title)) {
                $title = $product_cate->title;
            } else {
                $title = $product_cate->name;
            }
            $keyword = $product_cate->keyword;
            $description = $product_cate->description;
            $img_share = asset('upload/product/' . $product_cate->photo);
            return view('templates.productlist_old', compact('products', 'product_cate', 'keyword', 'description', 'title', 'img_share', 'cate_pro', 'cate_parent', 'com'));
        } else {
            return redirect()->route('getErrorNotFount');
        }
	}

	public function getProductChild($alias){
		$cate = DB::table('product_categories')->where('alias',$alias)->first();
		$products = DB::table('products')->select()->where('status',1)->where('cate_id',$cate->id)->orderBy('id','desc')->paginate(20);
		$tintucs = DB::table('news')->orderBy('id','desc')->take(3)->get();
		return view('templates.productlist_level2', compact('tintucs','products'));
	}
	


	public function setCookies(Request $req, $id)
	{
		$idCookie = $id;
		$minutes = 1;
		$id_cookie = cookie('id_cookie', $idCookie, $minutes);

		return response()
			->view('templates.product_detail_tpl')
			->withCookie($id_cookie);
	}

	public function getProductDetail($id, Request $req)
	{
        
        $cate_pro = DB::table('product_categories')->where('status',1)->orderby('id','asc')->get();
		$product_detail = DB::table('products')->select()->where('status',1)->where('alias',$id)->get()->first();
		if(!empty($product_detail)){
			$banner_danhmuc = DB::table('lienket')->select()->where('status',1)->where('com','chuyen-muc')->where('link','san-pham')->get()->first();
			// sản phẩm đã xem
			$_SESSION['daxem'][$product_detail->id] = $product_detail->id;
			$ids_session = $_SESSION['daxem'];
			$productDaXem = DB::table('products')->whereIn('id', $ids_session)->where('status', 1)->get();

			$album_hinh = DB::table('images')->select()->where('product_id',$product_detail->id)->orderby('id','asc')->get();		
			$cateProduct = DB::table('product_categories')->select('name','alias')->where('id',$product_detail->cate_id)->first();
			$productSameCate = DB::table('products')->select()->where('status',1)->where('id','<>',$product_detail->id)->where('cate_id',$product_detail->cate_id)->orderby('stt','desc')->take(20)->get();			
			
			// Cấu hình SEO
			if(!empty($product_detail->title)){
				$title = $product_detail->title;
			}else{
				$title = $product_detail->name;
			}
			$keyword = $product_detail->keyword;
			$description = $product_detail->description;
			$img_share = asset('upload/product/'.$product_detail->photo);
			
			// End cấu hình SEO
			return view('templates.product_detail_tpl', compact('product_detail','banner_danhmuc','keyword','description','title','img_share','album_hinh','cateProduct','productSameCate','cate_pro', 'productDaXem'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
	}

	public function getAbout()
	{
		$about = DB::table('about')->where('com','gioi-thieu')->first();		
        $com = 'gioi-thieu';		
		 //Cấu hình SEO
		$title = 'Giới thiệu';
		$keyword = 'Giới thiệu';
		$description = 'Giới thiệu';
		// End cấu hình SEO

		return view('templates.about_tpl', compact('about','keyword','description','title','com'));
	}
	public function service()
	{
		$data = DB::table('about')->where('com','dich-vu')->first();
		$com = 'dich-vu';
		$title = $data->title ? $data->title : $data->name;
		$description = $data->description ? $data->description : $data->name;
		$keyword = $data->keyword ? $data->keyword : $data->name;
		return view('templates.service', compact('com','data','title','description','keyword'));
	}
	public function serviceList($alias)
	{
		$tintuc_cate = DB::table('news_categories')->where('status',1)->where('com','dich-vu')->where('alias',$alias)->first();
		if(!empty($tintuc_cate)){
			$data = DB::table('news')->select()->where('status',1)->where('cate_id',$tintuc_cate->id)->orderBy('id','desc')->get();

			if(!empty($tintuc_cate->title)){
				$title = $tintuc_cate->title;
			}else{
				$title = $tintuc_cate->name;
			}
			
			$keyword = $tintuc_cate->keyword;
			$description = $tintuc_cate->description;
			$img_share = asset('upload/news/'.$tintuc_cate->photo);

			// End cấu hình SEO
			return view('templates.service_list', compact('tintuc_cate','keyword','description','title','img_share','data'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
	}
	public function serviceDetail($alias)
	{
		$news_detail = News::where('status',1)->where('com','dich-vu')->where('alias',$alias)->get()->first();
		
		if(!empty($news_detail)){			
			$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();	
			$newsSameCate = DB::table('news')->select()->where('status',1)->where('com','tin-tuc')
			->where('id','<>',$news_detail->id)->take(12)->get();		
			$com='dich-vu';
			$setting = Cache::get('setting');
			$albums = $news_detail->images;
			$chinhanh = DB::table('chinhanh')->get();
			// Cấu hình SEO
			if(!empty($news_detail->title)){
				$title = $news_detail->title;
			}else{
				$title = $news_detail->name;
			}
			$keyword = $news_detail->keyword;
			$description = $news_detail->description;
			$img_share = asset('upload/news/'.$news_detail->photo);

			return view('templates.service_detail', compact('news_detail','com','keyword','description','title','img_share','newsSameCate','albums','chinhanh'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
	}
	public function search(Request $request)
	{
		$search = $request->txtSearch;
		$com = 'tim-kiem';
		$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();
		// Cấu hình SEO
		$title = "Tìm kiếm: ".$search;
		$keyword = "Tìm kiếm: ".$search;
		$description = "Tìm kiếm: ".$search;
		$img_share = '';		
		$data = DB::table('products')
		->where('com','san-pham')
		->where('name', 'LIKE', '%' . $search . '%')
		->where('status',1)
		->orderBy('id','DESC')->get();
		// dd($data);
		return view('templates.search_tpl', compact('data','keyword','description','title','img_share','search','com','cate_pro'));
	}

	public function getNews()
	{
		
		$tintuc = DB::table('news')->select()->where('status',1)->where('com','tin-tuc')->orderby('id','desc')->paginate(8);		
		$hot_news = DB::table('news')->where('status',1)->where('com','tin-tuc')->where('noibat',1)->orderby('id','desc')->take(6)->get();
		$com='tin-tuc';
		// Cấu hình SEO
		$title = "Tin tức";
		$keyword = "Tin tức";
		$description = "Tin tức";
		$img_share = '';
		// End cấu hình SEO
		return view('templates.news_tpl', compact('tintuc','keyword','description','title','img_share','com','hot_news'));
	}
	public function getListNews($id)
	{
		//Tìm article thông qua mã id tương ứng
		$tintuc_cate = DB::table('news_categories')->select()->where('status',1)->where('com','tin-tuc')->where('alias',$id)->get()->first();
		$cateNews = NewsCate::where('com','tin-tuc')->get();
		if(!empty($tintuc_cate)){
			$tintuc = DB::table('news')->select()->where('status',1)->where('cate_id',$tintuc_cate->id)->orderBy('id','desc')->paginate(5);
			$tintuc_moinhat_detail = DB::table('news')->select()->where('status',1)->where('com','tin-tuc')->orderby('created_at','desc')->take(6)->get();
			$hot_news = DB::table('news')->where('status',1)->where('com', 'tin-tuc')->where('noibat',1)->orderBy('stt','asc')->take(5)->get();
			$setting = Cache::get('setting');

			if(!empty($tintuc_cate->title)){
				$title = $tintuc_cate->title;
			}else{
				$title = $tintuc_cate->name;
			}
			
			$keyword = $tintuc_cate->keyword;
			$description = $tintuc_cate->description;
			$img_share = asset('upload/news/'.$tintuc_cate->photo);

			// End cấu hình SEO
			return view('templates.news_list', compact('tintuc','tintuc_cate','banner_danhmuc','keyword','description','title','img_share','tintuc_moinhat_detail','hot_news', 'cateNews'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
	}
	
	public function getNewsDetail($id)
	{
		$news_detail = DB::table('news')->select()->where('status',1)->where('com','tin-tuc')->where('alias',$id)->get()->first();
		
		if(!empty($news_detail)){			
			$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();	
			$newsSameCate = DB::table('news')->select()->where('status',1)->where('com','tin-tuc')
			->where('id','<>',$news_detail->id)->take(12)->get();		
			$com='tin-tuc';
			$setting = Cache::get('setting');
			// Cấu hình SEO
			if(!empty($news_detail->title)){
				$title = $news_detail->title;
			}else{
				$title = $news_detail->name;
			}
			$keyword = $news_detail->keyword;
			$description = $news_detail->description;
			$img_share = asset('upload/news/'.$news_detail->photo);

			return view('templates.news_detail_tpl', compact('news_detail','com','keyword','description','title','img_share','newsSameCate'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
		
	}
	public function getDauGia()
	{
		
		$categories = DB::table('news_categories')->where('com','dau-gia')->get();
		$com='dau-gia';
		// Cấu hình SEO
		$title = "Tin đấu giá";
		$keyword = "Tin đấu giá";
		$description = "Tin đấu giá";
		$img_share = '';
		// End cấu hình SEO
		return view('templates.daugia', compact('keyword','description','title','img_share','com','categories'));
	}
	public function getListDauGia($alias)
	{
		//Tìm article thông qua mã id tương ứng
		$tintuc_cate = DB::table('news_categories')->where('status',1)->where('com','dau-gia')->where('alias',$alias)->get()->first();
		$cateNews = NewsCate::where('com','dau-gia')->get();
		if(!empty($tintuc_cate)){
			$tintuc = DB::table('news')->where('com','dau-gia')->where('status',1)->where('cate_id',$tintuc_cate->id)->orderBy('id','desc')->paginate(10);
			
			$hot_news = DB::table('news')->where('status',1)->where('com', 'dau-gia')->where('noibat',1)->orderBy('stt','asc')->take(5)->get();
			$setting = Cache::get('setting');

			if(!empty($tintuc_cate->title)){
				$title = $tintuc_cate->title;
			}else{
				$title = $tintuc_cate->name;
			}
			$com = 'dau-gia';
			$keyword = $tintuc_cate->keyword;
			$description = $tintuc_cate->description;
			$img_share = asset('upload/news/'.$tintuc_cate->photo);

			// End cấu hình SEO
			return view('templates.daugia_list', compact('tintuc','tintuc_cate','keyword','description','title','img_share','hot_news', 'cateNews','com'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
	}
	public function getDauGiaDetail($alias)
	{
		$news_detail = DB::table('news')->select()->where('status',1)->where('com','dau-gia')->where('alias',$alias)->get()->first();
		
		if(!empty($news_detail)){			
			$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();	
			$newsSameCate = DB::table('news')->select()->where('status',1)->where('com','dau-gia')
			->where('id','<>',$news_detail->id)->take(12)->get();		
			$com = 'dau-gia';
			$setting = Cache::get('setting');
			// Cấu hình SEO
			if(!empty($news_detail->title)){
				$title = $news_detail->title;
			}else{
				$title = $news_detail->name;
			}
			$keyword = $news_detail->keyword;
			$description = $news_detail->description;
			$img_share = asset('upload/news/'.$news_detail->photo);				
			return view('templates.daugia_detail', compact('news_detail','com','keyword','description','title','img_share','newsSameCate'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
		
	}
	public function getThuTuc()
	{
		$tintuc = DB::table('news')->select()->where('status',1)->where('com','thu-tuc')->orderby('id','desc')->get(10);		
		$hot_news = DB::table('news')->where('status',1)->where('com','thu-tuc')->where('noibat',1)->orderby('id','desc')->take(6)->get();
		$com='thu-tuc';
		// Cấu hình SEO
		$title = "Thủ tục";
		$keyword = "Thủ tục";
		$description = "Thủ tục";
		$img_share = '';
		// End cấu hình SEO
		return view('templates.thutuc', compact('tintuc','keyword','description','title','img_share','com','hot_news'));
	}
	
	public function getThuTucDetail($alias)
	{
		$news_detail = DB::table('news')->select()->where('status',1)->where('com','thu-tuc')->where('alias',$alias)->first();
		
		if(!empty($news_detail)){			
			$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();
			$newsSameCate = DB::table('news')->select()->where('status',1)->where('com','thu-tuc')
			->where('id','<>',$news_detail->id)->take(12)->get();			
			$com='thu-tuc';
			$setting = Cache::get('setting');
			// Cấu hình SEO
			if(!empty($news_detail->title)){
				$title = $news_detail->title;
			}else{
				$title = $news_detail->name;
			}
			$keyword = $news_detail->keyword;
			$description = $news_detail->description;
			$img_share = asset('upload/news/'.$news_detail->photo);

			return view('templates.thutuc_detail', compact('news_detail','com','keyword','description','title','img_share','newsSameCate'));
		}else{
			return redirect()->route('getErrorNotFount');
		}
		
	}

	public function postGuidonhang(Request $request)
	{
		$setting = Cache::get('setting');
		$data = [
			'hoten' 		=> $request->get('hoten'), 
			'diachi' 	=> $request->get('diachi'),
			'dienthoai' 	=> $request->get('dienthoai'),
			'email' 	=> $request->get('email'),
			'noidung' 	=> $request->get('noidung')
		];
		Mail::send('templates.guidonhang_tpl', $data, function($msg){
			$msg->from($request->get('email'), $request->get('hoten'));
			$msg->to('emailserver.send@gmail.com', 'Author sendmail')->subject('Liên hệ từ website');
		});

		echo "<script type='text/javascript'>
			alert('Thanks for contacting us !');
			window.location = '".url('/')."' </script>";
	}
	public function postNewsLetter(Request $request)
	{
		$this->validate($request,
            ["txtEmail" => "required"],
            ["txtEmail.required" => "Bạn chưa nhập email"]
        );
        $kiemtra_mail = DB::table('newsletter')->select()->where('status',1)->where('com','newsletter')->where('email',$request->txtEmail)->get()->first();
        if(empty($kiemtra_mail)){
			$data = new NewsLetter();
			$data->name = $request->txtName;
			$data->email = $request->txtEmail;
			$data->phone = $request->txtPhone;
			$data->content = $request->txtContent;
			$data->status = 1;
			$data->com = 'newsletter';
			$data->save();

			echo "<script type='text/javascript'>
				alert('Bạn đã đăng kí nhận tin tức thành công !');
				window.location = '".url('/')."' </script>";
		}else{
			echo "<script type='text/javascript'>
				alert('Email này đã đăng ký !');
				window.location = '".url('/')."' </script>";
		}
	}
	public function getErrorNotFount(){
		$banner_danhmuc = DB::table('lienket')->select()->where('status',1)->where('com','chuyen-muc')->where('link','san-pham')->get()->first();
		return view('templates.404_tpl',compact('banner_danhmuc'));
	}

	public function getTuyenDung(){
		$com='tuyen-dung';
		$tintuc = DB::table('news')->select()->where('status',1)->where('com','tuyen-dung')->orderby('stt','asc')->paginate(6);
		$hot_news = DB::table('news')->select()->where('status',1)->where('noibat','>',0)->where('com','tuyen-dung')->take(5)->get();

		$title = 'Tuyển dụng';
		$description = 'Tuyển dụng';
		$keyword = 'Tuyển dụng';
		return view('templates.tuyendung', compact('com','tintuc','hot_news','title','description','keyword'));
	}
	public function getNewsTuyenDungDetail($alias)
	{
		$news_detail = DB::table('news')->select()->where('status',1)->where('com','tuyen-dung')->where('alias',$alias)->get()->first();
		if(!empty($news_detail)){
			$hot_news = DB::table('news')->where('status',1)->where('com', 'tuyen-dung')->where('noibat',1)->orderBy('stt','asc')->take(5)->get();
			if(!empty($news_detail->title)){
				$title = $news_detail->title;
			}else{
				$title = $news_detail->name;
			}
			$keyword = $news_detail->keyword;
			$description = $news_detail->description;
			$img_share = asset('upload/news/'.$news_detail->photo);
		}
		return view('templates.detailtuyendung', compact('news_detail', 'hot_news','title','description','keyword', 'img_share'));
	}
	public function postTuyenDung(Request $request){
		$data = new Recruitment;
		$data->name = $request->txtName;
		$data->phone = $request->txtPhone;
		$data->email = $request->txtEmail;
		$data->address = $request->txtAddress;
		$data->save();
		return redirect()->back()->with('mess','Cảm ơn bạn đã gửi yêu cầu. Chúng tôi sẽ liên hệ lại với bạn sớm nhất !');
	}


	public function getCart()
	{
		$product_cart= Cart::content();
		// dd($product_cart);
		$bank = DB::table('bank_account')->get();
		$total = $this->getTotalPrice();
		$province = DB::table('province')->get();
		// $district = DB::table('district')->get();
		$product_noibat = DB::table('products')->select()->where('status',1)->where('noibat','>',0)->orderBy('created_at','desc')->take(8)->get();
		$setting = Cache::get('setting');
		// Cấu hình SEO
		$title = "Giỏ hàng";
		$keyword = "Giỏ hàng";
		$description = "Giỏ hàng";
		$img_share = '';
		// End cấu hình SEO
		return view('templates.giohang_tpl', compact('product_cart','product_noibat','province','keyword','description','title','img_share','total', 'bank'));
	}

	public function addCart(Request $req)
	{
		$data = $req->only('product_id','product_numb');
		$product = DB::table('products')->where('status',1)->where('id',$data['product_id'])->first();
		if (!$product) {
			die('product not found');
		}
		Cart::add(array(
				'id'=>$product->id,
				'name'=>$product->name,
				'qty'=>$data['product_numb'],
				'price'=>$product->price,
				'options'=>array('photo'=>$product->photo)));
		return redirect(route('getCart'));
	}
	public function addCartAjax(Request $req)
    {
        // $data = $req->only('product_id');
        try {
            $product = DB::table('products')->select()->where('status', 1)->where('id', $req->id)->first();
            if (!$product) {
                die('product not found');
            }
            Cart::add(array(
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => array('photo' => $product->photo, 'code' => $product->code, 'alias' => $product->alias)
            ));
            echo count(Cart::Content());
        } catch (\Exception $e) {
            return 0;
        }
        // return redirect(route('getCart'));
    }
	public function updateCart(Request $req){
		$data = $req->numb;
		// dd($data);
		if($data>0){
			foreach($data as $key=>$item){
				Cart::update($key, $item);
			}
		}		
		return redirect(route('getCart'));
	}
	public function deleteCart($id){
        Cart::remove($id);
        return redirect('gio-hang');
    }

    public function checkCard(Request $req) {
    	$card = (new CampaignCard)
    		->join('campaigns', 'campaign_cards.campaign_id', '=', 'campaigns.id')
    		->select('campaigns.campaign_value', 'campaigns.campaign_type')
    		->where([
    			'campaign_cards.card_code' => $req->card_code,
    			'campaign_cards.del_flg' => 0,
    			'campaign_cards.is_active' => 0,
    			'campaigns.del_flg' => 0
    		])
    		->where('campaigns.campaign_expired', '>=', date('Y-m-d'))
    		->first();
    	if ($card) {
	    	$total = $this->getTotalPrice();
    		if ($card->campaign_type == 1) {
    			$total = $total - $card->campaign_value;
    		}
    		if ($card->campaign_type == 2) {
    			$total = $total * (100 - $card->campaign_value) / 100;
    		}

    		// return ($total);
    		return number_format($total);
    	}
    	return response()->json(false);
    }

    protected function getTotalPrice() 
    {
    	$cart = Cart::content();
    	$total = 0;
    	foreach ($cart as $key) {
    		$total += $key->price * $key->qty;
    	}
    	return $total;
    }

    public function postOrder(Request $req){
    	$cart = Cart::content();
    	$bill = new Bill;
    	$bill->full_name = $req->full_name;
    	$bill->email = $req->email;
    	$bill->phone = $req->phone;
    	$bill->note = $req->note;
    	$bill->address = $req->address;
    	$bill->payment = (int)($req->payment_method);
    	// $bill->province = $req->province;
    	// $bill->district = $req->district;
    	$total = $this->getTotalPrice();
    	$bill->total = $total;
    	// $order['price'] = $this->getTotalPrice();
    	// if ($req->card_code) {
    	// 	$price = $this->checkCard($req);
	    // 	if (!$price) {
	    // 		return redirect()->back()->with('Mã giảm giá không đúng');
	    // 	}
	    // 	$bill->card_code = $req->card_code;
	    // 	$tongtien = $this->checkCard($req);
	    // 	$bill->total = ((Int)str_replace(',', '', $tongtien)); 	
    	// }
    	$detail = [];
    	foreach ($cart as $key) {
    		$detail[] = [
    			'product_name' => $key->name,
    			'product_numb' => $key->qty,
    			'product_price' => $key->price,
    			'product_img' => $key->options->photo,
    			'product_code' => $key->options->color
    		];
    	}    	    	
    	$bill->detail = json_encode($detail);

    	// dd($bill);
    	if($total > 0){
    		$bill->save();
    	}
    	else{
    		echo "<script type='text/javascript'>
				alert('Giỏ hàng của bạn rỗng!');
				window.location = '".url('/')."' 
			</script>";
    	}    	
    	Cart::destroy();

    	echo "<script type='text/javascript'>
				alert('Cảm ơn bạn đã đặt hàng, chúng tôi sẽ liên hệ với bạn sớm nhất!');
				window.location = '".url('/')."' 
			</script>";
    }

    public function deleteAllCart(){
    	Cart::destroy();
    	return redirect()->back()->with('mess','Đã xóa giỏ hàng');
    }

    public function thanhtoan(){
    	$bank = DB::table('bank_account')->get();
    	$product_cart= Cart::content();
    	// dd($product_cart);
    	$total = $this->getTotalPrice();
		return view('templates.thanhtoan_tpl',compact('bank','product_cart','total'));
	}
    public function loadDistrictByProvince($id){
    	$district = District::where('province_id',$id)->get();
    	// dd($district);
    	foreach($district as $item){
    		echo "<option value='".$item->id."'>".$item->district_name."</option>";
    	}
    }
    
    public function SapXep(Request $request){
    	$result = DB::table('products')
    			->join('product_categories','products.cate_id','=','product_categories.id')
    			->select('products.id', 'products.name as productName','products.alias as productAlias','products.photo as productPhoto','products.price as productPrice');

    	if ($request->cate) {
    		$result = $result->where('products.cate_id', $request->cate);
    	}
    	if ($request->price) {
    		$result = $result->whereBetween('products.price', array(0, $request->price));
    	}

    	$result = $result->orderBy('products.id', $request->sort ? $request->sort : 'asc')->paginate(12);
    	return response()->json([
    		'paginator'  => (String) $result->render(),
    		'data'		 => json_decode(json_encode($result))->data,
    	]);
    }

    public function getProductByCate($alias){
    	$cate_pro = DB::table('product_categories')->where('status',1)->where('parent_id',0)->orderby('id','asc')->get();
    	$categoryDetail = ProductCate::select('name','alias','id','parent_id')->where('alias', $alias)->first();
    	$products = $categoryDetail->products;

    	return view('templates.cateproduct_tpl', compact('categoryDetail','cate_pro','products'));
    }
    public function program()
    {
    	$products = Products::where('com','san-pham')->where('status',1)->orderBy('id','desc')->paginate(24);
    	$title = 'Chương trình truyền hình';
    	$com = 'program';
    	return view('templates.program', compact('products','com','title'));
    }
    public function programDetail($alias)
    {
    	$data = Products::where('com','san-pham')->where('alias', $alias)->first();
    	$com = 'program';
    	$title = $data->title ? $data->title : $data->name;
    	$description = $data->description ? $data->description : $data->name;
    	$keyword = $data->keyword ? $data->keyword : $data->name;
    	return view('templates.program_detail', compact('data','com','title','description','keyword'));
    }
    public function chanel()
    {
    	$partners = DB::table('partner')->get();
    	return view('templates.chanel', compact('title','partners'));
    }
	
}
