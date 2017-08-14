@extends('layouts.master')

@section('content')
    <div class="error">
        <div class="error-code">404</div>
        <h3 class="text-uppercase">@lang('core.error.page-not-found.title')</h3>
        <p class="text-muted m-t-30 m-b-30">
            @lang('core.error.page-not-found.text', ['url' => 'return to home'])
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">@lang('core.text.return-home')</a>
    </div>
    @include('layouts.partials._footer')
@endsection