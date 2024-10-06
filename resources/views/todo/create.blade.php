<x-layout>
    <x-slot name="title">Create new TODO</x-slot>

    <div class="space-y-4">
        <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

            <div class="mt-sm-10 sm:mx-auto sm:w-full sm:max-w-sm">

                <form class="space-y-6" method="POST" action="/todos">
                    @csrf

                    <x-form-field>
                        <x-form-label for="last_name">Name</x-form-label>

                        <div class="mt-2">
                            <x-form-input name="name" id="name" required/>

                            <x-form-error name="name"/>
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="category_id">Category</x-form-label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">

                            <select name="category_id" id="category_id" class="block w-full flex-1 border-0 bg-transparent py-1.5 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            </div>
                            <x-form-error name="category_id"/>
                        </div>
                    </x-form-field>

                    <x-form-field>

                        <div class="mt-2">
                            <label class="inline-flex items-center me-5 cursor-pointer">
                                <input type="checkbox" name="shared" value="1" class="sr-only peer">
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-indigo-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-900">Shared</span>
                            </label>
                        </div>
                    </x-form-field>

                    <x-form-field>
                        <x-form-label for="description">Description</x-form-label>

                        <div class="mt-2">
                            <x-form-textarea name="description" id="description" rows="8" required/>

                            <x-form-error name="description"/>
                        </div>
                    </x-form-field>



                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Save
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-layout>



