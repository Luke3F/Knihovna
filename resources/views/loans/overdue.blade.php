@extends('layout')
@section('content')
<div class="head"><div><h1>Po termínu</h1><p class="sub">Nevrácené knihy s prošlým termínem: {{ $loans->count() }}</p></div></div>
<table>
  <tr><th>Kniha</th><th>Čtenář</th><th>Termín</th><th>Zpoždění</th><th></th></tr>
  @forelse($loans as $l)
  <tr>
    <td><a href="{{ route('books.show', $l->book) }}"><b>{{ $l->book->title }}</b></a></td>
    <td>{{ $l->reader->name }}</td>
    <td>{{ $l->due_at->format('j. n. Y H:i') }}</td>
    <td><span class="pill no">{{ (int) $l->due_at->diffInDays(now()) }} dní</span></td>
    <td style="text-align:right"><form method="POST" action="{{ route('loans.return', $l) }}">@csrf<button class="btn ghost sm"><x-icon name="undo" :size="15"/> Vrátit</button></form></td>
  </tr>
  @empty<tr><td colspan="5" class="empty">Všechno je vrácené včas. 🎉</td></tr>
  @endforelse
</table>
@endsection
