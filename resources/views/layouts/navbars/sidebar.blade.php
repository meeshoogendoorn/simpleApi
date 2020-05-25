<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png"  class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <a href="{{ route('logout') }}" class="btn btn-outline-danger" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                <i class="ni ni-user-run"></i>
                <span>{{ __('Logout') }}</span>
            </a>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("profile.edit")}}">
                        <i class="ni ni-circle-08 text-red"></i> {{ __('My Profile') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route("servers.index")}}">
                        <i class="ni ni-planet text-black-50"></i> {{ __('Servers') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("songs.index")}}">
                        <i class="ni ni-sound-wave text-orange"></i> {{ __('Songs') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route("sources.index")}}">
                        <i class="ni ni-key-25 text-info"></i> {{ __('Sources') }}
                    </a>
                </li>
                @if(auth()->user()->admin && \Illuminate\Support\Facades\Session::get("admin"))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("users.index")}}">
                            <i class="ni ni-ungroup text-info"></i> {{ __('Users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("settings.index")}}">
                            <i class="ni ni-settings text-yellow"></i> {{ __('Settings') }}
                        </a>
                    </li>
                @endif
                @php
                    $users_with_player_permissions = \App\Config::where("key", "=", "users_with_player_permissions")->first();
                    if(! empty($users_with_player_permissions)){
                        $users = explode(",", $users_with_player_permissions->value);
                    }
                @endphp
                @if(auth()->user()->admin && \Illuminate\Support\Facades\Session::get("admin") || in_array(auth()->user()->email, $users))
                    <li class="nav-item">
                        <a class="nav-link" href="{{route("players.create")}}">
                            <i class="ni ni-credit-card text-yellow"></i> {{ __('Players') }}
                        </a>
                    </li>
                @endif
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <ul class="navbar-nav">
                @if(auth()->user()->admin)
                    @if(\Illuminate\Support\Facades\Session::get("admin"))
                        <li class="nav-item">
                            <a href="{{ route("set.admin", 0) }}" class="nav-link">
                                <i class="ni ni-time-alarm text-success"></i> {{ __('Switch to user') }}
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route("set.admin", 1) }}" class="nav-link">
                                <i class="ni ni-time-alarm text-danger"></i> {{ __('Switch to admin') }}
                            </a>
                        </li>
                    @endif
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run text-danger"></i> {{ __('Logout') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
