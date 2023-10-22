<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Fio -->
        <div  class="mt-4">
            <x-input-label for="last_name" :value="__('Фамилия')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div  class="mt-4">
            <x-input-label for="first_name" :value="__('Имя')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div  class="mt-4">
            <x-input-label for="father_name" :value="__('Отчество')" />
            <x-text-input id="father_name" name="father_name" type="text" class="mt-1 block w-full" required autofocus autocomplete="father_name" />
            <x-input-error class="mt-2" :messages="$errors->get('father_name')" />
        </div>

        <div  class="mt-4">
            <x-input-label for="phone" :value="__('Номер телефона')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" min="1" required autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div  class="mt-4">
            <x-input-label for="age" :value="__('Возраст')" />
            <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" min="1" required autocomplete="age" />
            <x-input-error class="mt-2" :messages="$errors->get('age')" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Адрес электронной почты')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтвердите Пароль')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Уже зарегистрированы?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Зарегистрировать') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
<script src="{{asset('js/imask.js')}}"></script>
<script>
    IMask(
        document.getElementById('phone'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>
