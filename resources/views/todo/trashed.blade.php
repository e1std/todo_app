<x-layout>
    <x-slot name="title">Deleted TODO's</x-slot>

    <div class="space-y-4">
        @if ($todos->isEmpty())
            <p>No records found.</p>
        @else
            <ul>
            @foreach ($todos as $todo)
                    <li><strong>{{ $todo["name"] }}</strong> deleted at <strong>{{ $todo['deleted_at'] }}</strong>: <x-button href="/todos/{{ $todo['id'] }}/restore">RESTORE</x-button></li>
            @endforeach
            </ul>

            <div>
                {{ $todos->links() }}
            </div>
        @endif
    </div>
</x-layout>


