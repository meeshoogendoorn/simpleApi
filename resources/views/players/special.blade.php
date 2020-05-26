@extends('layouts.app', ["title" => __("Add song")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('On this page you can add new players to the system with the bulk function'),
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
                        </div>
                    </div>
                    <div class="container">
                        <p>Use the convention of email;password and for every combination a newline, Email will be set as username</p>
                        <form action="{{route("players.store")}}" method="POST" autocomplete="off">
                            @method("post")
                            @csrf
                            <input type="hidden" value="1" name="bulk" />
                            <div class="form-group{{ $errors->has('players') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-value">{{ __('Players list') }} *</label>
                                <div class="autocomplete">
                                    <textarea row="40" cols="25" name="players" id="input-players" class="form-control form-control-alternative{{ $errors->has('players') ? ' is-invalid' : '' }}"></textarea>
                                </div>
                                @if ($errors->has('players'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('players') }}</strong>
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
