@extends('layouts.app', ['title' => __('Song Ownership')])

@section('content')
    @include('users.partials.header', [
        'title' => __('Hello') . ' '. auth()->user()->name,
        'description' => __('This is the edit page for songs, here you can change the ownership for a song'),
        'class' => 'col-lg-7'
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Editing ') . $song->title }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route("songs.owners.set", $song->id) }}" autocomplete="off">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="select-owner">Select Owners</label>
                                <select multiple name="select-owner[]" class="form-control" id="select-owner">
                                    @foreach($users as $user)
                                        <option @if($user->hasRight($song->id, "song")) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Change ownership') }}</button>
                            </div>
                        </form>
                        <hr class="my-4">
                        <form method="post" action="{{ route("songs.streams.set", $song->id) }}" autocomplete="off">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="select-owner">Streams</label>
                               <input class="form-control" type="number" value="{{ $song->streams }}" name="streams" required />
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{ __('Set streams') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
