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
                        <section id="tabs" class="project-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <nav>
                                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                                @php $active = true; @endphp
                                                @foreach($sources as $sourceCollection)
                                                    <a class="nav-item nav-link @if($active) active @endif" id="{{strtolower(trim($sourceCollection[0]->server->server_name))}}-tab" data-toggle="tab" href="#{{strtolower(trim($sourceCollection[0]->server->server_name))}}" role="tab" aria-controls="{{strtolower(trim($sourceCollection[0]->server->server_name))}}" aria-selected="true">{{ $sourceCollection[0]->server->server_name }}</a>
                                                    @php $active = false @endphp
                                                @endforeach
                                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Project Tab 2</a>
                                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Project Tab 3</a>
                                            </div>
                                        </nav>
                                        <div class="tab-content" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                <table class="table" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <th>Employer</th>
                                                        <th>Awards</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><a href="#">Work 1</a></td>
                                                        <td>Doe</td>
                                                        <td>john@example.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#">Work 2</a></td>
                                                        <td>Moe</td>
                                                        <td>mary@example.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#">Work 3</a></td>
                                                        <td>Dooley</td>
                                                        <td>july@example.com</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                <table class="table" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>Project Name</th>
                                                        <th>Employer</th>
                                                        <th>Time</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><a href="#">Work 1</a></td>
                                                        <td>Doe</td>
                                                        <td>john@example.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#">Work 2</a></td>
                                                        <td>Moe</td>
                                                        <td>mary@example.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#">Work 3</a></td>
                                                        <td>Dooley</td>
                                                        <td>july@example.com</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                                <table class="table" cellspacing="0">
                                                    <thead>
                                                    <tr>
                                                        <th>Contest Name</th>
                                                        <th>Date</th>
                                                        <th>Award Position</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><a href="#">Work 1</a></td>
                                                        <td>Doe</td>
                                                        <td>john@example.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#">Work 2</a></td>
                                                        <td>Moe</td>
                                                        <td>mary@example.com</td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#">Work 3</a></td>
                                                        <td>Dooley</td>
                                                        <td>july@example.com</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    @foreach($sources as $sourceCollection)
                    <div class="table-responsive">
                        {{ $sourceCollection[0]->server->server_name }}
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
                            @foreach($sourceCollection as $source)
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
                        @endforeach
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
