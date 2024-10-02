@extends('layouts.app')

@section('content')
    <div>
        <a href="/users/create">{{  __('Create') }}</a>
        @foreach($users as $user)
            <div>
                <span>{{ $user->email }}</span>
                <span>
                    <a href="/users/delete/{{ $user->id }}">
                        {{  __('Delete') }}
                    </a>
                </span>
            </div>
        @endforeach
    </div>
@endsection
