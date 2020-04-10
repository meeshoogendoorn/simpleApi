@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route("songs.create") }}" class="btn btn-outline-primary">Create Song</a>
                        <a href="{{ route("sources.create") }}" class="btn btn-outline-primary">Create Source</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-responsive">
                            <thead>
                                <th>Server name</th>
                                <th></th>
                                <th>Song title</th>
                                <th></th>
                            </thead>
                            <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td>{{$source->server->server_name}}</td>
                                    <td>------></td>
                                    <td>{{$source->song->title}}</td>
                                    <td>
                                        <form method="POST" action="{{route("sources.destroy", $source->song->id)}}">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-outline-danger">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
