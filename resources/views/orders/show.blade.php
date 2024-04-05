<x-app-layout>
    <x-slot name="header">
        @include('orders.partials.header')
    </x-slot>
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
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
                        @foreach($order->products as $product)
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
                        @endforeach
                    </div>
                    <div class="flex flex-row w-full justify-center items-center gap-2">
                        <x-primary-a :href="route('orders.edit', $order->id)">{{__('Редактировать')}}</x-primary-a>
                        <x-danger-button
                            type="button"
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-order-deletion')"
                        >
                            {{__('Удалить')}}
                        </x-danger-button>
                    </div>
                </div>
            </div>
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
