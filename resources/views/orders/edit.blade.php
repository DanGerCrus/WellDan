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
            <x-order-product-form key="0" clone="1" :products="$products"
                                  :ingredients="$ingredients"></x-order-product-form>
            <x-product-ingredient-card productKey="0" key="0" clone="1"
                                       :ingredients="$ingredients"></x-product-ingredient-card>
            <section
                class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md"
            >
                <form method="post" action="{{ route('orders.update', $order->id) }}">
                    @csrf
                    @method('patch')
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                        <p>№{{$order->id}}</p>
                        <p>Дата: {{\Illuminate\Support\Carbon::parse($order->date_order)->format('d.m.Y H:i')}}</p>
                        <p>Статус: {{$order->status->name}}</p>
                        <p>Клиент:
                            @if(!empty($order->client))
                                {{ $order->client->last_name . ' ' . $order->client->first_name . ' ' . $order->client->father_name}}
                            @else
                                <x-no-data font="font-normal"></x-no-data>
                            @endif
                        </p>
                        <p>Создал: {{ $order->creator->last_name . ' ' . $order->creator->first_name . ' ' . $order->creator->father_name}}</p>
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
                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">Товары</h1>
                    <div class="container-line-ProductOrder">
                        @foreach($order->products as $key => $product)
                            <x-order-product-form
                                :type="$key"
                                :key="$key"
                                :products="$products"
                                :ingredients="$ingredients"
                                :productIngredients="$product->ingredients"
                                :productCount="$product->count"
                                :productID="$product->product_id"
                            ></x-order-product-form>
                        @endforeach
                    </div>
                    <div
                        class="flex items-center gap-4"
                    >
                        <x-primary-button>
                            {{ __('Сохранить') }}
                        </x-primary-button>
                        <span id="order_price" class="pl-5">0</span><span class="pl-5">руб.</span>
                        <span id="order_kkal" class="pl-5">0</span><span class="pl-5">ккал.</span>
                        @if (session('status') === 'order-created')
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
<script src="{{asset('/js/ProductIngredientForm.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new OrderForm();
        new ProductIngredientForm();
    })
</script>
