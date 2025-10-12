<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\coach\AttendanceController;
use App\Http\Controllers\parent\ChildAttendanceController;
use App\Http\Controllers\coach\EvaluationController;
use App\Http\Controllers\coach\SessionController;
use App\Http\Controllers\coach\CourseController;
use App\Http\Controllers\coach\MonthlyPerformanceController;
use App\Http\Controllers\coach\SessionPerformanceController;
use App\Http\Controllers\shared\EventController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// User routes start
Route::resource('users', UserController::class);
Route::get('parent-child/{parent}', [UserController::class, 'showChildren'])
    ->name('parent-child.showChildren');
Route::post('parent-child/{parent}', [UserController::class, 'updateChildren'])
    ->name('parent-child.updateChildren');

// User routes end



// Event routes start
Route::get('/event', function () {
    return view('dashboards.shared.events.event');
});
Route::resource('events', EventController::class);
Route::post('/events/{event}/confirm', [EventController::class, 'confirm']);
Route::get('/events/{event}/confirmations', [EventController::class, 'confirmations']);
// Event routes end

// Coach Attendance routes start
Route::resource('attendance', AttendanceController::class);
// Coach Attendance routes end


// Coach evaluations routes start
Route::resource('evaluations', EvaluationController::class);
// Coach evaluations routes end

// Coach courses routes start
Route::resource('courses', CourseController::class);
Route::post('courses/{course}/sessions', [CourseController::class, 'addSession'])
    ->name('coach.courses.addSession');
Route::resource('courses.sessions', SessionController::class);
// Coach courses routes end

// Admin payments routes start
    Route::resource('payments', PaymentController::class);
    Route::post('payments/store-multiple', [PaymentController::class, 'storeMultiple'])->name('payments.storeMultiple');
    Route::post('payments/notify-unpaid', [PaymentController::class, 'notifyUnpaid'])->name('payments.notifyUnpaid');
// Admin payments routes end


// Coach session performances routes start
Route::resource('session_performances', SessionPerformanceController::class)->except(['edit']);
Route::get('monthly_performances', [MonthlyPerformanceController::class, 'index'])->name('monthly_performances.index');
Route::get('monthly_performances/{player}', [MonthlyPerformanceController::class, 'show'])->name('monthly_performances.show');
Route::get('monthly_performances/export/{monthly}', [MonthlyPerformanceController::class, 'exportPdf'])
    ->name('monthly_performances.export');
// Coach session performances routes end

Route::get('/parent/attendance', [ChildAttendanceController::class, 'index'])->name('parent.attendance.index');

require __DIR__ . '/auth.php';


// notification start 
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', function () {
        return view('notifications.index');
    })->name('notifications.index');

    Route::post('/notifications/{id}/read', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return back()->with('success', 'Notification marked as read');
    })->name('notifications.read');

    Route::post('/notifications/read-all', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read');
    })->name('notifications.readAll');

    Route::delete('/notifications/{id}', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->delete();
        return back()->with('success', 'Notification deleted');
    })->name('notifications.delete');

    Route::delete('/notifications', function () {
        auth()->user()->notifications()->delete();
        return back()->with('success', 'All notifications deleted');
    })->name('notifications.deleteAll');
});
// notification end 