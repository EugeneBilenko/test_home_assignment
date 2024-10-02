@extends('layouts.app')

@section('content')
    <div>
        <form method="POST" action="/records/create" enctype="multipart/form-data">
            @csrf
            <input type="text" name="name">
            <label for="">name</label>
            <input type="file" name="image" accept=".png, .jpeg, .jpg, .gif">
            <label for="">image</label>
            <select name="category">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                @endforeach
            </select>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
@endsection

