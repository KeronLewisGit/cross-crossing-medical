@props(['draw' => false, 'muted' => false])
{{-- A monitor trace: flat, one heartbeat, flat. Decorative. --}}
<svg {{ $attributes->class(['pulse-line', 'draw' => $draw, 'muted' => $muted]) }} viewBox="0 0 1200 34" preserveAspectRatio="none" aria-hidden="true" focusable="false">
    <path d="M0 22 H420 l14 0 8 -6 8 6 h14 l8 8 12 -28 12 28 8 -8 h22 l10 -7 10 7 H760 l10 0 6 -4 6 4 h10 l6 6 9 -20 9 20 6 -6 h16 l8 -5 8 5 H1200" />
</svg>
