@extends('layouts.app', ["title" => __("Create Source")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('On this page you can link a song to a server. Create your new source down below.'),
       'class' => 'col-lg-7'
   ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Sources</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route("sources.index")}}" class="btn btn-sm btn-primary">List Sources</a>
                            </div>
                        </div>
                    </div>
                    <div class="container">
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
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
