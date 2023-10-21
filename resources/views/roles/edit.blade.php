<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="text-xl">Изменить роль</h2>
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

    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="container mx-auto">
        @csrf
        @method('PATCH')
        <div class="my-5 mx-5">
            <div class="flex flex-col">
                <strong>Название:</strong>
                <x-text-input name="name" type="text" placeholder="Имя" value="{{$role->name}}" class="form-input rounded border-gray-300" />
            </div>
            <div class="my-2 flex flex-col">
                <strong>Права доступа:</strong>
                @foreach($permission as $value)
                    <x-input-label>
                        <x-checkbox name="permission[]" value="{{$value->id}}" :checked="in_array($value->id, $rolePermissions)"></x-checkbox>
                        {{ $value->name }}
                    </x-input-label>
                @endforeach
            </div>
            <div class="mt-2 text-center">
                <x-btn type="submit">Отправить</x-btn>
            </div>
        </div>
    </form>
</x-app-layout>
