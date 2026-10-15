@extends('layout')
@section('content')
<div class="hero">
  <div class="cover" style="--h:{{ crc32($book->title) % 360 }}"><b>{{ $book->title }}</b><small>{{ $book->author }}</small></div>
  <div>
    <h1>{{ $book->title }}</h1><p class="sub">{{ $book->author }}</p>
    <div class="chips">
      <div class="chip"><small>ISBN</small>{{ $book->isbn }}</div>
      <div class="chip"><small>Dostupné</small><span class="pill {{ $book->available_copies > 0 ? 'ok' : 'no' }}">{{ $book->available_copies }} ks</span></div>
      <div class="chip"><small>Výpůjček celkem</small>{{ $loans->count() }}</div>
    </div>
    <div class="acts">
      <a class="btn ghost sm" href="{{ route('books.edit', $book) }}"><x-icon name="edit" :size="15"/> Upravit</a>
      <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Opravdu smazat?')">
        @csrf @method('DELETE')<button class="btn danger sm"><x-icon name="trash" :size="15"/> Smazat</button>
      </form>
    </div>

    <h2>Půjčit knihu</h2>
    <form class="card row" method="POST" action="{{ route('loans.store') }}">
      @csrf <input type="hidden" name="book_id" value="{{ $book->id }}">
      <div><label style="margin-top:0">Čtenář</label>
        <select name="reader_id">@foreach($readers as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach</select></div>
      <div><label style="margin-top:0">Vrátit do</label>
        <input type="datetime-local" name="due_at" value="{{ old('due_at', now()->addDays(14)->format('Y-m-d\TH:i')) }}"></div>
      <button class="btn gold">Půjčit</button>
    </form>
  </div>
</div>

<h2>Historie výpůjček</h2>
<table>
  <tr><th>Čtenář</th><th>Půjčeno</th><th>Termín</th><th>Stav</th><th></th></tr>
  @forelse($loans as $l)
  <tr>
    <td>{{ $l->reader->name }}</td>
    <td>{{ $l->borrowed_at->format('j. n. Y') }}</td>
    <td>{{ $l->due_at->format('j. n. Y H:i') }}</td>
    <td>@if($l->returned_at)<span class="pill ok">Vráceno {{ $l->returned_at->format('j. n.') }}</span>
        @elseif($l->isOverdue())<span class="pill no">Po termínu</span>
        @else<span class="pill amber">Půjčeno</span>@endif</td>
    <td style="text-align:right">@unless($l->returned_at)
      <form method="POST" action="{{ route('loans.return', $l) }}">@csrf<button class="btn ghost sm"><x-icon name="undo" :size="15"/> Vrátit</button></form>
    @endunless</td>
  </tr>
  @empty<tr><td colspan="5" class="empty">Zatím žádné výpůjčky.</td></tr>
  @endforelse
</table>
@endsection
