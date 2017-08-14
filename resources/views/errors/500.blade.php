@extends('layouts.master')

@section('content')
    <div class="error">
        <div class="error-code">500</div>
        <h3 class="text-uppercase"><i class="fa fa-warning"></i> @lang('core.error.system-error.title')</h3>
        <p class="text-muted m-t-30 m-b-30">
            @lang('core.error.system-error.text')
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">@lang('core.text.return-home')</a>
    </div>
    @include('layouts.partials._footer')
@endsection