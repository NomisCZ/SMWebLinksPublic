@extends('layouts.master')

@section('content')
    <div class="error">
        <div class="error-code"><i class="fa fa-podcast" aria-hidden="true"></i></div>
        <h3 class="text-uppercase">@lang('core.error.request-failed.title')</h3>
        <p class="text-muted m-t-30 m-b-30">
            @lang('core.error.request-failed.text')
        </p>
    </div>
    @include('layouts.partials._footer')
@endsection