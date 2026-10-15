<?php
use App\Http\Controllers\{BookController, ReaderController, LoanController};
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books');
Route::resource('books', BookController::class);
Route::get('readers', [ReaderController::class, 'index'])->name('readers.index');
Route::post('readers', [ReaderController::class, 'store'])->name('readers.store');
Route::get('loans/overdue', [LoanController::class, 'overdue'])->name('loans.overdue');
Route::post('loans', [LoanController::class, 'store'])->name('loans.store');
Route::post('loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
