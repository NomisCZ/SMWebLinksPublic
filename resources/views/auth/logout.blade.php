@extends('layouts.master')

@section('content')
    <div class="grid-main container grid-lg">
        <div class="columns">
            <div class="column col-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-auto">
                    <div class="panel-header text-center bg-{{ isset($notLogged) && $notLogged ? 'primary' : 'success' }}">
                        <div class="panel-title err h1"><i class="fas fa-{{ isset($notLogged) && $notLogged ? 'user-slash' : 'sign-out-alt' }}"></i></div>
                    </div>
                    <div class="panel-body bg-dark">
                        <div class="panel-header text-center">
                            <div class="panel-title h5 mt-10">@lang( isset($notLogged) && $notLogged ? 'core.info.logout-not.title' : 'core.info.logout-success.title')</div>
                            <div class="panel-subtitle">@lang( isset($notLogged) && $notLogged ? 'core.info.logout-not.text' : 'core.info.logout-success.text')</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection