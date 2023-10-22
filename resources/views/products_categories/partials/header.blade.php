<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    <div class="flex flex-row items-center justify-between">
        <h1>{{ __('Категории товаров') }}</h1>
        @auth
            <div class="flex flex-row items-center justify-between">
                @can('category-edit')
                    <x-nav-link :href="route('categories.create')" :active="request()->routeIs('categories.create')">
                        {{__('Добавить')}}
                    </x-nav-link>
                @endcan
            </div>
        @endauth
    </div>
</h2>
