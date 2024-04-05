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
        <form method="GET" action="{{route('users.index')}}"
              class="rounded-xl shadow bg-gray-100 p-4">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Фильтры</h1>
            <div class="grid grid-cols-3 gap-10">
                <div class="">
                    <x-input-label
                        for="last_name"
                        :value="__('Фамилия')"
                    />
                    <x-text-input
                        id="last_name"
                        name="last_name"
                        type="text"
                        :value="$filter->last_name ?? __('')"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="">
                    <x-input-label
                        for="first_name"
                        :value="__('Имя')"
                    />
                    <x-text-input
                        id="first_name"
                        name="first_name"
                        type="text"
                        :value="$filter->first_name ?? __('')"
                        class="mt-1 block w-full"
                    />
                </div>
                <div class="">
                    <x-input-label
                        for="father_name"
                        :value="__('Отчество')"
                    />
                    <x-text-input
                        id="father_name"
                        name="father_name"
                        type="text"
                        :value="$filter->father_name ?? __('')"
                        class="mt-1 block w-full"
                    />
                </div>
            </div>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">Сортировка</h1>
            <div class="grid grid-cols-5 gap-10">
                <div>
                    <x-input-label
                        for="order_last_name"
                        :value="__('Фамилия')"
                    />
                    <x-select
                        id="order_last_name"
                        name="order_last_name"
                        class="mt-1"
                        :data="$order->default"
                        :selected="$order->first_name ?? 0"
                    />
                </div>
                <div>
                    <x-input-label
                        for="order_first_name"
                        :value="__('Имя')"
                    />
                    <x-select
                        id="order_first_name"
                        name="order_first_name"
                        class="mt-1"
                        :data="$order->default"
                        :selected="$order->last_name ?? 0"
                    />
                </div>
                <div>
                    <x-input-label
                        for="order_father_name"
                        :value="__('Отчество')"
                    />
                    <x-select
                        id="order_father_name"
                        name="order_father_name"
                        class="mt-1"
                        :data="$order->default"
                        :selected="$order->father_name ?? 0"
                    />
                </div>
            </div>
            <div
                class="flex items-center gap-4 mt-4"
            >
                <x-primary-button>
                    {{ __('Применить') }}
                </x-primary-button>
            </div>
        </form>
        <table class="table-auto w-full my-5">
            <tr>
                <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">ФИО пользователя</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Телефон</th>
                <th class="w-1/9 border-2 border-gray-400 px-4 py-2">Возраст</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Почта</th>
                <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Роли</th>
                <th class="w-1/3 border-2 border-gray-400 px-4 py-2">Действия</th>
            </tr>
            @if(!empty($data->items()))
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
            @else
                <tr>
                    <td colspan="3"><x-no-data></x-no-data></td>
                </tr>
            @endif
        </table>
        <x-paginate :paginator="$data"></x-paginate>
    </div>
</x-app-layout>
