<?php


use App\Models\Transaction;

Route::group([
    'prefix' => 'dashboard',
    'middleware' => 'auth',
    'as' => 'dashboard.',
], function () {

    Route::view('/', 'dashboard.index')->name('index');

    Route::resource('services', \App\Http\Controllers\Dashboard\Administratorship\ServiceController::class);
    Route::resource('categories', \App\Http\Controllers\Dashboard\Administratorship\CategoryController::class);
    Route::resource('counts', \App\Http\Controllers\Dashboard\Administratorship\CountController::class);


    Route::group([
        'prefix' => 'customers',
        'as' => 'customers.',
    ], function () {

        Route::get('services', [\App\Http\Controllers\Dashboard\CustomerManagement\ServiceController::class, 'index'])->name('services');
        Route::post('services/purchase', [\App\Http\Controllers\Dashboard\Purchase\PurchaseController::class, 'purchase'])->name('services.purchase');
        Route::get('services/{id}/purchase/result', [\App\Http\Controllers\Dashboard\Purchase\PurchaseController::class, 'result'])->name('services.purchase.result');
        Route::post('services', [\App\Http\Controllers\Dashboard\CustomerManagement\ServiceController::class, 'servicesByCategory'])->name('services.get_by_cat');
        Route::post('services/counts', [\App\Http\Controllers\Dashboard\CustomerManagement\ServiceController::class, 'getServiceInfo'])->name('services.info');

        Route::get('transactions', [\App\Http\Controllers\Dashboard\CustomerManagement\TransactionController::class, 'index'])->name('transactions');
        Route::get('purchased', [\App\Http\Controllers\Dashboard\CustomerManagement\PurhchasedServicesCntroller::class, 'index'])->name('purchased_services');

        // comments section routes
        Route::get('create-comment', [\App\Http\Controllers\Dashboard\CustomerManagement\CommentController::class, 'create'])->name('create_comment');
        Route::post('create-comment', [\App\Http\Controllers\Dashboard\CustomerManagement\CommentController::class, 'store'])->name('store_comment');


    });

    Route::resource('transactions', \App\Http\Controllers\Dashboard\Administratorship\TransactionController::class);
    Route::resource('purchases', \App\Http\Controllers\Dashboard\Administratorship\PurchasedServiceController::class);
    Route::resource('comments', \App\Http\Controllers\Dashboard\Administratorship\CommentController::class);


    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], function () {
        Route::get('/', [\App\Http\Controllers\Dashboard\Profile\ProfileController::class, 'index'])->name('index');
        if (\Laravel\Fortify\Features::enabled(\Laravel\Fortify\Features::updateProfileInformation())) {
            Route::put('/', [\App\Http\Controllers\Dashboard\Profile\ProfileController::class, 'update'])->name('update');
            Route::get('/password', [\App\Http\Controllers\Dashboard\Profile\ProfileController::class, 'password'])->name('password');
            Route::put('/password', [\App\Http\Controllers\Dashboard\Profile\ProfileController::class, 'updatePassword'])->name('update_password');
        }
    });

    // front management routes
    Route::resource('faqs', \App\Http\Controllers\Dashboard\Administratorship\FaqController::class);
    Route::resource('single-options', \App\Http\Controllers\Dashboard\Administratorship\SingleOptionController::class);



});



// front routes

Route::get('faqs', [\App\Http\Controllers\Front\FaqController::class, 'index'])->name('faqs');
Route::get('/', [\App\Http\Controllers\Front\PageController::class, 'home'])->name('home');

Route::get('test', function () {

//    $val = Transaction::getTodaySaleAmount();
//    $val = \App\Models\Service::getServiceAmountAverage();
//    dd($val);
    auth()->user()->givePermissionTo('manage single_options');
});
