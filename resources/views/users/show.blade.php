<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Просмотр пользователя</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('users.index') }}">Назад</x-a>
            </div>
        </div>
    </x-slot>

    <div class="my-5 mx-5">
        <div class="flex flex-col">
            <strong>ФИО пользователя:</strong>
            {{ $user->last_name . ' ' . $user->first_name . ' ' . $user->father_name}}
        </div>
        <div class="flex flex-col">
            <strong>Телефон:</strong>
            {{ $user->phone }}
        </div>
        <div class="flex flex-col">
            <strong>Возраст:</strong>
            {{ $user->age }}
        </div>
        <div class="flex flex-col">
            <strong>Почта:</strong>
            {{ $user->email }}
        </div>
        <div class="my-3">
            <strong>Роли:</strong>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <label class="rounded px-1 bg-green-500 mr-0.5">{{ $v }}</label>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
