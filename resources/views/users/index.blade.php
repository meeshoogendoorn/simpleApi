@extends('layouts.app', ["title" => __("Servers")])

@section('content')
    @include('users.partials.header', [
       'title' => __('Hello') . ' '. auth()->user()->name,
       'description' => __('This is the users page, Here you can find all the users registered in the system'),
       'class' => 'col-lg-7'
   ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Users</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route("users.create")}}" class="btn btn-sm btn-primary">Create User</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                    </div>

                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">admin</th>
                                <th scope="col">Created at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th>
                                        {{$user->name}}
                                    </th>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td><i class="ni ni-check-bold @if($user->admin) text-success @else text-danger @endif"></i></td>
                                    @php
                                        \Carbon\Carbon::setLocale("nl");
                                        setlocale(LC_TIME, "nl");
                                        $date = \Carbon\Carbon::parse($user->created_at)->timezone("Europe/Amsterdam")->format("D, d M Y - H:i")
                                    @endphp
                                    <td>{{ $date }}</td>
                                    <td>
                                        <form method="POST" action="{{route("users.destroy", $user->id)}}">
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
                    <div class="card-footer py-4">
                        <nav class="d-flex justify-content-end" aria-label="...">

                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
