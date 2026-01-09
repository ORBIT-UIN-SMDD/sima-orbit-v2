<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [App\Http\Controllers\Front\AboutController::class, 'index'])->name('about');

Route::prefix('news')->name('news.')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [NewsController::class, 'category'])->name('category');
    Route::get('/{slug}', [NewsController::class, 'show'])->name('show');
    Route::post('/{slug}', [NewsController::class, 'comment'])->name('comment');
});

Route::prefix('user')->name('user.')->group(function () {
    Route::get('/{id}', [App\Http\Controllers\Front\UserController::class, 'profile'])->name('profile');
});

Route::prefix('profil')->name('profil.')->group(function () {
    // Route::get('/', [MenuProfilController::class, 'index'])->name('index');
    Route::get('/{slug}', [App\Http\Controllers\Front\MenuProfileController::class, 'show'])->name('show');
});


Route::post('/login', [App\Http\Controllers\Front\AuthController::class, 'login'])->name('login');
Route::post('/logout', [App\Http\Controllers\Front\AuthController::class, 'logout'])->name('logout');
Route::get('/register', [App\Http\Controllers\Front\AuthController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Front\AuthController::class, 'registerStore'])->name('register.store');

Route::prefix('back')->name('back.')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/', [App\Http\Controllers\Back\DashboardController::class, 'index'])->name('index');
        Route::get('/visitor', [App\Http\Controllers\Back\DashboardController::class, 'Visitor'])->name('visitor');
        Route::get('/visitor-stat', [App\Http\Controllers\Back\DashboardController::class, 'visistorStat'])->name('visitor.stat');
        Route::get('/news', [App\Http\Controllers\Back\DashboardController::class, 'news'])->name('news');
        Route::get('/news-stat', [App\Http\Controllers\Back\DashboardController::class, 'stat'])->name('news.stat');
    });

    Route::prefix('announcement')->name('announcement.')->group(function () {
        Route::get('/', [App\Http\Controllers\Back\AnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Back\AnnouncementController::class, 'create'])->name('create');
        Route::post('/create', [App\Http\Controllers\Back\AnnouncementController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [App\Http\Controllers\Back\AnnouncementController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [App\Http\Controllers\Back\AnnouncementController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Back\AnnouncementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/category', [App\Http\Controllers\Back\NewsController::class, 'category'])->name('category');
        Route::post('/category', [App\Http\Controllers\Back\NewsController::class, 'categoryStore'])->name('category.store');
        Route::put('/category/edit/{id}', [App\Http\Controllers\Back\NewsController::class, 'categoryUpdate'])->name('category.update');
        Route::delete('/category/delete/{id}', [App\Http\Controllers\Back\NewsController::class, 'categoryDestroy'])->name('category.destroy');

        Route::get('/', [App\Http\Controllers\Back\NewsController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Back\NewsController::class, 'create'])->name('create');
        Route::post('/create', [App\Http\Controllers\Back\NewsController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [App\Http\Controllers\Back\NewsController::class, 'edit'])->name('edit');
        Route::put('/edit/{id}', [App\Http\Controllers\Back\NewsController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [App\Http\Controllers\Back\NewsController::class, 'destroy'])->name('destroy');

        Route::get('/comment', [App\Http\Controllers\Back\NewsController::class, 'comment'])->name('comment');
        Route::post('/comment/spam/{id}', [App\Http\Controllers\Back\NewsController::class, 'commentSpam'])->name('comment.spam');
    });

    Route::prefix('about-us')->name('about-us.')->group(function () {
        Route::get('/', [App\Http\Controllers\Back\AboutUsController::class, 'index'])->name('index');
        Route::post('/update', [App\Http\Controllers\Back\AboutUsController::class, 'update'])->name('update');
    });

    Route::prefix('menu')->name('menu.')->group(function () {
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [App\Http\Controllers\Back\MenuProfilController::class, 'index'])->name('index');
            Route::post('/create', [App\Http\Controllers\Back\MenuProfilController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [App\Http\Controllers\Back\MenuProfilController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [App\Http\Controllers\Back\MenuProfilController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Back\MenuProfilController::class, 'destroy'])->name('destroy');
            Route::post('/upload', [App\Http\Controllers\Back\MenuProfilController::class, 'upload'])->name('upload');
        });
    });

    Route::prefix('inbox')->name('inbox.')->group(function () {
        Route::get('/', [App\Http\Controllers\Back\InboxController::class, 'index'])->name('index');
        Route::delete('/{id}', [App\Http\Controllers\Back\InboxController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('master')->name('master.')->group(function () {

        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [App\Http\Controllers\Back\Master\UserController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Back\Master\UserController::class, 'create'])->name('create');
            Route::post('/create', [App\Http\Controllers\Back\Master\UserController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [App\Http\Controllers\Back\Master\UserController::class, 'edit'])->name('edit');
            Route::put('/edit/{id}', [App\Http\Controllers\Back\Master\UserController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Back\Master\UserController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('member-field')->name('member-field.')->group(function () {
            Route::get('/', [App\Http\Controllers\Back\Master\MemberFieldController::class, 'index'])->name('index');
            Route::post('/create', [App\Http\Controllers\Back\Master\MemberFieldController::class, 'create'])->name('create');
            Route::put('/edit/{id}', [App\Http\Controllers\Back\Master\MemberFieldController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Back\Master\MemberFieldController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('faculty')->name('faculty.')->group(function () {
            Route::get('/', [App\Http\Controllers\Back\Master\FacultyController::class, 'index'])->name('index');
            Route::post('/create', [App\Http\Controllers\Back\Master\FacultyController::class, 'create'])->name('create');
            Route::put('/edit/{id}', [App\Http\Controllers\Back\Master\FacultyController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Back\Master\FacultyController::class, 'destroy'])->name('destroy');
        });
        Route::prefix('department')->name('department.')->group(function () {
            Route::get('/', [App\Http\Controllers\Back\Master\DepartmentController::class, 'index'])->name('index');
            Route::post('/create', [App\Http\Controllers\Back\Master\DepartmentController::class, 'create'])->name('create');
            Route::put('/edit/{id}', [App\Http\Controllers\Back\Master\DepartmentController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [App\Http\Controllers\Back\Master\DepartmentController::class, 'destroy'])->name('destroy');
        });
    });

    Route::prefix('setting')->name('setting.')->group(function () {
        Route::get('/website', [App\Http\Controllers\Back\SettingController::class, 'website'])->name('website');
        Route::put('/website', [App\Http\Controllers\Back\SettingController::class, 'websiteUpdate'])->name('website.update');
        Route::put('/website/info', [App\Http\Controllers\Back\SettingController::class, 'informationUpdate'])->name('website.info');

        Route::get('/banner', [App\Http\Controllers\Back\SettingController::class, 'banner'])->name('banner');
        Route::post('/banner/create', [App\Http\Controllers\Back\SettingController::class, 'bannerCreate'])->name('banner-create');
        Route::put('/banner/{id}/update', [App\Http\Controllers\Back\SettingController::class, 'bannerUpdate'])->name('banner-update');
        Route::delete('/banner/{id}/delete', [App\Http\Controllers\Back\SettingController::class, 'bannerDelete'])->name('banner-delete');

        Route::get('/bot', [App\Http\Controllers\Back\SettingController::class, 'bot'])->name('bot');
        Route::put('/bot', [App\Http\Controllers\Back\SettingController::class, 'botUpdate'])->name('bot.update');
    });
});
