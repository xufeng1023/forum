@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => env('ALLOW_HTTP')])
            {{ env('MAIL_HEADER') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            &copy; {{ date('Y') }} {{ env('MAIL_HEADER') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
