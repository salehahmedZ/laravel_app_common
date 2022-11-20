@component('LaravelAppCommon::vendor.mail.text.layout')
    {{-- Header --}}
    @slot('header')
        @component('LaravelAppCommon::vendor.mail.text.header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('LaravelAppCommon::vendor.mail.text.subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('LaravelAppCommon::vendor.mail.text.footer')
            © {{ date('Y') }} {{ trans('LaravelAppCommon::notification.app name') }}. {{ trans('LaravelAppCommon::notification.All rights reserved') }}
        @endcomponent
    @endslot
@endcomponent
