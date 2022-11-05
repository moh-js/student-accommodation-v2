<?php

use App\Models\Room;
use App\Models\Student;
use App\Models\Shortlist;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use App\Exports\ShortlistExport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SideController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShortlistController;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest

/*
Application routes
*/
Route::prefix('student')->middleware('guest')->group(function () {
    Route::get('apply', [ApplicationController::class, 'index'])->name('apply');
    Route::post('apply', [ApplicationController::class, 'studentType'])->name('student-type');
    Route::get('identification', [ApplicationController::class, 'identification'])->name('identification');
    Route::post('identification', [ApplicationController::class, 'identify'])->name('identify');
    Route::post('resume', [ApplicationController::class, 'resume'])->name('resume');
    Route::get('application/get-status', [ApplicationController::class, 'getStatus'])->name('applications-status');
    Route::get('application/{student}', [ApplicationController::class, 'application'])->name('application');
    Route::post('application/{student}', [ApplicationController::class, 'apply'])->name('application.send');
    // Route::get('application/{student}/edit', [ApplicationController::class, 'editApplication'])->name('application.edit');
    // Route::put('application/{student}/edit', [ApplicationController::class, 'editApplication'])->name('application.update');
    Route::get('otp/{student}', [ApplicationController::class, 'sendOTP'])->name('otp.send')->middleware('throttle:OTPRequest');
    Route::get('payment/{student}', [ApplicationController::class, 'payment'])->name('payment');
    Route::post('payment/{student}', [ApplicationController::class, 'paymentFresher'])->name('payment.fresher');
    Route::post('invoice-otp/{student}/{otp?}', [ApplicationController::class, 'createInvoice'])->name('invoice.create-otp');
    Route::get('allocation/{student}/{academic_year}', [ApplicationController::class, 'allocation'])->name('allocation');
});

/* Billing routes */


/* Status routes */


// Auth
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('invoices')->controller(InvoiceController::class)->group(function () {
        Route::get('/{academicYear}', 'index')->name('invoices.index');
        Route::post('/fetch', 'fetch')->name('invoices.fetch');
        Route::delete('/{invoice}', 'destroy')->name('invoices.destroy');
        Route::put('/{invoice}', 'update')->name('invoices.update');
    });

    Route::get('user/profile', [UserController::class, 'changePersonalInfoPage'])->name('user.profile');
    Route::post('user', [UserController::class, 'changePersonalInfo'])->name('user.profile.update');
    Route::post('user-password', [UserController::class, 'changePassword'])->name('user.profile.password');
    Route::resource('users', UserController::class)->except(['show']);
    Route::post('role/{role}', [RoleController::class, 'grantPermission'])->name('role.grant');
    Route::resource('roles', RoleController::class);
    Route::resource('blocks', BlockController::class)->except(['show']);
    Route::resource('sides', SideController::class)->except(['show']);
    Route::resource('rooms', RoomController::class)->except(['show']);

    Route::prefix('applications')->controller(ApplicationController::class)->group(function () {
        Route::get('/', 'applicationLists')->name('applications-list');
        Route::get('/shortlist', 'shortlistPage')->name('shortlist');
        Route::get('/shortlist-publish', 'publish')->name('publish');
        Route::delete('/shortlist/{shortlist}', 'removeShortlisted')->name('remove.shortlisted');
        Route::post('/student/shortlist', 'shortlist')->name('applications.shortlist');
        Route::delete('/{application}', 'decline')->name('application-decline');
        Route::post('/{application}', 'accept')->name('application-accept');
    });

    Route::get('students-import/goverment', [StudentController::class, 'importGovSponsorPage'])->name('students.import.gov');
    Route::post('students-import/goverment', [StudentController::class, 'importGovSponsor'])->name('students.store.gov');
    Route::resource('students', StudentController::class);

    Route::prefix('deadlines')->controller(DeadlineController::class)->group(function () {
        Route::get('/', 'index')->name('deadline.index');
        Route::get('/set', 'set')->name('deadline.set');
        Route::post('/set', 'store')->name('deadline.store');
        Route::delete('/{deadline}', 'destroy')->name('deadline.delete');
    });

    // Reports
    Route::post('export-shortlisted', [ReportController::class, 'exportShortlistedSimple'])->name('export.shortlisted.simple');
    Route::get('report-payment', [ReportController::class, 'reportPayment'])->name('report.payment');
    Route::get('export-report-payment', [ReportController::class, 'exportPayment'])->name('export.payment');
    Route::get('report-shortlisted', [ReportController::class, 'reportShortlisted'])->name('report.shortlisted');
    Route::get('report-student', [ReportController::class, 'reportStudent'])->name('report.student');
    Route::get('export-student', [ReportController::class, 'exportStudent'])->name('export.student');
    Route::get('report-application', [ReportController::class, 'reportApplication'])->name('report.application');
    Route::get('export-report-application', [ReportController::class, 'exportApplication'])->name('export.application');



    Route::get('download-file/{path}', function ($file_path) {
        return response()->download(storage_path('app/' . $file_path));
    })->name('download.file');

    Route::get('invoice-create/{student?}', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('invoice-create/{student?}', [InvoiceController::class, 'store'])->name('invoice.store');

    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Anonymous Invoice creation
    Route::get('invoice/create', [InvoiceController::class, 'createNonRegisteredStudentInvoicePage'])->name('invoice.create.nonstudent');
    Route::post('invoice/store', [InvoiceController::class, 'createNonRegisteredStudentInvoice'])->name('invoice.store.nonstudent');

    // Setting
    Route::get('settings/allocation', [SettingController::class, 'allocation'])->name('allocation.setting');
    Route::post('settings/allocation', [SettingController::class, 'allocationStore'])->name('allocation.setting.store');

    Route::post('ban-selection', [ShortlistController::class, 'banSelected'])->name('ban.selection');
});

// Route::get('test', function ()
// {

//     // return session('male_rooms');
//     // return dd(smsapi(["255658106643","255679319717"], "Hello Guys"));
// });

Route::get('ban-test', [TestController::class, 'banTest']);

// Route::get('get-rooms', function ()
// {
//    return Room::maleRooms()->get()->sum('capacity');
// });

// Route::get('get-shortlist', function ()
// {
//     return Shortlist::maleShortlist()/* ->with('student') */->count();
// });


// Route::get('export-all', function ()
// {   
//     (new ShortlistExport)->queue('shortlists.xlsx');
// });

// Route::get('export-male', function ()
// {   
//     (new ShortlistExport(1))->queue('shortlists.xlsx');
// });

// Route::get('export-female', function ()
// {   
//     (new ShortlistExport(2))->queue('shortlists.xlsx');
// });
