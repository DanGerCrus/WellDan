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
                    <x-item-p label="Создатель" value="{{$order->creator->email}}"></x-item-p>
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
