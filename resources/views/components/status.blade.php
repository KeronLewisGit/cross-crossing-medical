@props(['status', 'type' => null])
<x-chip :tone="$status->tone()" :icon="$status->icon()" {{ $attributes }}>{{ $status->label($type) }}</x-chip>
