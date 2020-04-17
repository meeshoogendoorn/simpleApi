@extends('layouts.app', ["title" => __("Sources")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('This is the songs page. Here you can view and delete songs saved in our servers.'),
       'class' => 'col-lg-7'
   ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Songs</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route("songs.create")}}" class="btn btn-sm btn-primary">Create Song</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Song Length (in seconds)</th>
                                <th scope="col">Streams</th>
                                <th scope="col">Progress</th>
                                <th scope="col">Spotify</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $colorChoices = ["primary", "success", "danger", "info", "warning"]
                            @endphp
                            @foreach($songs as $song)
                                <tr>
                                    <td>{{$song->title}}</td>
                                    <td>{{$song->length}}</td>
                                    <td>{{ $song->streams }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $streamPercentage = ceil((100 / 100000) * (int)$song->streams);
                                                $randomColorIndex = array_rand($colorChoices);
                                            @endphp
                                            <span class="mr-2">{{$streamPercentage}}%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gradient-{{$colorChoices[$randomColorIndex]}}" role="progressbar" aria-valuenow="{{ $streamPercentage }}" aria-valuemin="0" aria-valuemax="100" style="width: {{$streamPercentage}}%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><a target="_blank" href="{{$song->uri}}" class="btn btn-outline-success">OPEN</a></td>
                                    <td>
                                        <div class="row">
                                            @if(auth()->user()->admin)
                                            <a class="btn btn-outline-primary" href="{{ route("songs.edit", $song->id) }}">CHANGE OWNERSHIP</a>
                                            @endif
                                            <form method="POST" action="{{route("songs.destroy", $song->id)}}">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-outline-danger">DELETE</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
