@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form action="{{route("sources.store")}}" method="POST">
                            @method("post")
                            @csrf
                            <div class="form-group{{ $errors->has('server_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-server_id">{{ __('Server') }} *</label>
                                <select required class="form-control" id="input0-server_id" name="server_id">
                                    <option value="">-- Choose a server --</option>
                                    @foreach($servers as $server)
                                        <option value="{{$server->id}}">{{$server->server_name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('server_id'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('server_id') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('song_id') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-song_id">{{ __('Song') }} *</label>
                                <select required class="form-control" id="input-song_id" name="song_id">
                                    <option value="">-- Choose a song --</option>
                                    @foreach($songs as $song)
                                        <option value="{{$song->id}}">{{$song->title}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('song_id'))
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('song_id') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button class="btn btn-outline-primary" type="submit">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
