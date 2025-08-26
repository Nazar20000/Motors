@props(['to' => null, 'label' => 'Назад'])
@php
    $previous = url()->previous();
    $current = url()->current();
    $target = $to ?: ($previous !== $current ? $previous : route('admin.index'));
@endphp
<a href="{{ $target }}" class="back-btn">
    <span class="material-symbols-outlined">arrow_back</span>
    {{ $label }}
    </a>


