<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    <div class="flex flex-row items-center justify-between">
        <h1>{{ __('Заказы') }}</h1>
        @auth
            <div class="flex flex-row items-center justify-between">
                @can('order-edit')
                    <x-nav-link :href="route('orders.create')" :active="request()->routeIs('orders.create')">
                        {{__('Добавить')}}
                    </x-nav-link>
                @endcan
            </div>
        @endauth
    </div>
</h2>
