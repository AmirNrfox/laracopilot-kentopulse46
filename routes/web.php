<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCouponController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\PaymentController;

// Sitemap & SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Language
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// ── Public ──────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('category.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// ── Auth ─────────────────────────────────────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

// ── User Orders ───────────────────────────────────────────────────────────────
Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// ── Cart ──────────────────────────────────────────────────────────────────────
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');

// ── Checkout ──────────────────────────────────────────────────────────────────
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/whatsapp', [CheckoutController::class, 'whatsapp'])->name('checkout.whatsapp');

// ── Payment ───────────────────────────────────────────────────────────────────
Route::post('/payment/pay', [PaymentController::class, 'pay'])->name('payment.pay');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/success/{order}', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failed', [PaymentController::class, 'failed'])->name('payment.failed');

// ── Reviews ───────────────────────────────────────────────────────────────────
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// ── Admin Auth ────────────────────────────────────────────────────────────────
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ── Admin Dashboard ───────────────────────────────────────────────────────────
Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'index']);

// ── Admin Reviews (Livewire page) ─────────────────────────────────────────────
Route::get('/admin/reviews', function () {
    if (!session('admin_logged_in')) return redirect()->route('admin.login');
    return view('admin.reviews');
})->name('admin.reviews');

// ── Admin Products ────────────────────────────────────────────────────────────
Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [AdminProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');
Route::post('/admin/products/{id}/images', [AdminProductController::class, 'uploadImage'])->name('admin.products.images.upload');
Route::delete('/admin/products/images/{imageId}', [AdminProductController::class, 'deleteImage'])->name('admin.products.images.delete');

// ── Admin Categories ──────────────────────────────────────────────────────────
Route::get('/admin/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
Route::post('/admin/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
Route::put('/admin/categories/{id}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
Route::delete('/admin/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');

// ── Admin Orders ──────────────────────────────────────────────────────────────
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::put('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');

// ── Admin Users ───────────────────────────────────────────────────────────────
Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
Route::put('/admin/users/{id}', [AdminUserController::class, 'update'])->name('admin.users.update');

// ── Admin Coupons ─────────────────────────────────────────────────────────────
Route::get('/admin/coupons', [AdminCouponController::class, 'index'])->name('admin.coupons.index');
Route::get('/admin/coupons/create', [AdminCouponController::class, 'create'])->name('admin.coupons.create');
Route::post('/admin/coupons', [AdminCouponController::class, 'store'])->name('admin.coupons.store');
Route::get('/admin/coupons/{id}/edit', [AdminCouponController::class, 'edit'])->name('admin.coupons.edit');
Route::put('/admin/coupons/{id}', [AdminCouponController::class, 'update'])->name('admin.coupons.update');
Route::delete('/admin/coupons/{id}', [AdminCouponController::class, 'destroy'])->name('admin.coupons.destroy');

// ── Admin Settings ────────────────────────────────────────────────────────────
Route::get('/admin/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
Route::post('/admin/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');