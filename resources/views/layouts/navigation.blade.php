<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>
                @auth
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @can('product-list')
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                            {{ __('Товары') }}
                        </x-nav-link>
                    @endcan
                    @can('category-list')
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                            {{ __('Категория товаров') }}
                        </x-nav-link>
                    @endcan
                    @can('ingredient-list')
                        <x-nav-link :href="route('ingredients.index')" :active="request()->routeIs('ingredients.*')">
                            {{ __('Ингредиенты') }}
                        </x-nav-link>
                    @endcan
                    @can('order-list')
                        <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                            {{ __('Заказы') }}
                        </x-nav-link>
                    @endcan
                    @can('role-list')
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                            {{ __('Роли') }}
                        </x-nav-link>
                    @endcan
                    @can('user-list')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('Пользователи') }}
                        </x-nav-link>
                    @endcan
                </div>
                @endauth
            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                <x-nav-link :href="route('basket.index')" :active="request()->routeIs('basket.*')">
                    {{ __('Корзина ' . Auth::user()->basketCount()) }}
                </x-nav-link>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->email }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Личный кабинет') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Выход') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth
                @guest
                    <x-nav-link :href="route('login')">
                        {{ __('Войти') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')">
                        {{ __('Зарегистироваться') }}
                    </x-nav-link>
                @endguest
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                @can('product-list')
                    <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                        {{ __('Товары') }}
                    </x-responsive-nav-link>
                @endcan
                @can('category-list')
                    <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                        {{ __('Категория товаров') }}
                    </x-responsive-nav-link>
                @endcan
                @can('order-edit')
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')">
                        {{ __('Заказы') }}
                    </x-responsive-nav-link>
                @endcan
                @can('role-list')
                    <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.*')">
                        {{ __('Роли') }}
                    </x-responsive-nav-link>
                @endcan
                @can('user-list')
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                        {{ __('Пользователи') }}
                    </x-responsive-nav-link>
                @endcan
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @auth
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->first_name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    @endauth
            </div>

            <div class="mt-3 space-y-1">
                @auth
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Личный кабинет') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выход') }}
                    </x-responsive-nav-link>
                </form>
                @endauth
                @guest
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Войти') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Зарегистироваться') }}
                    </x-responsive-nav-link>
                @endguest
            </div>
        </div>
    </div>
</nav>
