@extends('layouts.app')

@section('content')
    <div>
        @if (Auth::user()->role->role != 'manager')
            <a href="/records/create">{{  __('Create') }}</a>
        @endif
        @foreach($records as $record)
            <div id="record_row_{{ $record->id }}">
                <span>{{ $record->name }}</span>
                <span>
                    <img src="{{ asset('storage/' . $record->image) }}" alt="{{ $record->category }}">
                </span>
                <span>{{ $record->recordCategory->category }}</span>
                <span>
                    <a href="javascript:deleteRecord('{{ $record->id }}')">
                        {{  __('Delete') }}
                    </a>
                </span>
                <span>
                    <a href="/records/edit/{{ $record->id }}">
                        {{  __('Edit') }}
                    </a>
                </span>
                @if (Auth::user()->role->role == 'manager')
                <span>
                    <a href="/records/list/{{ $record->user_id }}">
                        {{  __('Employee records') }}
                    </a>
                </span>
                @endif
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        function deleteRecord(id) {
            fetch('/records/delete/' + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        const row = document.getElementById('record_row_' + id);
                        row.remove();
                        console.log('Success:', data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
