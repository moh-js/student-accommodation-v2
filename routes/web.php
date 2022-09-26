<?php

use App\Models\Room;
use App\Models\Student;
use App\Models\Shortlist;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SideController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BillingController;

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

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Guest

/*
Application routes
*/
Route::prefix('student')->middleware('guest')->group(function ()
{
    Route::get('apply', [ApplicationController::class, 'index'])->name('apply');
    Route::post('apply', [ApplicationController::class, 'studentType'])->name('student-type');
    Route::get('identification', [ApplicationController::class, 'identification'])->name('identification');
    Route::post('identification', [ApplicationController::class, 'identify'])->name('identify');
    Route::post('resume', [ApplicationController::class, 'resume'])->name('resume');
    Route::get('application/get-status', [ApplicationController::class, 'getStatus'])->name('applications-status');
    Route::get('application/{student}', [ApplicationController::class, 'application'])->name('application');
    Route::post('application/{student}', [ApplicationController::class, 'apply'])->name('application.send');
    Route::get('otp/{student}', [ApplicationController::class, 'sendOTP'])->name('otp.send')->middleware('throttle:OTPRequest');
    Route::get('payment/{student}', [ApplicationController::class, 'payment'])->name('payment');
    Route::post('invoice-otp/{student}/{otp?}', [ApplicationController::class, 'createInvoice'])->name('invoice.create-otp');
    Route::get('allocation/{student}/{academic_year}', [ApplicationController::class, 'allocation'])->name('allocation');
});

/* Billing routes */


/* Status routes */


// Auth

/*
Dashboard routes
*/


Route::middleware('auth:sanctum')->group(function ()
{
    Route::prefix('invoices')->controller(InvoiceController::class)->group(function ()
    {
        Route::get('/{academicYear}', 'index')->name('invoices.index');
        Route::post('/fetch', 'fetch')->name('invoices.fetch');
    });

    Route::resource('users', UserController::class)->except(['show']);
    Route::post('role', [RoleController::class, 'grantPermission'])->name('role.grant');
    Route::resource('roles', RoleController::class);
    Route::resource('blocks', BlockController::class)->except(['show']);
    Route::resource('sides', SideController::class)->except(['show']);
    Route::resource('rooms', RoomController::class)->except(['show']);

    Route::prefix('applications')->controller(ApplicationController::class)->group(function ()
    {
        Route::get('/', 'applicationLists')->name('applications-list');
        Route::get('/shortlist', 'shortlistPage')->name('shortlist');
        Route::delete('/shortlist/{shortlist}', 'removeShortlisted')->name('remove.shortlisted');
        Route::post('/student/shortlist', 'shortlist')->name('applications.shortlist');
        Route::delete('/{application}', 'decline')->name('application-decline');
        Route::post('/{application}', 'accept')->name('application-accept');
    });

    Route::resource('students', StudentController::class);

    Route::prefix('deadlines')->controller(DeadlineController::class)->group(function ()
    {
        Route::get('/', 'index')->name('deadline.index');
        Route::get('/set', 'set')->name('deadline.set');
        Route::post('/set', 'store')->name('deadline.store');
        Route::delete('/{deadline}', 'destroy')->name('deadline.delete');
    });
    
    Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->name('dashboard');
});

// Route::get('test', function ()
// {
//     return dd(smsapi(["255658106643","255679319717"], "Hello Guys"));
// });

Route::get('get-rooms', function ()
{
   return Room::femaleRooms()->sum('capacity');
});

Route::get('get-shortlist', function ()
{
    return Shortlist::maleShortlist()->with('student')->get();
});
