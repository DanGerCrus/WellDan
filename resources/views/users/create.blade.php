<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Зарегистрировать пользователя</h2>
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

<form action="{{route('users.store')}}" method="POST">
    @csrf
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Name -->
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
                <x-label for="email" :value="__('Почта:')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required placeholder="Почта"/>
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Пароль:')" />
                <x-input id="password" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="new-password" placeholder="Пароль"/>
            </div>
            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Подтверждение пароля:')" />
                <x-input id="password_confirmation" class="block mt-1 w-full"
                         type="password"
                         name="password_confirmation" required placeholder="Подтверждение пароля"/>
            </div>
            <!-- Roles -->
            <div class="mt-4">
                <x-label for="roles" :value="__('Роли:')" />
                <x-select
                    class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full"
                    name="roles[]"
                    multiple="multiple"
                >
                    <x-slot name="options">
                        @foreach($roles as $key => $role)
                            <option value="{{$key}}"> {{ $role }} </option>
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
