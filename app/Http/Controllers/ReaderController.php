<?php
namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;

class ReaderController extends Controller
{
    public function index()
    {
        return view('readers.index', ['readers' => Reader::orderBy('name')->get()]);
    }

    public function store(Request $r)
    {
        Reader::create($r->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:readers,email',
        ]));
        return back()->with('ok', 'Čtenář přidán.');
    }
}
