@extends('layouts.app')

@section('content')
    <div>
        <form method="POST" action="/users/create">
            @csrf
            <input type="text" name="email">
            <label for="">email</label>
            <input type="text" name="password">
            <label for="">password</label>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
@endsection
