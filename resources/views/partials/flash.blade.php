@php
    $flash = session('flash');
@endphp

@if ($flash)
    <div class="flash flash-{{ $flash['type'] ?? 'success' }}" data-flash data-redirect="{{ $flash['redirect_to'] ?? '' }}">
        <span>{{ $flash['message'] }}</span>
    </div>
@endif
