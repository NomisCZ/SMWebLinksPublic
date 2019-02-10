@extends('layouts.master')

@section('content')
    <div class="grid-main grid-pt-2 container grid-lg">
        <div class="columns col-gapless">
            <div class="column col-7 col-md-12 col-sm-12 col-xs-12">
                <div class="panel">
                    <div class="panel-header text-center bg-primary">
                        <i class="fas fa-exchange-alt fa-5x"></i>
                        <div class="panel-title h5 mt-10">WebLinks</div>
                        <div class="panel-subtitle">We need to approve a few things.</div>
                    </div>
                    <div class="panel-body bg-dark">
                        <div class="panel-header">
                            <div class="panel-title h4">Permissions</div>
                        </div>
                        <div class="panel-body">
                            <div class="tile">
                                <div class="tile-icon">
                                    <i class="fab fa-steam fa-4x"></i>
                                </div>
                                <div class="tile-content">
                                    <span class="tile-title text-bold">Steam profile</span>
                                    <div class="tile-subtitle pb-2">Read your <b>Steam ID</b>. We need your Steam ID as the key to fetch your requested website.</div>
                                    <div class="pb-2"><i class="fas fa-eye-slash"></i> We do not store your Steam profile data in our database. We do not provide this data to third parties.</div>
                                    <div class="text-error pb-2"><i class="fas fa-exclamation-triangle"></i> This website is not affiliated with Valve Corporation or Steam.</div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="tile">
                                <div class="tile-icon">
                                    <i class="far fa-window-maximize fa-4x"></i>
                                </div>
                                <div class="tile-content">
                                    <span class="tile-title text-bold">Browser</span>
                                    <p class="tile-subtitle">Temporary store your Steam ID as encrypted cookie for 7 days (auto login).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="toast toast-error text-center">
                        <i class="fas fa-user-check"></i> If you agree, click on the "Login via Steam" button to continue.
                    </div>
                    <div class="panel-footer bg-dark">
                        <div class="btn-group btn-group-block">
                            <a href="{{ route('error.login-canceled') }}" class="btn" id="btn-cancel"><i class="fas fa-times fa-lg"></i> Cancel</a>
                            <a href="{{ route('auth.provider.steam') }}" class="btn btn-primary" onclick="steamLoginClick(this)"><i class="fab fa-steam-symbol fa-lg"></i> Login via Steam</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column col-5 col-md-12 col-sm-12 col-xs-12">
                <div class="panel bg-dark">
                    <div class="panel-header">
                        <div class="panel-title h4">Information</div>
                    </div>
                    <div class="panel-body">
                        <div class="tile">
                            <div class="tile-icon">
                                <i class="fas fa-question-circle fa-4x"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-title text-bold">What is this ?!</span>
                                <p class="tile-subtitle">Don't worry, your game server using ingame
                                    <span class="text-bold tooltip tooltip-light tooltip-bottom" data-tooltip="Chat commands to open external websites.">web shortcuts</span> API.</p>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="tile-icon">
                                <i class="fas fa-cookie fa-4x"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-title text-bold">Cookies</span>
                                <p class="tile-subtitle">We use cookies to improve your experience on our site and to temporary store some information (Steam ID).</p>
                                <p class="text-error"><i class="fas fa-exclamation-triangle"></i> If you don't want to store cookies, we can't proceed your request. So, please click on "Cancel" button.</p>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="tile-icon">
                                <i class="fas fa-lock fa-4x"></i>
                            </div>
                            <div class="tile-content">
                                <span class="tile-title text-bold">Security</span>
                                <p class="tile-subtitle">We use HTTPS to secure all API requests.</p>
                                <div class="pb-2"><i class="fas fa-fingerprint"></i> Stored cookies are encrypted.</div>
                                <div class="pb-2"><i class="fas fa-history"></i> We do not store requests for more than 5 minutes.</div>
                                <div class="pb-2"><i class="fas fa-eraser"></i> The request is automatically deleted after successful processing.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function steamLoginClick(el) {
            el.classList.add('loading', 'disabled');
            document.getElementById('btn-cancel').classList.add('disabled');
        }
    </script>
@endpush