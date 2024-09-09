<?php

use App\Http\Controllers\Api\Admin\AdminLoginController;
use App\Http\Controllers\Api\Admin\AdSliderController;
use App\Http\Controllers\Api\Admin\DeviceController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\Admin\ReleaseVersionController;
use App\Http\Controllers\Api\User\CountryController;
use App\Http\Controllers\Api\User\LoginController;
use App\Http\Controllers\Api\User\PasswordController;
use App\Http\Controllers\Api\User\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User

Route::post('webhook/countries', [CountryController::class, 'handleWebhook']);
Route::get('/adslider', [AdSliderController::class, 'index'])->name('adslider.index');

Route::prefix('user')->group(function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('/store', [RegisterController::class, 'store'])->name('user.register.store');
    Route::post('/verify-sms', [RegisterController::class, 'verifySms'])->name('user.verify-sms');
    Route::get('check-user', [LoginController::class, 'checkUser']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::post('logout', [LoginController::class, 'logout']);
        Route::get('/', [RegisterController::class, 'index'])->name('user.register.index');

        Route::post('/update/{id}', [RegisterController::class, 'update'])->name('user.register.update');
        Route::delete('/destroy', [RegisterController::class, 'destroy'])->name('user.register.destroy');

        Route::get('qrcode/{id}', [RegisterController::class, 'generateQrCode']);
        Route::post('get-user', [RegisterController::class, 'findUserByUniqueId']);

        Route::post('/change-password', [PasswordController::class, 'change'])->name('changePassword');
    });
});

Route::prefix('user')->group(function () {
    Route::post('/forgot-password', [PasswordController::class, 'forgot'])->name('forgotPassword');
    Route::post('/verify-password-sms', [PasswordController::class, 'verifyPasswordSms'])->name('verifyPasswordSms');
    Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('resetPassword');
    Route::post('/resend-otp', [PasswordController::class, 'resendOTP'])->name('resendOTP');
    Route::get('/country', [CountryController::class, 'index'])->name('countryList');
    Route::get('/product-category', [ProductController::class, 'category'])->name('admin.product.category');
    Route::get('/product', [ProductController::class, 'product'])->name('user.product.product');

    Route::post('/device-token', [DeviceController::class, 'store'])->name('user.notification.store');
    Route::post('notification', [NotificationController::class, 'store']);
    Route::post('notifications', [NotificationController::class, 'index']);
    Route::post('notification/is-read', [NotificationController::class, 'isRead']);
    Route::post('notification/unReadlist', [NotificationController::class, 'unRead']);

});

//// Admin
Route::post('admin/login', [AdminLoginController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('admin')->group(function () {

        Route::prefix('adslider')->group(function () {
            Route::get('/', [AdSliderController::class, 'index']);
            Route::post('/store', [AdSliderController::class, 'store']);
            Route::post('/update/{id}', [AdSliderController::class, 'update']);
            Route::delete('/destroy/{id}', [AdSliderController::class, 'destroy']);
        });

        Route::prefix('release-version')->group(function () {
            Route::get('/', [ReleaseVersionController::class, 'index']);
            Route::get('{id}', [ReleaseVersionController::class, 'show']);
            Route::post('/store', [ReleaseVersionController::class, 'store']);
            Route::post('/update/{id}', [ReleaseVersionController::class, 'update']);
            Route::delete('/destroy/{id}', [ReleaseVersionController::class, 'destroy']);
        });
    });
});

Route::post('/send-notification', [NotificationController::class, 'sendNotification']);
