@extends('layouts.app', ["title" => __("Sources")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('This is the sources page. Here you can view and delete sources connected to the servers.'),
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
                                <a href="{{route("sources.create")}}" class="btn btn-sm btn-primary">Create Source</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Server Name</th>
                                <th scope="col">Song Title</th>
                                <th scope="col">Streams</th>
                                <th scope="col">Active</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <td>{{$source->server->server_name}}</td>
                                    <td>@if($source->song->permission || auth()->user()->admin && \Illuminate\Support\Facades\Session::get("admin")){{$source->song->title}}@else <b class="text-danger">No permission</b> @endif</td>
                                    <td>@if($source->song->permission || auth()->user()->admin && \Illuminate\Support\Facades\Session::get("admin")){{$source->song->streams}}@else <b class="text-danger">NA</b> @endif</td>
                                    <td>
                                        @php
                                            $lastStreamBoundaryDate = \Carbon\Carbon::now()->subMinutes(6);
                                            $lastStreamDate = new \Carbon\Carbon($source->song->updated_at);
                                        @endphp
                                        @if($lastStreamBoundaryDate->greaterThan($lastStreamDate))
                                            <i class="fas fa-arrow-down text-danger mr-3"></i>
                                            <hr class="my-3">
                                            <p class="small text-danger">Probably down, Connect Server Admin To Check</p>
                                        @else
                                            <i class="fas fa-arrow-up text-success mr-3"></i>

                                        @endif
                                    </td>
                                    <td>
                                        @if($source->song->permission || auth()->user()->admin && \Illuminate\Support\Facades\Session::get("admin"))
                                        <form method="POST" action="{{route("sources.destroy", $source->id)}}">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-outline-danger">DELETE</button>
                                        </form>
                                        @endif
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
