<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Knihovna</title>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="{{ asset('css/library.css') }}" rel="stylesheet">
</head>
<body>
  <header class="top"><div class="in">
    <a class="logo" href="{{ route('books.index') }}"><x-icon name="book" :size="26"/> Knihovna</a>
    <nav>
      <a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.*') ? 'on' : '' }}"><x-icon name="book"/><span>Knihy</span></a>
      <a href="{{ route('readers.index') }}" class="{{ request()->routeIs('readers.*') ? 'on' : '' }}"><x-icon name="users"/><span>Čtenáři</span></a>
      <a href="{{ route('loans.overdue') }}" class="{{ request()->routeIs('loans.*') ? 'on' : '' }}"><x-icon name="clock"/><span>Po termínu</span></a>
    </nav>
  </div></header>
  <main>
    @if(session('ok'))<div class="flash ok"><x-icon name="check"/>{{ session('ok') }}</div>@endif
    @foreach($errors->all() as $e)<div class="flash err"><x-icon name="alert"/>{{ $e }}</div>@endforeach
    @yield('content')
  </main>
</body>
</html>
