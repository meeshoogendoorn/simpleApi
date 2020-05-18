@extends('layouts.app', ['title' => __('User Profile')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is the settings page, Here you can change the config values for your script'),
        'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Settings</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route("settings.create")}}" class="btn btn-sm btn-primary">New Setting</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <table class="table table-striped col-12">
                           <thead>
                               <tr>
                                   <th>Key</th>
                                   <th>Value</th>
                                   <th>Edit</th>
                               </tr>
                           </thead>
                           <tbody>
                           @foreach($config as $item)
                                <tr>
                                    <td><strong>{{$item->key}}</strong></td>
                                    <td>{{$item->value}}</td>
                                    <td><a href="{{ route("settings.edit", $item->id) }}"><i class="ni ni-settings-gear-65"></i></a></td>
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
