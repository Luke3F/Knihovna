@extends('layout')
@section('content')
<div class="head"><h1>{{ $book->exists ? 'Upravit knihu' : 'Nová kniha' }}</h1></div>
<form class="card" style="max-width:560px" method="POST" action="{{ $book->exists ? route('books.update', $book) : route('books.store') }}">
  @csrf @if($book->exists) @method('PUT') @endif
  <label>Název</label><input name="title" value="{{ old('title', $book->title) }}">
  <label>Autor</label><input name="author" value="{{ old('author', $book->author) }}">
  <label>ISBN (13 znaků)</label><input name="isbn" maxlength="13" value="{{ old('isbn', $book->isbn) }}">
  <label>Dostupné výtisky</label><input type="number" min="0" name="available_copies" value="{{ old('available_copies', $book->available_copies ?? 1) }}">
  <div class="acts" style="margin-top:1.4rem">
    <button class="btn"><x-icon name="check"/> Uložit</button>
    <a class="btn ghost" href="{{ route('books.index') }}">Zrušit</a>
  </div>
</form>
@endsection
