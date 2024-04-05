<x-app-layout>
    <x-slot name="header">
        @include('products_categories.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <form method="GET" action="{{route('categories.index')}}"
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
                </div>
                <div
                    class="flex items-center gap-4 mt-4"
                >
                    <x-primary-button>
                        {{ __('Применить') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="grid max-w-lg gap-10 lg:grid-cols-3 py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
                @if(!empty($categories->items()))
                    @foreach($categories as $category)
                        <x-product-category-card :category="$category"></x-product-category-card>
                    @endforeach
                @else
                    <x-no-data></x-no-data>
                @endif
            </div>
            <x-paginate :paginator="$categories"></x-paginate>
        </div>
    </div>
</x-app-layout>
