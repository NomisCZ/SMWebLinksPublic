@extends('layouts.master')

@section('content')
    <div class="error">
        <div class="error-code">403</div>
        <h3 class="text-uppercase"><i class="fa fa-lock"></i> @lang('core.error.no-permissions.title')</h3>
        <p class="text-muted m-t-30 m-b-30">
            @lang('core.error.no-permissions.text')
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">@lang('core.text.return-home')</a>
    </div>
    @include('layouts.partials._footer')
@endsection