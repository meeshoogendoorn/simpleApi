@extends('layouts.app', ["title" => __("Add song")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('On this page you can add new players to the system'),
       'class' => 'col-lg-7'
   ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Players (Current amount: <span class="text-green">{{ $count }}</span>)</h3>
                            </div>
                            <div>
                                <a href="{{route("players.create.bulk")}}" class="btn btn-outline-primary btn-sm">Create players bulk</a>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <form action="{{route("players.store")}}" method="POST" autocomplete="off">
                            @method("post")
                            @csrf
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-email">{{ __('Email') }} *</label>
                                <div class="autocomplete">
                                    <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email of player') }}">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('uname') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-value">{{ __('Username') }} *</label>
                                <div class="autocomplete">
                                    <input type="text" name="uname" id="input-uname" class="form-control form-control-alternative{{ $errors->has('uname') ? ' is-invalid' : '' }}" placeholder="{{ __('Username of player') }}">
                                </div>
                                @if ($errors->has('uname'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('uname') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('passw') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-value">{{ __('Password') }} *</label>
                                <div class="autocomplete">
                                    <input type="text" name="passw" id="input-passw" class="form-control form-control-alternative{{ $errors->has('passw') ? ' is-invalid' : '' }}" placeholder="{{ __('Password of player') }}">
                                </div>
                                @if ($errors->has('passw'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('passw') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
