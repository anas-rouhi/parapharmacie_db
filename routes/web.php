<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// استقبال رسائل الاتصال من الزبناء
// بدّل الـ Route القديم ديال الـ Contact بهاد السطر بالضبط
Route::post('/contact-submit', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
// 1. الصفحة الرئيسية والمنتجات (متاحة للجميع)
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/boutique', [ProductController::class, 'boutique'])->name('boutique');
Route::get('/filter-produits', [ProductController::class, 'filterAjax'])->name('products.filterAjax');
Route::get('/live-search', [ProductController::class, 'liveSearch'])->name('products.liveSearch');
Route::get('/diagnostic-submit', [ProductController::class, 'diagnosticSkin'])->name('products.diagnostic');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::post('/product/{id}/avis', [ProductController::class, 'storeAvis'])->name('products.avis.store');

// 2. نظام التسجيل والدخول (Breeze)
require __DIR__ . '/auth.php';

// 3. مسارات المستخدمين المسجلين (Profile & Common Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 4. ROUTES DIAL VISITEUR (الزبون العادي اللي كيشري - كيشوف غير طلبياتو)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [ProductController::class, 'userDashboard'])->name('dashboard');
    Route::get('/mes-commandes', [ProductController::class, 'userDashboard'])->name('client.commandes');
});

// 5. ROUTES DIAL STAFF / PERSONNEL (الموظف اللي كيسير السلعة والسطوك)
Route::middleware(['auth'])->prefix('staff')->name('staff.')->group(function () {
    // عوض staffDashboard رديناها dashboard حيت هي اللي كاينا ف الـ Controller ديالك
    Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

    Route::post('/produits/store', [ProductController::class, 'store'])->name('produits.store');
    Route::put('/produits/{id}/update', [ProductController::class, 'updateStaff'])->name('produits.update');
    Route::delete('/produits/{id}/destroy', [ProductController::class, 'destroy'])->name('produits.destroy');
});

// 6. ROUTES DIAL ADMIN (الأدمن الكبير - لوحة تحكم ParaAdmin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/categories/ajax-store', [AdminController::class, 'ajaxStoreCategory'])->name('categories.ajaxStore');

    // 📦 إدارة المنتجات
    Route::get('/produits', [ProductController::class, 'list'])->name('produits');
    Route::get('/produits/create', [ProductController::class, 'create'])->name('produits.create');
    Route::post('/produits/store', [ProductController::class, 'store'])->name('produits.store');
    Route::get('/produits/{id}/edit', [ProductController::class, 'edit'])->name('produits.edit');
    Route::put('/produits/{id}/update', [ProductController::class, 'update'])->name('produits.update');
    Route::delete('/produits/{id}', [ProductController::class, 'destroy'])->name('produits.destroy');

    // 👥 إدارة الحسابات
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
    Route::post('/users/store', [AdminController::class, 'storeClient'])->name('users.store');
    Route::put('/users/{id}/update', [AdminController::class, 'updateClient'])->name('users.update');
    Route::delete('/users/{id}/delete', [AdminController::class, 'destroyClient'])->name('users.delete');

    // 🛒 إدارة الطلبيات
    Route::get('/commandes', [OrderController::class, 'index'])->name('commandes');
    Route::put('/commandes/{id}/update-status', [OrderController::class, 'updateStatus'])->name('commandes.update');
    Route::delete('/commandes/{id}', [OrderController::class, 'delete'])->name('commandes.delete');

    // 🎟️ هنا بظبط حط الـ Routes ديال الـ Coupons (مصححة):
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [CouponController::class, 'store'])->name('coupons.store');
    Route::delete('/coupons/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');

    // ✉️ إدارة الرسائل وسط لوحة تحكم الأدمن

    Route::get('/messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::put('/messages/{id}/read', [AdminMessageController::class, 'markRead'])->name('messages.markRead');
    Route::delete('/messages/{id}', [AdminMessageController::class, 'destroy'])->name('messages.delete');

    // ⚡ Offres Flash & Packs (liste + page de création séparée)
    Route::get('/offres-flash', [AdminController::class, 'flashOffers'])->name('flash.index');
    Route::get('/offres-flash/create', [AdminController::class, 'flashCreate'])->name('flash.create');

    Route::get('/logs', [AdminController::class, 'viewLogs'])->name('logs');
    Route::get('/reports/export-pdf', [AdminController::class, 'exportPDFReport'])->name('reports.exportPdf');
    // 🔑 تغيير كلمة السر للأدمن
    Route::put('/password/update', [AdminController::class, 'updatePassword'])->name('password.update');
});

// 7. PANIER & CHECKOUT
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::post('/panier/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/confirmation', function () {
    return view('confirmation');
})->name('confirmation');
Route::get('/commande/{id}/facture', [OrderController::class, 'downloadFacture'])->name('facture.download');
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('coupon.apply');
Route::patch('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');

// 1. مسارات الـ Staff الإضافية للأمان
Route::post('/staff/produits', [App\Http\Controllers\ProductController::class, 'store'])->name('staff.produits.store');
Route::get('/staff/produits/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('staff.produits.edit');
Route::delete('/staff/produits/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('staff.produits.destroy');

// 2. مسارات الـ Admin الإضافية التوافقية
Route::post('/admin/produits', [App\Http\Controllers\ProductController::class, 'store'])->name('admin.produits.store');
Route::get('/admin/produits/{id}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('admin.produits.edit');
Route::delete('/admin/produits/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.produits.destroy');
Route::put('admin/produits/{id}', [ProductController::class, 'update'])->name('admin.produits.update');
Route::post('admin/flash-sale/save', [ProductController::class, 'saveFlashSale'])->name('admin.products.flash.save');

Route::get('/admin/check-new-orders', [AdminController::class, 'checkNewOrders'])->name('admin.checkNewOrders');

// مسارات الصفحات التعريفية الجديدة
Route::get('/a-propos', [PageController::class, 'apropos'])->name('pages.apropos');
Route::get('/service-sav', [PageController::class, 'sav'])->name('pages.sav');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');

Route::post('/chatbot/message', [App\Http\Controllers\ChatbotController::class, 'respond'])->name('chatbot.message');