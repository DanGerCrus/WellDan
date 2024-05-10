
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
            :value="$products_filter->name ?? __('')"
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
            :value="$products_filter->description ?? __('')"
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
            :selected="$products_filter->category_id ?? 0"
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
                :value="$products_filter->min_price ?? __('1')"
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
                :value="$products_filter->max_price ?? __('')"
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
            :data="$products_order->default"
            :selected="$products_order->name ?? 0"
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
            :data="$products_order->default"
            :selected="$products_order->price ?? 0"
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
            :data="$products_order->default"
            :selected="$products_order->category_id ?? 0"
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
