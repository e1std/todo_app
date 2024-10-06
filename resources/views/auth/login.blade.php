<x-layout>
    <x-slot name="title">Log in</x-slot>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

        <div class="mt-sm-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <form class="space-y-6" method="POST" action="/login">
                @csrf

                <x-form-field>
                    <x-form-label for="email">Email</x-form-label>

                    <div class="mt-2">
                        <x-form-input name="email" id="email" type="email" required/>

                        <x-form-error name="email"/>
                    </div>
                </x-form-field>

                <x-form-field>
                    <x-form-label for="password">Password</x-form-label>

                    <div class="mt-2">
                        <x-form-input name="password" id="password" type="password" required/>

                        <x-form-error name="password"/>
                    </div>
                </x-form-field>

                <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Log in
                </button>

                <div class="mt-4 text-center">
                <a href="/register"
                   class="inline-block ml-auto text-sm font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Don't have an
                    account?</a>
                </div>
            </form>

        </div>
    </div>

</x-layout>


