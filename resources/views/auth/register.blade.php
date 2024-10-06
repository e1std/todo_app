<x-layout>
    <x-slot name="title">Register</x-slot>

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">

        <div class="mt-sm-10 sm:mx-auto sm:w-full sm:max-w-sm">

            <form class="space-y-6" method="POST" action="/register">
                @csrf

                <x-form-field>
                    <x-form-label for="last_name">Name</x-form-label>

                    <div class="mt-2">
                        <x-form-input name="name" id="name" required/>

                        <x-form-error name="name"/>
                    </div>
                </x-form-field>

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

                <x-form-field>
                    <x-form-label for="password_confirmation">Confirm Password</x-form-label>

                    <div class="mt-2">
                        <x-form-input name="password_confirmation" id="password_confirmation" type="password" required/>

                        <x-form-error name="password_confirmation"/>
                    </div>
                </x-form-field>

                <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Sign in
                </button>

                <div class="mt-4 text-center">
                <a href="/login"
                   class="inline-block ml-auto text-sm font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Already have an
                    account?</a>
                </div>
            </form>

        </div>
    </div>

</x-layout>


