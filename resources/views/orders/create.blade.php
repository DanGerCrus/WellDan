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
            @if (count($errors) > 0)
                <div class="w-full px-10 py-5 bg-red-700">
                    <strong>Whoops!</strong> Возникли проблемы с вашими данными.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <x-order-product-form key="0" clone="1" :products="$products_select"
                                  :ingredients="$ingredients_select"></x-order-product-form>
            <x-product-ingredient-card productKey="0" key="0" clone="1"
                                       :ingredients="$ingredients_select"></x-product-ingredient-card>
            <section
                class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md"
            >
                <form method="post" action="{{ route('orders.store') }}">
                    @csrf

                    <h1 class="font-semibold text-xl text-gray-800 leading-tight">Товары</h1>
                    <div class="container-line-ProductOrder">
                        <x-order-product-form key="0" :products="$products_select"
                                              :ingredients="$ingredients_select"></x-order-product-form>
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
