<x-app-layout>
    <x-slot
            name="header"
    >
        @include('products.partials.header')
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
                <form
                        method="post"
                        action="{{ route('products.store') }}"
                        enctype="multipart/form-data"
                >
                    @csrf
                    <div
                            class="py-4"
                    >
                        <x-image-preview/>
                        <x-input-label
                                for="photo"
                                :value="__('Изображение')"
                        />
                        <x-text-input
                                id="photo"
                                name="photo"
                                type="file"
                                accept="image/*"
                                class="use-ImagePreview mt-1 block w-full"
                                required
                        />
                        <x-input-error
                                class="mt-2"
                                :messages="$errors->get('photo')"
                        />
                    </div>
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
                                for="price"
                                :value="__('Стоимость')"
                        />
                        <x-text-input
                                id="price"
                                name="price"
                                type="number"
                                class="mt-1 block w-full"
                                min="0"
                                required
                                autofocus
                        />
                        <x-input-error
                                class="mt-2"
                                :messages="$errors->get('price')"
                        />
                    </div>

                    <div
                            class="py-4"
                    >
                        <x-input-label
                                for="description"
                                :value="__('Описание')"
                        />
                        <x-textarea
                                id="description"
                                name="description"
                                class="mt-1 block w-full"
                                min="0"
                                required
                                autofocus
                        >
                        </x-textarea>
                        <x-input-error
                                class="mt-2"
                                :messages="$errors->get('description')"
                        />
                    </div>

                    <div class="py-4">
                        <x-input-label
                                for="category_id"
                                :value="__('Категория товара')"
                        />
                        <x-select
                                id="category_id"
                                name="category_id"
                                class="mt-1 block w-full"
                                :data="$categories"
                                required
                        />
                        <x-input-error
                                class="mt-2"
                                :messages="$errors->get('category_id')"
                        />
                    </div>

                    <div
                            class="flex items-center gap-4"
                    >
                        <x-primary-button>
                            {{ __('Сохранить') }}
                        </x-primary-button>

                        @if (session('status') === 'product-created')
                            <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 5000)"
                                    class="text-sm text-gray-600"
                            >{{ __('Сохранено.') }}</p>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>
</x-app-layout>
