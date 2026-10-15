@props(['name', 'size' => 18])
@php
$p = [
 'book' => '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
 'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
 'clock' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
 'plus' => '<path d="M12 5v14M5 12h14"/>',
 'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
 'edit' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
 'trash' => '<path d="M3 6h18M19 6l-1 14H6L5 6M8 6V4h8v2"/>',
 'check' => '<path d="M20 6 9 17l-5-5"/>',
 'undo' => '<path d="M3 7v6h6"/><path d="M21 17a9 9 0 0 0-15-6.7L3 13"/>',
 'alert' => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>',
];
@endphp
<svg class="icon" width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $p[$name] !!}</svg>
