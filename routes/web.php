<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/consultants', function () {
    return view('consultants.index');
})->name('consultants.index');

Route::get('/consultants/{consultant}', function (\App\Models\Consultant $consultant) {
    return view('consultants.show', compact('consultant'));
})->name('consultants.show');

// Protected Routes
Route::middleware('auth')->group(function () {
    
    // Unified Dashboard Route - renders different views based on role
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return view('dashboard.admin');
        } elseif ($user->isConsultant()) {
            return view('dashboard.consultant');
        } else {
            return view('dashboard.client');
        }
    })->name('dashboard');

    // Client Booking Flow
    Route::get('/book/{consultant}', function (\App\Models\Consultant $consultant) {
        if (!auth()->user()->isClient()) abort(403, 'Only clients can book sessions.');
        return view('booking.index', compact('consultant'));
    })->name('booking');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
