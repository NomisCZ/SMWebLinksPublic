@extends('layouts.master')

@section('content')
    <div class="grid-main container grid-lg">
        <div class="columns">
            <div class="column col-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-auto">
                    <div class="panel-header text-center bg-error">
                        <div class="panel-title err h1">5<i class="fas fa-meteor"></i>3</div>
                    </div>
                    <div class="panel-body bg-dark">
                        <div class="panel-header text-center">
                            <div class="panel-title h5 mt-10">@lang('core.error.request-not-available.title')</div>
                            <div class="panel-subtitle">@lang('core.error.request-not-available.text')</div>
                            @isset ($url)
                                <span class="text-muted"><i class="fa fa-exclamation-triangle"></i> {{ $url }}</span>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection