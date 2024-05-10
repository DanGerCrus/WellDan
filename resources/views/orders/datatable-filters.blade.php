<h1 class="font-semibold text-xl text-gray-800 leading-tight">Фильтры</h1>
<div class="grid grid-cols-3 gap-10">
    <div class="">
        <x-input-label
            for="creator_id"
            :value="__('Составил')"
        />
        <x-select
            id="creator_id"
            name="creator_id"
            class="mt-1 block w-full"
            :data="$users_select"
            :selected="$orders_filter->creator_id ?? 0"
        />
    </div>
    <div class="">
        <x-input-label
            for="client_id"
            :value="__('Клиент')"
        />
        <x-select
            id="client_id"
            name="client_id"
            class="mt-1 block w-full"
            :data="$users_select"
            :selected="$orders_filter->client_id ?? 0"
        />
    </div>
    <div class="">
        <x-input-label
            for="date_order"
            :value="__('Дата заказа')"
        />
        <div class="flex flex-row justify-between items-center">
            <x-input-label
                for="min_date_order"
                :value="__('от')"
            />
            <x-text-input
                id="min_date_order"
                name="min_date_order"
                type="datetime-local"
                min="1"
                :value="$orders_filter->min_date_order ?? null"
                class="mt-1"
            />
            <x-input-label
                for="max_date_order"
                :value="__('до')"
            />
            <x-text-input
                id="max_date_order"
                name="max_date_order"
                type="datetime-local"
                min="1"
                :value="$orders_filter->max_date_order ?? null"
                class="mt-1"
            />
        </div>
    </div>
</div>
<h1 class="font-semibold text-xl text-gray-800 leading-tight my-2">Сортировка</h1>
<div class="grid grid-cols-5 gap-10">
    <div>
        <x-input-label
            for="order_creator_id"
            :value="__('Составил')"
        />
        <x-select
            id="order_creator_id"
            name="order_creator_id"
            class="mt-1"
            :data="$orders_order->default"
            :selected="$orders_order->creator_id ?? 0"
        />
    </div>
    <div>
        <x-input-label
            for="order_client_id"
            :value="__('Клиент')"
        />
        <x-select
            id="order_client_id"
            name="order_client_id"
            class="mt-1"
            :data="$orders_order->default"
            :selected="$orders_order->client_id ?? 0"
        />
    </div>
    <div>
        <x-input-label
            for="order_date_order"
            :value="__('Дата заказа')"
        />
        <x-select
            id="order_date_order"
            name="order_date_order"
            class="mt-1"
            :data="$orders_order->default"
            :selected="$orders_order->date_order ?? 0"
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
