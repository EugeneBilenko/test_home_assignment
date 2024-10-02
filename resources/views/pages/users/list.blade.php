@extends('layouts.app')

@section('content')
    <div>
        <a href="/users/create">{{  __('Create') }}</a>
        @foreach($users as $user)
            <div id="user_row_{{ $user->id }}">
                <span>{{ $user->email }}</span>
                <span>
                    <a href="javascript:deleteEmployee('{{ $user->id }}');" role="button">
                        {{  __('Delete') }}
                    </a>
                </span>
            </div>
        @endforeach
    </div>
    <div>
        {{ $users->links() }}
    </div>
@endsection

@section('js')
    <script>
        function deleteEmployee(id) {
            fetch("/users/delete/" + id, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        const row = document.getElementById('user_row_' + id);
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
