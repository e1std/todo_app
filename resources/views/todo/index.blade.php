<x-layout :hasDeletedRecords="$hasDeletedRecords">
    <x-slot name="title">TODO's</x-slot>
    @if (session('status'))
        <div class="p-4 mb-4 text-sm text-indigo-800 rounded-lg bg-indigo-50" role="alert">
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif
    <form method="GET" action="/" class="mb-4 flex flex-col items-center space-y-4">
        <div class="flex flex-col gap-y-4 sm:flex-row sm:gap-x-12 justify-center">
            <div class="inline-block">
                By Category:
                <select name="category_id" onchange="this.form.submit()" class="block w-full max-w-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="inline-block">
                By Status:
                <select name="status" onchange="this.form.submit()" class="block w-full max-w-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="" {{ request('status') == "" ? 'selected' : '' }}>
                        All
                    </option>
                    <option value="closed" {{ request('status') == "closed" ? 'selected' : '' }}>
                        Closed
                    </option>
                    <option value="open" {{ request('status') == "open" ? 'selected' : '' }}>
                        Open
                    </option>
                </select>
            </div>
            <div class="inline-block">
                By Ownership:
                <select name="ownership" onchange="this.form.submit()" class="block w-full max-w-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">
                        All
                    </option>
                    <option value="my" {{ request('ownership') == "my" ? 'selected' : '' }}>
                        My Todos
                    </option>
                    <option value="shared" {{ request('ownership') == "shared" ? 'selected' : '' }}>
                        Shared With Me
                    </option>
                </select>
            </div>
        </div>
    </form>

    <div class="space-y-4">
        @if ($todos->isEmpty())
            <p>No records found.</p>
        @else
            @foreach ($todos as $todo)
                <a href="/todos/{{ $todo['id'] }}" class="relative block px-4 py-6 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-md bg-gradient-to-r from-transparent {{ $todo['completed'] ? 'to-indigo-100' : 'to-gray-100' }}">

                    <div class="absolute top-0 right-0">
                        <span class="inline-block bg-indigo-600 text-white text-xs font-bold px-2.5 py-0.5 rounded-l-lg border-0">{{ $todo->category->name }}</span>

                    </div>
                    <div class="flex gap-x-2 sm:gap-x-12 justify-between items-center">
                        <div>
                            <div class="font-bold text-blue-500 text-sm">
                                @if ($todo['shared'])
                                    @if ($todo['user_id'] == auth()->id())
                                        <span class="inline-block mb-2 bg-white text-indigo-600 text-xs font-bold me-2 px-2.5 py-0.5 rounded border-2 border-indigo-600">SHARED by YOU</span>
                                    @else
                                        <span class="inline-block mb-2 bg-white text-gray-600 text-xs font-bold me-2 px-2.5 py-0.5 rounded border-2 border-gray-600">SHARED with YOU</span>
                                    @endif
                                @endif
                            </div>
                            <h3 class="text-xl font-bold">{{ $todo['name'] }}</h3>
                            <p>{!! nl2br(e($todo['description'])) !!}</p>
                        </div>
                        <div>
                            @if ($todo['completed'])
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-indigo-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10 text-gray-600">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach


            <div>
                {{ $todos->links() }}
            </div>
        @endif
    </div>
</x-layout>


