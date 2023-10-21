<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Редактировать пользователя</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('users.index') }}"> Назад</x-a>
            </div>
        </div>
    </x-slot>


    @if (count($errors) > 0)
        <div class="w-full px-10 py-5 bg-red-700">
            <strong>Whoops!</strong> Возникли проблемы с вашими данными.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                <div>
                    <x-input-label for="last_name" :value="__('Фамилия')" />
                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autofocus autocomplete="last_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <div>
                    <x-input-label for="first_name" :value="__('Имя')" />
                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <div>
                    <x-input-label for="father_name" :value="__('Отчество')" />
                    <x-text-input id="father_name" name="father_name" type="text" class="mt-1 block w-full" :value="old('father_name', $user->father_name)" required autofocus autocomplete="father_name" />
                    <x-input-error class="mt-2" :messages="$errors->get('father_name')" />
                </div>

                <div>
                    <x-input-label for="phone" :value="__('Номер телефона')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" min="1" required autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <div>
                    <x-input-label for="age" :value="__('Возраст')" />
                    <x-text-input id="age" name="age" type="number" class="mt-1 block w-full" :value="old('age', $user->age)" min="1" required autocomplete="age" />
                    <x-input-error class="mt-2" :messages="$errors->get('age')" />
                </div>
                <div>
                    <x-input-label for="password" :value="__('Новый пароль')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Подтвердите пароль')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>
                <!-- Roles -->
                <div class="mt-4">
                    <x-label
                        for="roles"
                        :value="__('Роли:')"
                    />
                    <x-select
                        class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                        name="roles[]"
                    >
                        <x-slot name="options">
                            @foreach($roles as $key => $role)
                                <option value="{{$key}}" @if(isset($userRole[$key]) && $key === $userRole[$key]) selected="selected" @endif multiple="multiple"> {{ $role }} </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                </div>
                <div class="flex items-center justify-center mt-4">
                    <x-btn type="submit">
                        {{ __('Отправить') }}
                    </x-btn>
                </div>
            </div>
        </div>

    </form>
</x-app-layout>
<script src="{{asset('js/imask.js')}}"></script>
<script>
    IMask(
        document.getElementById('phone'),
        {
            mask: '+{7}(000)000-00-00'
        }
    )
</script>
