<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{slug}', [PageController::class, 'department'])->where('slug', '[a-z-]+')->name('department');
Route::get('/clinics', [PageController::class, 'clinics'])->name('clinics');
Route::get('/appointments', [FormController::class, 'appointment'])->name('appointments');
Route::get('/new-patients', [PageController::class, 'newPatients'])->name('new-patients');
Route::get('/patient-handouts', [PageController::class, 'handouts'])->name('handouts');
Route::get('/health-checks', [PageController::class, 'healthChecks'])->name('health-checks');
Route::get('/careers', [PageController::class, 'careers'])->name('careers');
Route::get('/careers/apply', [FormController::class, 'apply'])->name('careers.apply');
Route::get('/careers/{job}', [PageController::class, 'job'])->name('careers.show');

Route::middleware('throttle:forms')->group(function () {
    Route::post('/appointments', [FormController::class, 'storeAppointment'])->name('appointments.store');
    Route::post('/new-patients', [FormController::class, 'storeRegistration'])->name('new-patients.store');
    Route::post('/services/dialysis', [FormController::class, 'storeDialysis'])->name('dialysis.store');
    Route::post('/careers/apply', [FormController::class, 'storeApplication'])->name('careers.store');
    Route::post('/contact', [FormController::class, 'storeEnquiry'])->name('contact.store');
});
Route::get('/thanks', [FormController::class, 'thanks'])->name('thanks');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/photo-credits', [PageController::class, 'credits'])->name('credits');
Route::get('/sitemap', [PageController::class, 'sitemapPage'])->name('sitemap.page');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

// The old Google Site: /newpatient, /facilities/dialysis, /site/ccmctt/… and friends.
Route::get('/site/ccmctt/{path?}', [PageController::class, 'legacy'])->where('path', '.*');
Route::get('/{path}', [PageController::class, 'legacy'])
    ->where('path', '(cross-crossing-medical-centre|facilities|newpatient|patient-corner|self-evaluation|media)(/.*)?');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'active'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::get('/requests', [Admin\SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/requests/export', [Admin\SubmissionController::class, 'export'])->name('submissions.export');
    Route::get('/requests/{submission}', [Admin\SubmissionController::class, 'show'])->name('submissions.show');
    Route::patch('/requests/{submission}', [Admin\SubmissionController::class, 'update'])->name('submissions.update');
    Route::post('/requests/{submission}/notes', [Admin\SubmissionController::class, 'note'])->name('submissions.note');
    Route::get('/requests/{submission}/files/{file}', [Admin\SubmissionController::class, 'file'])->name('submissions.file');

    Route::middleware('role:admin,front_desk')->get('/appointments', Admin\AppointmentController::class)->name('appointments.index');

    Route::middleware('role:admin,records')->get('/document-log', Admin\DocumentLogController::class)->name('document-log');

    Route::middleware('role:admin,hr')->group(function () {
        Route::resource('jobs', Admin\JobPostingController::class)->except('show');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('handouts', Admin\HandoutController::class)->except('show');
        Route::get('/settings', [Admin\SettingsController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::post('/users', [Admin\UserController::class, 'store'])->name('users.store');
        Route::patch('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    });
});
