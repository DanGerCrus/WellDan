<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    <div class="flex flex-row items-center justify-between">
        <h1>{{ __('Товары') }}</h1>
        @auth
            <div class="flex flex-row items-center justify-between">
                @can('product-edit')
                    <x-nav-link :href="route('products.create')" :active="request()->routeIs('products.create')">
                        {{__('Добавить')}}
                    </x-nav-link>
                @endcan
            </div>
        @endauth
    </div>
</h2>
