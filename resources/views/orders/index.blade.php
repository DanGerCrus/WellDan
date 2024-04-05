<x-app-layout>
    <x-slot name="header">
        @include('orders.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="container mx-auto px-4 my-5">
            <form method="GET" action="{{route('orders.index')}}"
                  class="rounded-xl shadow bg-gray-100 p-4">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Фильтры</h1>
                <div class="grid grid-cols-3 gap-10">
                    <div class="">
                        <x-input-label
                            for="creator_id"
                            :value="__('Составил')"
                        />
                        <x-select
                            id="creator_id"
                            name="creator_id"
                            class="mt-1 block w-full"
                            :data="$users_select"
                            :selected="$filter->creator_id ?? 0"
                        />
                    </div>
                    <div class="">
                        <x-input-label
                            for="client_id"
                            :value="__('Клиент')"
                        />
                        <x-select
                            id="client_id"
                            name="client_id"
                            class="mt-1 block w-full"
                            :data="$users_select"
                            :selected="$filter->client_id ?? 0"
                        />
                    </div>
                    <div class="">
                        <x-input-label
                            for="date_order"
                            :value="__('Дата заказа')"
                        />
                        <div class="flex flex-row justify-between items-center">
                            <x-input-label
                                for="min_date_order"
                                :value="__('от')"
                            />
                            <x-text-input
                                id="min_date_order"
                                name="min_date_order"
                                type="datetime-local"
                                min="1"
                                :value="$filter->min_date_order ?? null"
                                class="mt-1"
                            />
                            <x-input-label
                                for="max_date_order"
                                :value="__('до')"
                            />
                            <x-text-input
                                id="max_date_order"
                                name="max_date_order"
                                type="datetime-local"
                                min="1"
                                :value="$filter->max_date_order ?? null"
                                class="mt-1"
                            />
                        </div>
                    </div>
                </div>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">Сортировка</h1>
                <div class="grid grid-cols-5 gap-10">
                    <div>
                        <x-input-label
                            for="order_creator_id"
                            :value="__('Составил')"
                        />
                        <x-select
                            id="order_creator_id"
                            name="order_creator_id"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->creator_id ?? 0"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="order_client_id"
                            :value="__('Клиент')"
                        />
                        <x-select
                            id="order_client_id"
                            name="order_client_id"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->client_id ?? 0"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="order_date_order"
                            :value="__('Дата заказа')"
                        />
                        <x-select
                            id="order_date_order"
                            name="order_date_order"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->date_order ?? 0"
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
                    <th class="w-2/12 border-2 border-gray-400 px-4 py-2">Дата</th>
                    <th class="w-3/12 border-2 border-gray-400 px-4 py-2">Состав</th>
                    <th class="w-2/12 border-2 border-gray-400 px-4 py-2">Статус</th>
                    <th class="w-1/12 border-2 border-gray-400 px-4 py-2">Составил</th>
                    <th class="w-1/12 border-2 border-gray-400 px-4 py-2">Клиент</th>
                    <th class="w-2/12 border-2 border-gray-400 px-4 py-2">Действия</th>
                </tr>
                @if(!empty($orders->items()))
                    @foreach($orders as $order)
                        <tr>
                            <td class="border-2 border-gray-400 px-4 py-2">{{$order->id}}</td>
                            <td class="border-2 border-gray-400 px-4 py-2">{{\Illuminate\Support\Carbon::parse($order->date_order)->format('d.m.Y H:i')}}</td>
                            <td class="border-2 border-gray-400 px-4 py-2">
                                @foreach($order->products as $product)
                                    <div class="text-gray-800">
                                        <span>
                                            {{$product->count}} x {{$product->product->name}} @if($product->ingredients->isNotEmpty()):@endif
                                        </span>
                                        @if($product->ingredients->isNotEmpty())
                                            @foreach($product->ingredients as $ingredient)
                                                <p class="ml-2">
                                                    <span>+ {{$ingredient->count}} x </span>
                                                    <label class="rounded px-1 bg-green-500 mr-0.5">
                                                        {{ $ingredient->ingredient->name }}
                                                    </label>
                                                    <span>;</span>
                                                </p>
                                            @endforeach
                                        @endif
                                    </div>
                                @endforeach
                            </td>
                            <td class="border-2 border-gray-400 px-4 py-2">{{$order->status->name}}</td>
                            <td class="border-2 border-gray-400 px-4 py-2">
                                @can('user_list')
                                    <x-a body="gray" href="{{ route('users.show', $order->creator->id) }}">
                                        {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}
                                    </x-a>
                                @else
                                    {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}
                                @endcan
                            </td>
                            <td class="border-2 border-gray-400 px-4 py-2">
                                @if(!empty($order->client))
                                    @can('user_list')
                                    <x-a body="gray" href="{{ route('users.show', $order->client->id) }}">
                                        {{ $order->client->last_name . ' ' . $order->client->first_name . ' ' . $order->client->father_name}}
                                    </x-a>
                                    @else
                                        {{ $order->client->last_name . ' ' . $order->client->first_name . ' ' . $order->client->father_name}}
                                    @endcan
                                @else
                                    <x-no-data font="font-normal"></x-no-data>
                                @endif
                            </td>
                            <td class="border-2 border-gray-400 px-4 py-2">
                                <x-a
                                    body="info"
                                    href="{{ route('orders.show',$order->id) }}"
                                >Посмотреть
                                </x-a>
                                <x-a href="{{ route('orders.edit',$order->id) }}">&#128393;</x-a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7"><x-no-data></x-no-data></td>
                    </tr>
                @endif
            </table>
            <x-paginate :paginator="$orders"></x-paginate>
        </div>
    </div>
</x-app-layout>
