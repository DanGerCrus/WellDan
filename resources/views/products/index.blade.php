<x-app-layout>
    <x-slot name="header">
        @include('products.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{route('products.index')}}"
                  class="rounded-xl shadow bg-gray-100 p-4">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Фильтры</h1>
                <div class="grid grid-cols-2 gap-10">
                    <div class="">
                        <x-input-label
                            for="name"
                            :value="__('Название')"
                        />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            :value="$filter->name ?? __('')"
                            class="mt-1 block w-full"
                        />
                    </div>
                    <div class="">
                        <x-input-label
                            for="description"
                            :value="__('Описание')"
                        />
                        <x-text-input
                            id="description"
                            name="description"
                            type="text"
                            :value="$filter->description ?? __('')"
                            class="mt-1 block w-full"
                        />
                    </div>
                    <div class="">
                        <x-input-label
                            for="category_id"
                            :value="__('Категория')"
                        />
                        <x-select
                            id="category_id"
                            name="category_id"
                            class="mt-1 block w-full"
                            :data="$category_select"
                            :selected="$filter->category_id ?? 0"
                        />
                    </div>
                    <div class="">
                        <x-input-label
                            for="price"
                            :value="__('Стоимость')"
                        />
                        <div class="flex flex-row justify-between items-center">
                            <x-input-label
                                for="min_price"
                                :value="__('от')"
                            />
                            <x-text-input
                                id="min_price"
                                name="min_price"
                                type="number"
                                min="1"
                                :value="$filter->min_price ?? __('1')"
                                class="mt-1"
                            />
                            <x-input-label
                                for="max_price"
                                :value="__('до')"
                            />
                            <x-text-input
                                id="max_price"
                                name="max_price"
                                type="number"
                                min="1"
                                :value="$filter->max_price ?? __('')"
                                class="mt-1"
                            />
                        </div>
                    </div>
                </div>
                <h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">Сортировка</h1>
                <div class="grid grid-cols-5 gap-10">
                    <div>
                        <x-input-label
                            for="order_name"
                            :value="__('Название')"
                        />
                        <x-select
                            id="order_name"
                            name="order_name"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->name ?? 0"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="order_price"
                            :value="__('Стоимость')"
                        />
                        <x-select
                            id="order_price"
                            name="order_price"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->price ?? 0"
                        />
                    </div>
                    <div>
                        <x-input-label
                            for="order_category_id"
                            :value="__('Категории')"
                        />
                        <x-select
                            id="order_category_id"
                            name="order_category_id"
                            class="mt-1"
                            :data="$order->default"
                            :selected="$order->category_id ?? 0"
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
            @if (session('status') === 'basket-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-gray-600"
                >{{ __('В корзине.') }}</p>
            @endif
            <div class="grid max-w-lg gap-10 lg:grid-cols-3 py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
                @if(!empty($products->items()))
                    @foreach($products as $product)
                        <x-product-card :product="$product"></x-product-card>
                    @endforeach
                @else
                    <x-no-data></x-no-data>
                @endif
            </div>
            <x-paginate :paginator="$products"></x-paginate>
        </div>
    </div>
</x-app-layout>
