<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\coach\AttendanceController;
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
Route::get('/courses', function () {
    return view('dashboards.shared.courses.course');
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
// User routes end



// Event routes start
Route::get('/event', function () {
    return view('dashboards.shared.events.event');
});
Route::resource('events', EventController::class);
// Event routes end


Route::resource('attendance', AttendanceController::class);


require __DIR__.'/auth.php';


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