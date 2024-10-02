@extends('layouts.app')

@section('content')
    <div>
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
                    <a href="/records/edit/{{ $record->id }}">
                        {{  __('Edit') }}
                    </a>
                </span>
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
