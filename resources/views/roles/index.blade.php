<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Управление ролями</h2>
            </div>
            <div class="float-right">
                @can('role-create')
                    <x-a body="success" href="{{ route('roles.create') }}"> Создать роль</x-a>
                @endcan
            </div>
        </div>
    </x-slot>


@if ($message = Session::get('success'))
    <div class="w-full px-10 py-5 bg-green-500" >
        <p>{{ $message }}</p>
    </div>
@endif

<div class="container mx-auto px-4 my-5">
    <table class="table-auto w-full">
        <thead>
        <tr>
            <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">Название</th>
            <th class="w-1/2 border-2 border-gray-400 px-4 py-2">Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($roles as $key => $role)
            <tr>
                <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">{{ $role->name }}</td>
                <td class="border-2 border-gray-400 px-4 py-2">
                    <x-a body="info" href="{{ route('roles.show',$role->id) }}">Посмотреть</x-a>
                    @can('role-edit')
                        <x-a  href="{{ route('roles.edit',$role->id) }}">&#128393;</x-a>
                    @endcan
                    @can('role-delete')
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style = "display:inline">
                            @csrf
                            @method('DELETE')
                            <x-btn body="danger" type="submit">&times;</x-btn>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</x-app-layout>
