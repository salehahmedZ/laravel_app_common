@component('LaravelAppCommon::vendor.mail.html.layout')
    {{-- Header --}}
@slot('header')
@component('LaravelAppCommon::vendor.mail.html.header', ['url' => config('app.url')])
{{ trans('LaravelAppCommon::notification.app name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('LaravelAppCommon::vendor.mail.html.subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('LaravelAppCommon::vendor.mail.html.footer')
© {{ date('Y') }} {{ trans('LaravelAppCommon::notification.app name') }}. {{ trans('LaravelAppCommon::notification.All rights reserved') }}
@endcomponent
@endslot
@endcomponent
