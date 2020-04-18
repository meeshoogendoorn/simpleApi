@extends('layouts.app')

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--7">
        <div class="row mt-5">
            <div class="col-xl-8 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Playing now</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route("sources.index") }}" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Server name</th>
                                    <th scope="col">Song name</th>
                                    <th scope="col">Streams</th>
                                    <th scope="col">Active</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($sources as $source)
                                <tr>
                                    <th scope="row">
                                        {{ $source->server->server_name }}
                                    </th>
                                    <td>
                                        @if($source->song->permission || auth()->user()->admin){{ $source->song->title }}@else <b class="text-danger">No permission</b> @endif
                                    </td>
                                    <td>
                                        @if($source->song->permission || auth()->user()->admin){{$source->song->streams}}@else <b class="text-danger">NA</b> @endif
                                    </td>
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
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Songs</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route("songs.index") }}" class="btn btn-sm btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Streams</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $colorChoices = ["primary", "success", "danger", "info", "warning"]
                                @endphp
                                @foreach($songs as $song)
                                    <tr>
                                        <th scope="row">
                                            {{ $song->title }}
                                        </th>
                                        <td>
                                            {{ $song->streams }}
                                        </td>
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

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
