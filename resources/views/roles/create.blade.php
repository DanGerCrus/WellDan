<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Создать роль</h2>
            </div>
            <div class="float-right">
                <x-a href="{{ route('roles.index') }}"> Назад</x-a>
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

<form action="{{route('roles.store')}}" method="POST" class="container mx-auto">
    @csrf
    <div class="my-5 mx-5">
        <div class="flex flex-col">
            <strong>Название:</strong>
            <x-text-input type="text" name="name" placeholder="Имя"></x-text-input>
        </div>
        <div class="my-2">
            <strong>Права доступа:</strong>
            <br/>
            @foreach($permission as $value)
                <x-input-label>
                    <x-checkbox name="permission[]" value="{{$value->id}}"></x-checkbox>
                    {{ $value->name }}
                </x-input-label>
            <br/>
            @endforeach
        </div>
        <div class="mt-2 text-center">
            <x-btn type="submit" class="w-full">Отправить</x-btn>
        </div>
    </div>
</form>
</x-app-layout>
