<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\HomeComponent;
use \App\Http\Livewire\AboutusComponent;
use \App\Http\Livewire\ShopComponent;
use \App\Http\Livewire\CartComponent;
use \App\Http\Livewire\CheckoutComponent;
use \App\Http\Livewire\ContactComponent;
use \App\Http\Livewire\Admin\AdminDashboardComponent;
use \App\Http\Livewire\User\UserDashboardComponent;
use \App\Http\Livewire\DetailsComponent;
use \App\Http\Livewire\CategoryComponent;
use \App\Http\Livewire\SearchComponent;
use \App\Http\Livewire\Admin\AdminCategoryContent;
use \App\Http\Livewire\Admin\AdminAddCategoryComponent;
use \App\Http\Livewire\Admin\AdminEditCategoryComponent;
use \App\Http\Livewire\Admin\AdminProductComponent;
use App\Http\Livewire\Admin\AdminAddProductComponent;
use App\Http\Livewire\Admin\AdminEditProductComponent;
use \App\Http\Livewire\Admin\AdminHomeSliderComponent;
use App\Http\Livewire\Admin\AdminAddHomeSliderComponent;
use App\Http\Livewire\Admin\AdminEditHomeSliderComponent;
use \App\Http\Livewire\Admin\AdminHomeCategoryComponent;
use App\Http\Livewire\Admin\AdminSaleComponent;
use \App\Http\Livewire\WishlistComponent;
use \App\Http\Livewire\MessengerComponent;
use \App\Http\Livewire\Admin\AdminCouponComponent;
use \App\Http\Livewire\Admin\AdminAddCouponComponent;
use \App\Http\Livewire\Admin\AdminEditCouponComponent;
use \App\Http\Livewire\ThankyouComponent;
use \App\Http\Livewire\Admin\AdminOrderComponent;
use \App\Http\Livewire\Admin\AdminOrderDetailsComponent;
use \App\Http\Livewire\User\UserOrderComponent;
use \App\Http\Livewire\User\UserOrderDetailsComponent;
use \App\Http\Livewire\User\UserReviewComponent;
use \App\Http\Livewire\User\UserChangePasswordComponent;
use \App\Http\Livewire\Admin\AdminContactComponent;
use \App\Http\Livewire\Admin\AdminSettingComponent;
use \App\Http\Livewire\Retailer\RetailerDashboardComponent;
 /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',HomeComponent::class);
Route::get('/aboutus',AboutusComponent::class)->name('aboutus');
Route::get('/shop',ShopComponent::class)->name('shop');
Route::get('/cart',CartComponent::class)->name('product.cart');
Route::get('/checkout',CheckoutComponent::class)->name('checkout');
Route::get('/contact-us',ContactComponent::class)->name('contact');

Route::get('/product/{slug}',DetailsComponent::class)->name('product.details');
Route::get('/product-category/{categorySlug}',CategoryComponent::class)->name('product.category');
Route::get('/search',SearchComponent::class)->name('product.search');
Route::get('/wishlist',WishlistComponent::class)->name('product.wishlist');
Route::get('/thank-you',ThankyouComponent::class)->name('thankyou');

/*for Admin*/
Route::middleware(['auth:sanctum', 'verified','AuthAdmin'])->group(function (){
    Route::group(['prefix'=>'admin'],function (){
        Route::get('dashboard',AdminDashboardComponent::class)->name('admin.dashboard');
        Route::get('categories',AdminCategoryContent::class)->name('admin.category');
        Route::group(['prefix'=>'category'],function (){
            Route::get('add',AdminAddCategoryComponent::class)->name('admin.addCategory');
            Route::get('edit/{categorySlug}',AdminEditCategoryComponent::class)->name('admin.editCategory');
        });
        Route::get('products',AdminProductComponent::class)->name('admin.product');
        Route::group(['prefix'=>'product'],function (){
            Route::get('add',AdminAddProductComponent::class)->name('admin.addProduct');
            Route::get('edit/{productSlug}',AdminEditProductComponent::class)->name('admin.editProduct');
        });
        Route::group(['prefix'=>'slider'],function (){
            Route::get('/',AdminHomeSliderComponent::class)->name('admin.homeSlider');
            Route::get('add',adminAddHomeSliderComponent::class)->name('admin.addHomeSlider');
            Route::get('edit/{sliderId}',adminEditHomeSliderComponent::class)->name('admin.editHomeSlider');
        });
        Route::get('home-categories',AdminHomeCategoryComponent::class)->name('admin.homeCategories');
        Route::get('sale',AdminSaleComponent::class)->name('admin.sale');
        Route::get('coupons',AdminCouponComponent::class)->name('admin.coupons');
        Route::group(['prefix'=>'coupon'],function (){
            Route::get('add',AdminAddCouponComponent::class)->name('admin.addCoupon');
            Route::get('edit/{couponId}',AdminEditCouponComponent::class)->name('admin.editCoupon');
        });
        Route::group(['prefix'=>'orders'],function (){
            Route::get('/',AdminOrderComponent::class)->name('admin.orders');
            Route::get('{orderId}',AdminOrderDetailsComponent::class)->name('admin.orderDetails');
        });
        Route::get('contact-us',AdminContactComponent::class)->name('admin.contact');
        Route::get('settings',AdminSettingComponent::class)->name('admin.settings');
    });
});

Route::middleware(['auth:sanctum', 'verified','AuthRetailer'])->group(function (){
    Route::group(['prefix'=>'retailer'],function (){
        Route::get('dashboard',RetailerDashboardComponent::class)->name('retailer.dashboard');
    });
});
/*for User*/
Route::middleware(['auth:sanctum', 'verified'])->group(function (){
    Route::get('/messenger',MessengerComponent::class)->name('messenger');
    Route::group(['prefix'=>'user'],function (){
        Route::get('dashboard',UserDashboardComponent::class)->name('user.dashboard');
        Route::group(['prefix'=>'orders'],function (){
            Route::get('/',UserOrderComponent::class)->name('user.orders');
            Route::get('{orderId}',UserOrderDetailsComponent::class)->name('user.orderDetails');
        });
        Route::group(['prefix'=>'review'],function (){
            Route::get('/{orderItemId}',UserReviewComponent::class)->name('user.review');
        });
        Route::get('change-password',UserChangePasswordComponent::class)->name('user.changepassword');
    });
});
