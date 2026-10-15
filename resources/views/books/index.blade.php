@extends('layout')
@section('content')
<div class="head">
  <div><h1>Knihy</h1><p class="sub">Celkem nalezeno: {{ $books->total() }}</p></div>
  <form method="GET" class="search">
    <x-icon name="search"/><input name="q" value="{{ request('q') }}" placeholder="Hledat název nebo autora…">
  </form>
  <a class="btn gold" href="{{ route('books.create') }}"><x-icon name="plus"/> Nová kniha</a>
</div>
<div class="grid">
  @forelse($books as $b)
  <a class="book" href="{{ route('books.show', $b) }}">
    {{-- Barva obálky se odvozuje z názvu --}}
    <div class="cover" style="--h:{{ crc32($b->title) % 360 }}"><b>{{ $b->title }}</b><small>{{ $b->author }}</small></div>
    <div class="meta"><span>{{ $b->isbn }}</span>
      <span class="pill {{ $b->available_copies > 0 ? 'ok' : 'no' }}">{{ $b->available_copies > 0 ? $b->available_copies.' ks' : 'Půjčeno' }}</span></div>
  </a>
  @empty<p class="sub">Žádné knihy.</p>
  @endforelse
</div>
<div class="pager">{{ $books->links() }}</div>
@endsection
