@extends('layouts.app', ["title" => __("Servers")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('This is the servers page, Here you can find all the servers connected tot he system'),
       'class' => 'col-lg-7'
   ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Servers</h3>
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
                                <th class="server_key" style="display: none;">Server key</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($servers as $server)
                                <tr>
                                    <td>
                                       {{$server->server_name}}
                                    </td>
                                    <td style="display: none;" class="server_key">
                                        {{ $server->key }}
                                    </td>
                                    <td>
                                        <div class="row">
                                        <a id="showKeyButton" class="btn btn-outline-dark">SHOW KEY</a>
                                         <a class="btn btn-outline-danger" href="{{ route("server.restart", $server->id) }}">RESTART</a>
                                         <a class="btn btn-outline-primary" href="{{ route("server.info.edit", $server->id) }}">CONFIGURE</a>
                                        <form method="POST" action="{{route("servers.destroy", $server->id)}}">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-outline-warning">DELETE</button>
                                        </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @push("js")
                                <script>
                                    $("#showKeyButton").on("click", function (e) {
                                        e.preventDefault();
                                        $(".server_key").toggle();
                                    })
                                </script>
                            @endpush
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
