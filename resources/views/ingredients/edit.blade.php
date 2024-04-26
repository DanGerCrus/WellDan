<x-app-layout>
    <x-slot
        name="header"
    >
        @include('ingredients.partials.header')
    </x-slot>
    <div
        class="py-12"
    >
        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
        >
            <section
                class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md"
            >
                <form method="post" action="{{ route('ingredients.update', $ingredient->id) }}">
                    @csrf
                    @method('patch')

                    <div
                        class="py-4"
                    >
                        <x-input-label
                            for="name"
                            :value="__('Название')"
                        />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            value="{{$ingredient->name}}"
                            class="mt-1 block w-full"
                            required
                            autofocus
                        />
                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('name')"
                        />
                    </div>

                    <div
                        class="py-4"
                    >
                        <x-input-label
                            for="kkal"
                            :value="__('Калории')"
                        />
                        <x-text-input
                            id="kkal"
                            name="kkal"
                            type="text"
                            value="{{$ingredient->kkal}}"
                            class="mt-1 block w-full"
                            required
                        />
                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('kkal')"
                        />
                    </div>

                    <div
                        class="py-4"
                    >
                        <x-input-label
                            for="price"
                            :value="__('Стоимость')"
                        />
                        <x-text-input
                            id="price"
                            name="price"
                            type="text"
                            value="{{$ingredient->price}}"
                            class="mt-1 block w-full"
                            required
                        />
                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('price')"
                        />
                    </div>

                    <div
                        class="flex items-center gap-4"
                    >
                        <x-primary-button>
                            {{ __('Сохранить') }}
                        </x-primary-button>

                        @if (session('status') === 'ingredient-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 5000)"
                                class="text-sm text-gray-600 dark:text-gray-400"
                            >{{ __('Сохранено.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
<script src="{{asset('js/imask.js')}}"></script>
<script>
    IMask(
        document.getElementById('kkal'),
        {
            mask: Number,
            radix: '.',
        }
    )
</script>

