@props(['hasDeletedRecords', 'todo' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TODO APP</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

</head>
<body class="h-full">

<div class="min-h-full">
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 text-indigo-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                        </svg>
                    </div>
                    <div class="ml-2 text-indigo-500 hidden md:block">
                        TODO APP
                    </div>
                    <div class="">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            @auth
                            <x-nav-link href="/" :active="request()->is('/')" type="a_href">TODO's</x-nav-link>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="">
                        <div class="ml-auto flex items-baseline space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            @guest
                                <x-nav-link href="/login" :active="request()->is('login')" type="a_href">Login</x-nav-link>
                                <x-nav-link href="/register" :active="request()->is('register')" type="a_href">Register</x-nav-link>
                            @endguest

                            @auth
                                <form method="POST" action="/logout">
                                    @csrf

                                    <x-form-button>Log Out</x-form-button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div class="hidden" id="mobile-menu">
            <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                <x-nav-link href="/" :active="request()->is('/')" type="a_href">TODO's</x-nav-link>
                @guest
                    <x-nav-link href="/login" :active="request()->is('/login')" type="a_href">Login</x-nav-link>
                    <x-nav-link href="/register" :active="request()->is('/register')" type="a_href">Register</x-nav-link>
                @endguest

                @auth
                    <form method="POST" action="/logout">
                        @csrf

                        <x-form-button>Log Out</x-form-button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $title }}</h1>

            <div class="text-right">
                @auth
                    @switch(request()->path())
                        @case('todos/create')
                            <x-button href="/">Back</x-button>
                            @break
                        @case(preg_match('/^todos\/\d+$/', request()->path()) ? request()->path() : '')
                            <x-button href="/">Back</x-button>
                            @if (auth()->id() == $todo->user_id)
                                <form action="{{ route('todos.delete', request()->segment(2)) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this todo?');" class="relative inline-flex items-center px-4 py-2">
                                    @csrf
                                    @method('DELETE')
                                    <x-form-button class="bg-red-600 hover:bg-red-900">Delete</x-form-button>
                                </form>
                                <x-button href="/todos/{{ request()->segment(2) }}/edit">Edit</x-button>
                            @else
                                <x-button href="/todos/{{ request()->segment(2) }}/done">Mark as complete</x-button>
                            @endif
                            @break
                        @case(preg_match('/^todos\/\d+\/edit$/', request()->path()) ? request()->path() : '')
                            <x-button href="/todos/{{ request()->segment(2) }}">Back</x-button>
                            @break
                        @default
                            @if (isset($hasDeletedRecords) && $hasDeletedRecords)
                                <x-button href="/todos/trashed">Restore deleted TODO(s)</x-button>
                            @endif
                            <x-button href="/todos/create">Create TODO</x-button>
                    @endswitch
                @endauth
            </div>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>
</div>


</body>
</html>

