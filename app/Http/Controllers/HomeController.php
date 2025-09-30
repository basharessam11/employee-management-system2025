<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Admin\ServiceCategory;
use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Booking;
use App\Models\Card;
use App\Models\Cart;
use App\Models\Courses;
use App\Models\Courses_Item;
use App\Models\Courses_Review;
use App\Models\Courses_Time;
use App\Models\Expenses;
use App\Models\Faq;
use App\Models\Order;
use App\Models\Policy;
use App\Models\Product;
use App\Models\Rateing;
use App\Models\Review;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Story;
use App\Models\SuccessStory;
use App\Models\Terms;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Torann\GeoIP\Facades\GeoIP;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cards = Card::limit(6)->get();

        $slider = Slider::all();
        $services = Service::all();
        $courses = Courses::where('status',1)->limit(10)->get();
        $users = User::all();
        $reviews= Courses_Review::where('status',1)->get();

        $ServiceCategory = ServiceCategory::all();
        $faqs = Faq::limit(4)->get();

        $blogs = Blog::latest()->limit(5)->get();

        $rateings = Rateing::latest()->get();
        return view('web.index' ,get_defined_vars());

    }

    public function home(Request $request)
    {
/////////////////////////////////USD/////////////////////////////////////
// إجمالي حجز الشهر الحالي
$month_booking = Booking::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total');
$month_expenses = Expenses::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('price');
  // الإجمالي الكلي للشهر الحالي
$total = $month_booking -$month_expenses ;
/////////////////////////////////USD/////////////////////////////////////


/////////////////////////////////Egp/////////////////////////////////////
// إجمالي حجز الشهر الحالي
$month_bookingEGP = Booking::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total');
$month_expenses = Expenses::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('price');
 // الإجمالي الكلي للشهر الحالي
$totalEGP = $month_bookingEGP -$month_expenses  ;
/////////////////////////////////Egp/////////////////////////////////////




// إجمالي حجز الشهر السابق
$month_booking_last = Booking::whereMonth('created_at', now()->startOfMonth()->subMonth()->month)->sum('total');
$month_expenses_last = Expenses::whereMonth('created_at', now()->startOfMonth()->subMonth()->month)->sum('price');
 // الإجمالي الكلي للشهر السابق
$last_total = $month_booking_last -$month_expenses_last ;



// حساب التغير في الحجوزات بين الشهر الحالي والشهر السابق
 $avg_booking = ($month_booking_last > 0) ? (($month_booking - $month_booking_last) / $month_booking_last) * 100 : 0;

$avg_expenses = ($month_expenses_last > 0) ? (($month_expenses - $month_expenses_last) / $month_expenses_last) * 100 : 0;

// حساب التغير الكلي بين الشهر الحالي والشهر السابق
$avg = ($last_total > 0) ? (($total - $last_total) / $last_total) * 100 : 0;



// عدد الحجوزات في الشهر الحالي
$count_booking = count(Booking::whereMonth('created_at', now()->month)->get());


// عدد الحجوزات في الشهر السابق
$count_booking_last = Booking::whereMonth('created_at', now()->startOfMonth()->subMonth()->month)->count();


// حساب التغير في عدد الحجوزات بين الشهر الحالي والشهر السابق
$avg_count_booking = ($month_booking_last > 0) ? (($month_booking - $month_booking_last) / $month_booking_last) * 100 : 0;


// إجمالي المبيعات لكل شهر في السنة الحالية
$totals = [];
for ($month = 1; $month <= 12; $month++) {
    // جمع إجمالي الطلبات والحجوزات لكل شهر
    $total1 =  Booking::whereMonth('created_at', $month)->whereYear('created_at', now()->year)->sum('total') - Expenses::whereMonth('created_at', $month)->whereYear('created_at', now()->year)->sum('price');
    $totals[] = $total1;
}







// إجمالي الحجوزات للسنة الحالية
$total_booking_year = Booking::whereYear('created_at', now()->year)->sum('total');
$total_expenses_year =$total_booking_year - Expenses::whereYear('created_at', now()->year)->sum('price');
// إجمالي الحجوزات للسنة الماضية
$total_booking_last_year = Booking::whereYear('created_at', now()->subYear()->year)->sum('total');
$total_expenses_last_year = Expenses::whereYear('created_at', now()->subYear()->year)->sum('price');

// حساب التغير في الحجوزات بين السنة الحالية والسنة الماضية
$avg_booking_year = ($total_booking_last_year > 0) ? (($total_booking_year - $total_booking_last_year) / $total_booking_last_year) * 100 : 0;

$avg_expenses_year = ($total_expenses_last_year > 0) ? (($total_expenses_year - $total_expenses_last_year) / $total_expenses_last_year) * 100 : 0;


// جلب آخر 6 حجوزات
$bookings = Booking::orderBy('id', 'desc')->take(3)->whereYear('created_at', now()->year)->get();


// إجمالي الحجوزات للسنة الحالية حسب العدد
$total_booking_year_count = Booking::whereYear('created_at', now()->year)->count();
// إجمالي الحجوزات للسنة الماضية حسب العدد
$total_booking_last_year_count = Booking::whereYear('created_at', now()->subYear()->year)->count();

// حساب التغير في عدد الحجوزات بين السنة الحالية والسنة الماضية
$avg_count_booking_year = ($total_booking_last_year_count > 0) ? (($total_booking_year_count - $total_booking_last_year_count) / $total_booking_last_year_count) * 100 : 0;


// جلب إجمالي الحجوزات والنفقات لكل شهر في السنة الحالية
$monthly_data = Booking::selectRaw('MONTH(created_at) as month, SUM(total) as total_sum')
    ->whereYear('created_at', now()->year)
    ->groupBy('month')
    ->get();

// جلب إجمالي النفقات لكل شهر في السنة الحالية
$monthly_expenses = Expenses::selectRaw('MONTH(created_at) as month, SUM(price) as price_sum')
    ->whereYear('created_at', now()->year)
    ->groupBy('month')
    ->get();

// دمج البيانات للحصول على الدخل لكل شهر
$max_income = 0;
$max_income_month = null;

foreach ($monthly_data as $booking) {
    // البحث عن النفقات المتعلقة بنفس الشهر
    $expenses = $monthly_expenses->firstWhere('month', $booking->month);

    // حساب الدخل (حجوزات - نفقات)
    $income = $booking->total_sum - ($expenses ? $expenses->price_sum : 0);

    // إذا كان هذا الدخل أكبر من الدخل الحالي، قم بتحديث القيم
    if ($income > $max_income) {
        $max_income = $income;
        $max_income_month = $booking->month;
    }
}

// عرض النتيجة
$max_total= $max_income;




// إجمالي السنة الحالية (مجموع الطلبات والحجوزات لكل شهر)
$totalsCurrentYear = [];
for ($month = 1; $month <= 12; $month++) {
    $totalCurrentMonth =   Booking::whereMonth('created_at', $month)

                ->whereYear('created_at', now()->year)
                ->sum('total');
    $totalsCurrentYear[] = $totalCurrentMonth;
}

// إجمالي السنة الماضية (مجموع الطلبات والحجوزات لكل شهر)
$totalsLastYear = [];
for ($month = 1; $month <= 12; $month++) {
    $totalLastMonth =  Booking::whereMonth('created_at', $month)

                ->whereYear('created_at', now()->subYear()->year)
                ->sum('total');
    $totalsLastYear[] = $totalLastMonth;
}

########################################################################################################################################
         // 🔹 البحث بالتاريخ من - إلى
         if ($request->filled('from_date') && $request->filled('to_date') && $request->from_date <= $request->to_date) {

##########################################


    $from = Carbon::parse($request->from_date)->startOfDay();
    $to = Carbon::parse($request->to_date)->endOfDay();



    $total_expaenses = Expenses::whereBetween('created_at', [$from, $to])->sum('price');


##########################################

    $total_bookings = Booking::whereBetween('created_at', [$from, $to])->sum('total');


###########################################


         } elseif ($request->filled('from_date')) {
###########################################


 $from = Carbon::parse($request->from_date)->startOfDay();


    $total_expaenses = Expenses::where('created_at', '>=', $from)->sum('price');

###########################################


             $total_bookings = Booking::where('created_at', '>=', $from)->sum('total');

##########################################
         } elseif ($request->filled('to_date')) {

##############################################



 $to = Carbon::parse($request->to_date)->endOfDay();
$total_expaenses = Expenses::where('created_at', '<=', $to)->sum('price');

##################################################

 $total_bookings = Booking::where('created_at', '<=', $to)->sum('total');


########################################################
         }else{
            $total_bookings = Booking::sum('total');
            $total_expaenses = Expenses::sum('price');
         }
########################################################################################################################################




// إرجاع جميع القيم إلى الـ view
return view('admin.index', get_defined_vars());


    }
    public function contact()
    {
        return view('web.contact');
    }
    public function faq()
    {
        $faqs = Faq::all();
        return view('web.faq' ,get_defined_vars());

    }



    public function policy()
    {
        $policy = Policy::first();
        return view('web.privacy-policy' ,get_defined_vars());

    }

    public function terms()
    {
        $terms = Terms::first();
        return view('web.term-condition' ,get_defined_vars());

    }
    public function about()
    {
        $about = About::where('id',1)->first();
        return view('web.about',get_defined_vars());


    }
    public function cart()
    {
        return view('web.cart');
    }



    public function products(Request $request)
    {
        $query = Product::query()
                        ->withAvg('review', 'rate')  ;

        // إذا كان هناك طلب بحث
        if ($request->has('search') && $request->search !== null) {
            $searchTerm = $request->search;
            $query->where('title_en', 'like', '%' . $searchTerm . '%')
                  ->orWhere('title_ar', 'like', '%' . $searchTerm . '%');
        }

        // الفرز
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('review_avg_rate', 'desc'); // ترتيب حسب متوسط التقييم.
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        // التقسيم (Pagination)
        $products = $query->paginate(10);

        return view('web.products',get_defined_vars());
    }




    public function products_details($slug)
    {

        $products = Product::where('slug_en','!=',$slug)->orwhere('slug_ar','!=',$slug)->limit(10)->get();
        if (!$products) {
            abort(404);
        }
        $reviews = Review::limit(10)->get();
        $product = Product::where('slug_en',$slug)->first();

        if (!$product) {
            abort(404);
        }

        $avg1 = Review::where('product_id',  $product->id)->avg('rate');
        $avg = number_format($avg1, 1);
        return view('web.products-details',get_defined_vars());

    }

    public function services()
    {

        $services = Service::all();
        return view('web.services' ,get_defined_vars());


    }
    public function services_details($id)
    {
        $services = Service::all();
        $service = Service::findOrFail($id);
        return view('web.services-details' ,get_defined_vars());

    }


    public function courses(Request $request)
    {
        $query = Courses::query() ->withAvg('review', 'rate')  ;

        // إذا كان هناك طلب بحث
        if ($request->has('search') && $request->search !== null) {
            $searchTerm = $request->search;
            $query->where('name_en', 'like', '%' . $searchTerm . '%')
                  ->orWhere('name_ar', 'like', '%' . $searchTerm . '%');
        }

        // الفرز
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'popularity':
                    $query->orderBy('review_avg_rate', 'desc'); // ترتيب حسب متوسط التقييم.
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        // التقسيم (Pagination)
        $courses = $query->paginate(10);

        return view('web.courses',  get_defined_vars() );

    }
    public function courses_details($slug)
    {

        $reviews = Courses_Review::limit(10)->get();
        $courses = Courses::where('slug_en', 'like', '%' . $slug . '%')
        ->with('review')
        ->orWhere('slug_ar', 'like', '%' . $slug . '%')->first() ;
        if (!$courses) {
            abort(404);
        }
        $avg1 = Courses_Review::where('course_id',  $courses->id)->avg('rate');
        $avg = number_format($avg1, 1);
        $num1 = Courses_Review::where(['course_id'=>$courses->id,'rate'=>1])->count();
        $num2 = Courses_Review::where(['course_id'=>$courses->id,'rate'=>2])->count();
        $num3 = Courses_Review::where(['course_id'=>$courses->id,'rate'=>3])->count();
        $num4 = Courses_Review::where(['course_id'=>$courses->id,'rate'=>4])->count();
        $num5 = Courses_Review::where(['course_id'=>$courses->id,'rate'=>5])->count();

        $num = 1;

        $items = Courses_Item::where('course_id',  $courses->id)->get();
        $time = Courses_Time::where('course_id',  $courses->id)->get();

        return view('web.courses-details' ,get_defined_vars());

    }

    public function blog(Request $request)
    {
        $blogs = Blog::query()->paginate(10);





        return view('web.blog',get_defined_vars());

    }


    public function blogs(Request $request)
    {
        $blogs = Blog::query()->paginate(9);





        return view('web.blogs',get_defined_vars());

    }

    public function gallary(Request $request)
    {
        $cards = Card::query()->paginate(9);





        return view('web.gallary',get_defined_vars());

    }



    public function blog_details($slug)
{
    $blog = Blog::where('slug_en', $slug)
        ->orWhere('slug_ar', $slug)
        ->firstOrFail();

    $previousBlog = Blog::where('id', '<', $blog->id)
        ->orderBy('id', 'desc')
        ->first();

    $nextBlog = Blog::where('id', '>', $blog->id)
        ->orderBy('id', 'asc')
        ->first();

    $num = BlogComment::where('blog_id', $blog->id)->count();

    $recentblogs = Blog::where('id', '!=', $blog->id)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    return view('web.blog-details', get_defined_vars());
}

    public function success_story()
    {

          $story =  Story::first();
        return view('web.story' ,get_defined_vars());


    }
    public function checkout()
    {

        $customer_id = Auth::guard('customer')->user()->id;
        $carts =Cart::where(['customer_id'=>$customer_id])->get();

        return view('web.checkout' ,get_defined_vars());


    }







}
