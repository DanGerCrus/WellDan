<x-app-layout>
    <x-slot name="header">
        @include('orders.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status') === 'order-repeat')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-gray-600"
                >{{ __('Заказ успешно повторен.') }}</p>
            @endif
            @if (session('status') === 'order-cancel')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-gray-600"
                >{{ __('Заказ успешно отменен.') }}</p>
            @endif
            <div class="max-w-lg flex flex-col justify-center items-center py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col justify-center items-start gap-2">
                    <x-item-p label="Номер" value="{{$order->id}}"></x-item-p>
                    <x-item-p label="Дата" value="{{\Illuminate\Support\Carbon::parse($order->date_order)->format('d.m.Y H:i')}}"></x-item-p>
                    <x-item-p label="Статус" value="{{$order->status->name}}"></x-item-p>
                    <div class="text-gray-800">
                        <p class="font-bold">
                            Создатель :
                        </p>
                        <span>
                            @can('user_list')
                                <x-a body="gray" href="{{ route('users.show', $order->creator->id) }}">
                                    {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}
                                </x-a>
                            @else
                                {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}
                            @endcan
                        </span>
                    </div>
                    <div class="text-gray-800">
                        <p class="font-bold">
                            Клиент :
                        </p>
                        <span>
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
                        </span>
                    </div>
                    <div class="text-gray-800">
                        <p class="font-bold">Состав:</p>
                        @php $orderPrice = 0; $orderKkal = 0; @endphp
                        @foreach($order->products as $product)
                            @php $productPrice = 0; $productKKal = 0; $ingredientPrice = 0; $ingredientKkal = 0; @endphp
                            <p>
                                @php
                                    $productPrice = $product->product->price * $product->count;
                                    $productKKal = $product->product->kkal * $product->count;
                                @endphp
                                {{$product->count}} x {{$product->product->name}} = {{$productPrice}}руб. ({{$productKKal}} ккал.)@if($product->ingredients->isNotEmpty()):@endif
                            </p>

                            @if($product->ingredients->isNotEmpty())
                                @foreach($product->ingredients as $ingredient)
                                    <p class="ml-2">
                                        <span>+ {{$ingredient->count}} x </span>
                                        <label class="rounded px-1 bg-green-500 mr-0.5">
                                            {{ $ingredient->ingredient->name }}
                                        </label>
                                        <span> = {{$ingredient->ingredient->price * $ingredient->count}}руб. ({{$ingredient->ingredient->kkal * $ingredient->count}} ккал.);</span>
                                    </p>
                                    @php
                                        $ingredientPrice += $ingredient->ingredient->price * $ingredient->count;
                                        $ingredientKkal += $ingredient->ingredient->kkal * $ingredient->count;
                                    @endphp
                                @endforeach
                            @endif
                            @php
                                $orderPrice += $productPrice + ($ingredientPrice * $product->count);
                                $orderKkal += $productKKal + ($ingredientKkal * $product->count);
                            @endphp
                        @endforeach
                        <p>
                            <span id="order_price" class="pt-5">Итого сумма: {{$orderPrice}}</span><span class="pt-5"> руб.</span>
                        </p>
                        <p>
                            <span id="order_kkal" class="pt-5">Итого ккал: {{$orderKkal}}</span><span class="pt-5"> ккал.</span>
                        </p>
                    </div>
                    <div class="flex flex-row w-full justify-center items-center gap-2">
                        @can('order-create')
                        <form method="post" action="{{ route('orders.repeat', $order->id) }}">
                            @csrf
                            <x-secondary-button type="submit">
                                {{ __('Повторить') }}
                            </x-secondary-button>
                        </form>
                        @endcan
                        @can('order-edit')
                            <x-primary-a :href="route('orders.edit', $order->id)">{{__('Редактировать')}}</x-primary-a>
                            <x-danger-button
                                type="button"
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-order-deletion')"
                            >
                                {{__('Удалить')}}
                            </x-danger-button>
                        @else
                            <form method="post" action="{{ route('orders.cancel', $order->id) }}">
                                @csrf
                                <x-danger-button type="submit">
                                    {{ __('Отменить') }}
                                </x-danger-button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>

            <table class="table-auto w-full my-5">
                <tr>
                    <th class="w-1/12 border-2 border-gray-400 px-4 py-2">№</th>
                    <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Дата смены статуса</th>
                    <th class="w-1/6 border-2 border-gray-400 px-4 py-2">Статус</th>
                </tr>
                @if(!empty($history) && $history->isNotEmpty())
                    @foreach ($history as $key => $row)
                        <tr>
                            <td class="border-2 border-gray-400 px-4 py-2">{{ ++$key }}</td>
                            <td class="border-2 border-gray-400 px-4 py-2">{{ \Carbon\Carbon::parse($row->date)->format('d.m.Y H:i:s')}}</td>
                            <td class="border-2 border-gray-400 px-4 py-2">{{ $row->status->name }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3"><x-no-data></x-no-data></td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

    <x-modal name="confirm-order-deletion" focusable>
        <form method="post" action="{{ route('orders.destroy', $order->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Вы уверены, что хотите удалить заказ №' . $order->id . '?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Отмена') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" type="submit">
                    {{ __('Удалить') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
