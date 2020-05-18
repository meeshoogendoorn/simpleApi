@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is your profile page. Here you can edit your profile.'),
        'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Server Info') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('server.info.update', $info) }}" autocomplete="off">
                            @csrf
                            @method('put')

                            <h6 class="heading-small text-muted mb-4">{{ __('Server Information') }}</h6>

                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('api_key') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-api_key">{{ __('Api Key Proxy6') }}</label>
                                    <input type="text" name="api_key" id="input-api_key" class="form-control form-control-alternative{{ $errors->has('api_key') ? ' is-invalid' : '' }}" placeholder="{{ __('API KEY') }}" value="{{ old('api_key', $info->api_key) }}" autofocus>

                                    @if ($errors->has('api_key'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('api_key') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('players') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-players">{{ __('Players (calculated on song)') }}</label>
                                    <input type="number" name="players" id="input-players" class="form-control form-control-alternative{{ $errors->has('players') ? ' is-invalid' : '' }}" placeholder="{{ __('Players for 1 song') }}" value="{{ old('players', $info->players) }}" autofocus>

                                    @if ($errors->has('players'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('players') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group{{ $errors->has('max_play_time') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-max_play_time">{{ __('Max playtime (in seconds)') }}</label>
                                    <input type="number" name="max_play_time" id="input-max_play_time" class="form-control form-control-alternative{{ $errors->has('max_play_time') ? ' is-invalid' : '' }}" placeholder="{{ __('Max Playtime by song in seconds') }}" value="{{ old('max_play_time', $info->max_play_time) }}">

                                    @if ($errors->has('max_play_time'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('max_play_time') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                </div>
                            </div>
                        </form>
                        @if(auth()->user()->admin)
                        <hr class="my-3">
                        <form method="post" action="{{ route("servers.owners.set", $info->server_id) }}" autocomplete="off">
                            @csrf
                            @method('put')
                                <div class="form-group">
                                    <label for="select-owner">Select Owners</label>
                                    <select multiple name="select-owner[]" class="form-control" id="select-owner">
                                        @foreach($users as $user)
                                            <option @if($user->hasRight($info->server_id, "server")) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4">{{ __('Change ownership') }}</button>
                                </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
