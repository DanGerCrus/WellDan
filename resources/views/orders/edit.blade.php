<x-app-layout>
    <x-slot
        name="header"
    >
        @include('orders.partials.header')
    </x-slot>
    <div
        class="py-12"
    >
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
        >
            <section
                class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md"
            >
                <x-order-product-card key="0" clone="1" :products="$products"></x-order-product-card>
                <form method="post" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    @method('patch')

                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                        <p>№{{$order->id}}</p>
                        <p>Дата: {{\Illuminate\Support\Carbon::parse($order->date_order)->format('d.m.Y H:i')}}</p>
                        <p>Статус: {{$order->status->name}}</p>
                        <p>Создал: {{$order->creator->email}}</p>
                    </h1>
                    <div class="py-4">
                        <x-input-label
                            for="status_id"
                            :value="__('Статус')"
                        />
                        <x-select
                            id="status_id"
                            name="status_id"
                            class="mt-1 block w-full"
                            :data="$statuses"
                            :selected="$order->status_id"
                            required
                        />
                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('status_id')"
                        />
                    </div>

                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">Продукты</h1>

                    <div class="py-4 flex flex-col justify-items-stretch container-line-Order">
                        @if($order->products->isNotEmpty())
                            @foreach($order->products as $key => $product)
                                <x-order-product-card :type="$key" :key="$key" :productID="$product->product_id" :productCount="$product->count" :products="$products"></x-order-product-card>
                            @endforeach
                        @else
                            <x-order-product-card key="0" :products="$products"></x-order-product-card>
                        @endif
                    </div>

                    <div
                        class="flex items-center gap-4"
                    >
                        <x-primary-button>
                            {{ __('Сохранить') }}
                        </x-primary-button>

                        @if (session('status') === 'order-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 5000)"
                                class="text-sm text-gray-600"
                            >{{ __('Сохранено.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
<script src="{{asset('/js/OrderForm.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new OrderForm();
    })
</script>
