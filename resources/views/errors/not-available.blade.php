@extends('layouts.master')

@section('content')
    <div class="error">
        <div class="error-code"><i class="fa fa-plug" aria-hidden="true"></i></div>
        <h3 class="text-uppercase">@lang('core.error.request-not-available.title')</h3>
        @isset ($url)
            <p class="text-muted"><i class="fa fa-exclamation-triangle"></i> {{ $url }}</p>
        @endisset
        <p class="text-muted m-t-30 m-b-30">
            @lang('core.error.request-not-available.text')
        </p>
    </div>
    @include('layouts.partials._footer')
@endsection