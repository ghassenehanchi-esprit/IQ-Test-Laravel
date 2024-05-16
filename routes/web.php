<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QuestionController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/symlink', function () {
    Artisan::call('storage:link');
});






Route::post('/logout', [LoginController::class, 'logout'])->name('logout');






//*************************************************************************
Route::resource('questions', QuestionController::class)->names('admin.questions');


Route::controller('SiteController')->group(function () {
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');

    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');

    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');

    Route::get('exchange/tracking', 'trackExchange')->name('exchange.tracking');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');
});
    Route::post('/quiz/update-answer/{quiz_detail_id}', [\App\Http\Controllers\QuizzController::class, 'updateQuizDetail'])->name('quiz.update');
    Route::get('/quiz/create', [\App\Http\Controllers\QuizzController::class, 'create'])->name('quiz.create');
    Route::get('/quizzes/{id}',  [\App\Http\Controllers\QuizzController::class, 'show'])->name('quizz.show');
// Define a route for the payment page
    Route::get('/order/show/{id}', [PaymentController::class, 'showPaymentPage'])->name('order.show');
    Route::get('/order/result/{id}', [\App\Http\Controllers\QuizzController::class, 'showOrderCompleted'])->name('order.result')->middleware('verify.stripe.payment');
    Route::get('/payment/{id}', [PaymentController::class, 'showPayment'])->name('stripe.payment.show');
    Route::get('/payment/paypal/{id}', [PaymentController::class, 'showPaypalPayment'])->name('paypal.payment.show');

Route::post('/show-order/{id}', [\App\Http\Controllers\QuizzController::class, 'showOrder'])->name('show.order');
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');
