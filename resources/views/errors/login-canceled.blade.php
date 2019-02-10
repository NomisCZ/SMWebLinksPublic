@extends('layouts.master')

@section('content')
    <div class="grid-main container grid-lg">
        <div class="columns">
            <div class="column col-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-auto">
                    <div class="panel-header text-center bg-primary">
                        <div class="panel-title err h1">4<i class="fab fa-steam-symbol"></i>0</div>
                    </div>
                    <div class="panel-body bg-dark">
                        <div class="panel-header text-center">
                            <div class="panel-title h5 mt-10">@lang('core.error.login-canceled.title')</div>
                            <div class="panel-subtitle">@lang('core.error.login-canceled.text')</div>
                            <a href="{{ route('web.redirect.method', ['fetchMethod' => 'steamid']) }}" class="btn btn-primary mt-2"><i class="fas fa-undo"></i> @lang('core.text.try-again')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection