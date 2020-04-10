@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route("songs.create") }}" class="btn btn-outline-primary">Create song</a>
                    <a href="{{ route("sources.index") }}" class="btn btn-outline-primary">Sources</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table">
                        <thead>
                            <th class="col">Server name</th>
                        </thead>
                        <tbody>
                        @foreach($servers as $server)
                            <tr>
                                <td>{{$server->server_name}}</td>
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
