<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubmissionController;

Route::view('/', 'home')->name('home');
Route::view('services', 'services')->name('services');
Route::view('about', 'about')->name('about');
Route::view('contact', 'contact')->name('contact');

Route::post('/submit-contact-form', [SubmissionController::class, 'store'])
     ->name('contact.submit');

// New routes for file management
Route::get('/submissions/{submissionId}/files', [SubmissionController::class, 'listFiles'])
     ->name('submissions.files');

Route::get('/download-file', [SubmissionController::class, 'downloadFile'])
     ->name('file.download');
