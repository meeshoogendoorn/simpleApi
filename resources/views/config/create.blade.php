@extends('layouts.app', ["title" => __("Add song")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('On this page you can add new config item to the system'),
       'class' => 'col-lg-7'
   ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Settings</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route("config.index")}}" class="btn btn-sm btn-primary">List Settings</a>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <form action="{{route("config.store")}}" method="POST" autocomplete="off">
                            @method("post")
                            @csrf
                            <div class="form-group{{ $errors->has('key') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-key">{{ __('Key') }} *</label>
                                <div class="autocomplete">
                                    <input type="text" name="key" id="input-key" class="form-control form-control-alternative{{ $errors->has('key') ? ' is-invalid' : '' }}" placeholder="{{ __('Fill in a key') }}">
                                </div>
                                @if ($errors->has('key'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('key') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('value') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-value">{{ __('Value (Separate multiple values with a comma)') }} *</label>
                                <div class="autocomplete">
                                    <input type="text" name="value" id="input-value" class="form-control form-control-alternative{{ $errors->has('value') ? ' is-invalid' : '' }}" placeholder="{{ __('Fill in a value') }}">
                                </div>
                                @if ($errors->has('value'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('value') }}</strong>
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
