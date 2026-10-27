@props(['code' => null, 'label', 'ae' => false, 'arrow' => true])
{{-- Ward-sign label: a code panel (room number) and the label in capitals with an arrow. --}}
<p {{ $attributes->class(['sign', 'sign-ae' => $ae]) }}>
    @if ($code)<span class="code">{{ $code }}</span>@endif
    <span>{{ $label }}@if ($arrow)<x-icon name="arrow-right" class="arrow" />@endif</span>
</p>
