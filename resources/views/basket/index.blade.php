<x-app-layout>
    <x-slot name="header">
        @include('basket.partials.header')
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
                <form id="form" method="post" action="{{ route('basket.update') }}">
                    @csrf
                    @method('patch')
                    @if($basket->isNotEmpty())
                        <input type="hidden" name="client_id" value="{{Auth::id()}}">
                        <input type="hidden" name="basket_clear" value="1">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">Товары</h1>
                        <div class="container-line-ProductOrder">
                            @foreach($basket as $key => $product)
                                <x-order-product-form
                                    type="1"
                                    :key="$key"
                                    :products="$products"
                                    :ingredients="$ingredients"
                                    :productIngredients="$product->ingredients"
                                    :productCount="$product->count"
                                    :productID="$product->product_id"
                                    :blockAdd="1"
                                ></x-order-product-form>
                            @endforeach
                        </div>
                        <div
                            class="flex items-center gap-4"
                        >
                            <x-primary-button id="basketUpdate">
                                {{ __('Сохранить') }}
                            </x-primary-button>
                            <x-green-button id="orderCreate" action="{{route('orders.store')}}">
                                {{ __('Создать заказ') }}
                            </x-green-button>
                            <span id="order_price" class="pl-5">0</span><span class="pl-5">руб.</span>

                            @if (session('status') === 'basket-updated')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Сохранено.') }}</p>
                            @endif
                            @if (session('status') === 'order-created')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-gray-600"
                                >{{ __('Заказ создан.') }}</p>
                            @endif
                        </div>
                    @else
                        <x-no-data></x-no-data>
                    @endif
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
        document.getElementById('basketUpdate').addEventListener('click', submitForm)
        document.getElementById('orderCreate').addEventListener('click', orderCreate)
    })
    function submitForm(event) {
        event.preventDefault();
        const form = document.getElementById('form')
        const disabledSelect = form.querySelectorAll('select#product_id')
        disabledSelect.forEach((el) => {
            el.removeAttribute('disabled')
        })
        form.submit()
    }
    function orderCreate(event) {
        event.preventDefault();
        const form = document.getElementById('form')
        const disabledSelect = form.querySelectorAll('select#product_id')
        disabledSelect.forEach((el) => {
            el.removeAttribute('disabled')
        })
        form.setAttribute('action', event.target.getAttribute('action'))
        form.querySelector('input[name="_method"]').remove()
        form.submit()
    }
</script>
