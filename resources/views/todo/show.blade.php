<x-layout :todo="$todo">
    <x-slot name="title">TODO: detail</x-slot>
    @if (session('status'))
        <div class="p-4 mb-4 text-sm text-indigo-800 rounded-lg bg-indigo-50" role="alert">
            <span class="font-medium">{{ session('status') }}</span>
        </div>
    @endif
    <div class="space-y-4">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

            <div class="mt-sm-10 sm:mx-auto sm:w-full sm:max-w-xl">

                <div class="mt-2">
                    <div class="text-indigo-600">Name</div>
                    <div class="bg-gray-50 border border-gray-100 rounded-lg px-4 py-2">{{ $todo->name }}</div>
                </div>
                <div class="mt-2">
                    <div class="text-indigo-600">Description</div>
                    <div class="bg-gray-50 border border-gray-100 rounded-lg rounded px-4 py-2">{!! nl2br(e($todo['description'])) !!}</div>
                </div>
                <div class="mt-2">
                    <div class="text-indigo-600">Category</div>
                    <div class="bg-gray-50 border border-gray-100 rounded-lg rounded px-4 py-2">{{ $todo->category->name }}</div>
                </div>
                <div class="mt-2">
                    <div class="text-indigo-600">Visibility</div>
                    <div class="bg-gray-50 border border-gray-100 rounded-lg rounded px-4 py-2">{{ $todo->shared ? 'Shared' : 'Not shared' }}</div>
                </div>
                <div class="mt-2">
                    <div class=" text-indigo-600">Status</div>
                    <div class="bg-gray-50 border border-gray-100 rounded-lg rounded px-4 py-2">{{ $todo->completed ? 'Done' : 'Open' }}</div>
                </div>

            </div>
        </div>
    </div>
</x-layout>




