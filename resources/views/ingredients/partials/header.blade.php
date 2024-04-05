<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    <div class="flex flex-row items-center justify-between">
        <h1>{{ __('Ингредиенты') }}</h1>
        @auth
            <div class="flex flex-row items-center justify-between">
                @can('ingredient-edit')
                    <x-nav-link :href="route('ingredients.create')" :active="request()->routeIs('ingredients.create')">
                        {{__('Добавить')}}
                    </x-nav-link>
                @endcan
            </div>
        @endauth
    </div>
</h2>
