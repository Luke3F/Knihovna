<?php
namespace App\Http\Controllers;

use App\Models\{Book, Loan};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function store(Request $r)
    {
        // Výchozí borrowed_at = teď
        $r->merge(['borrowed_at' => $r->borrowed_at ?: now()->toDateTimeString()]);

        $data = $r->validate([
            'book_id' => 'required|exists:books,id',
            'reader_id' => 'required|exists:readers,id',
            'borrowed_at' => 'required|date',
            'due_at' => 'required|date|after:borrowed_at', // due_at > borrowed_at
        ]);

        DB::transaction(function () use ($data) {
            // Zámek řádku proti souběžnému půjčení posledního kusu
            $book = Book::lockForUpdate()->findOrFail($data['book_id']);

            if ($book->available_copies < 1) {
                throw ValidationException::withMessages(['book_id' => 'Žádný výtisk není dostupný.']);
            }
            $already = Loan::where('book_id', $book->id)
                ->where('reader_id', $data['reader_id'])
                ->whereNull('returned_at')->exists();
            if ($already) {
                throw ValidationException::withMessages(['reader_id' => 'Čtenář už tuto knihu má půjčenou.']);
            }

            Loan::create($data);
            $book->decrement('available_copies');
        });

        return back()->with('ok', 'Výpůjčka založena.');
    }

    public function return(Loan $loan)
    {
        if ($loan->returned_at) {
            return back()->withErrors('Kniha už byla vrácena.');
        }
        DB::transaction(function () use ($loan) {
            $loan->update(['returned_at' => now()]);
            $loan->book()->increment('available_copies');
        });
        return back()->with('ok', 'Kniha vrácena.');
    }

    public function overdue()
    {
        $loans = Loan::with(['book', 'reader'])
            ->whereNull('returned_at')->where('due_at', '<', now())
            ->orderBy('due_at')->get();
        return view('loans.overdue', compact('loans'));
    }
}
