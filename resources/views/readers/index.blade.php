@extends('layout')
@section('content')
<div class="head"><div><h1>Čtenáři</h1><p class="sub">Celkem: {{ $readers->count() }}</p></div></div>
<form class="card row" method="POST" action="{{ route('readers.store') }}">
  @csrf
  <div><label style="margin-top:0">Jméno</label><input name="name" value="{{ old('name') }}"></div>
  <div><label style="margin-top:0">E-mail</label><input name="email" value="{{ old('email') }}"></div>
  <button class="btn gold"><x-icon name="plus"/> Přidat</button>
</form>
<div class="people">
  @foreach($readers as $r)
  <div class="card person">
    <div class="avatar" style="--h:{{ crc32($r->email) % 360 }}">{{ mb_strtoupper(mb_substr($r->name, 0, 1)) }}</div>
    <div><b>{{ $r->name }}</b><br><small>{{ $r->email }}</small></div>
  </div>
  @endforeach
</div>
@endsection
