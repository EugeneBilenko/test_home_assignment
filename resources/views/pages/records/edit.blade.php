@extends('layouts.app')

@section('content')
    <div>
        <form method="POST" action="/records/update/{{ $record->id }}">
            @csrf
            <input type="text" name="name" value="{{ $record->name }}">
            <label for="">name</label>
            <span>
                <img src="{{ asset('storage/' . $record->image) }}" alt="{{ $record->category }}">
            </span>
            <select name="category">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == $record->category) selected @endif>{{ $category->category }}</option>
                @endforeach
            </select>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
@endsection

