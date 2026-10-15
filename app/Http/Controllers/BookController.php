<?php
namespace App\Http\Controllers;

use App\Models\{Book, Reader};
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    private function rules(?Book $book = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => ['required', 'string', 'size:13', Rule::unique('books', 'isbn')->ignore($book?->id)],
            'available_copies' => 'required|integer|min:0',
        ];
    }

    public function index(Request $r)
    {
        $books = Book::search($r->q)->orderBy('title')->paginate(10)->withQueryString();
        return view('books.index', compact('books'));
    }

    public function create() { return view('books.form', ['book' => new Book]); }

    public function store(Request $r)
    {
        Book::create($r->validate($this->rules()));
        return redirect()->route('books.index')->with('ok', 'Kniha vytvořena.');
    }

    public function show(Book $book)
    {
        $loans = $book->loans()->with('reader')->latest('borrowed_at')->get();
        return view('books.show', ['book' => $book, 'loans' => $loans, 'readers' => Reader::orderBy('name')->get()]);
    }

    public function edit(Book $book) { return view('books.form', compact('book')); }

    public function update(Request $r, Book $book)
    {
        $book->update($r->validate($this->rules($book)));
        return redirect()->route('books.show', $book)->with('ok', 'Kniha upravena.');
    }

    public function destroy(Book $book)
    {
        // Knihu s historií výpůjček nemažeme (FK restrict)
        if ($book->loans()->exists()) {
            return back()->withErrors('Knihu s výpůjčkami nelze smazat.');
        }
        $book->delete();
        return redirect()->route('books.index')->with('ok', 'Kniha smazána.');
    }
}
