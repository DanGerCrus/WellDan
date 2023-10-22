<x-app-layout>

    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight ">Управление пользователями</h2>
            </div>
            <div class="float-right">
                @can('role-create')
                    <x-a
                        body="success"
                        href="{{ route('users.create') }}"
                    >Зарегистрировать пользователя
                    </x-a>
                @endcan
            </div>
        </div>
    </x-slot>


    @if ($message = Session::get('success'))
        <div class="w-full px-10 py-5 bg-green-500">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="container mx-auto px-4 my-5">
        <table class="table-auto w-full">
            <tr>
                <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">ФИО пользователя</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Телефон</th>
                <th class="w-1/9 border-2 border-gray-400 px-4 py-2">Возраст</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Почта</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Роли</th>
                <th class="w-1/3 border-2 border-gray-400 px-4 py-2">Действия</th>
            </tr>
            @foreach ($data as $key => $user)
                <tr>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $user->last_name . ' ' . $user->first_name . ' ' . $user->father_name}}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $user->phone }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $user->age }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">{{ $user->email }}</td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        @if(!empty($user->getRoleNames()))
                            @foreach($user->getRoleNames() as $v)
                                <label class="rounded px-1 bg-green-500 mr-0.5">{{ $v }}</label>
                            @endforeach
                        @endif
                    </td>
                    <td class="border-2 border-gray-400 px-4 py-2">
                        <x-a
                            body="info"
                            href="{{ route('users.show',$user->id) }}"
                        >Посмотреть
                        </x-a>
                        <x-a href="{{ route('users.edit',$user->id) }}">&#128393;</x-a>
                        <form
                            action="{{ route('users.destroy', $user->id) }}"
                            method="POST"
                            style="display:inline"
                        >
                            @csrf
                            @method('DELETE')
                            <x-btn
                                body="danger"
                                type="submit"
                            >&times;
                            </x-btn>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</x-app-layout>
