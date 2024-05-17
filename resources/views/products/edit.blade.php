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
            @if (count($errors) > 0)
                <div class="w-full px-10 py-5 bg-red-700">
                    <strong>Whoops!</strong> Возникли проблемы с вашими данными.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <section
                class="max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md"
            >
                <x-product-ingredient-card key="0" clone="1" :ingredients="$ingredients"></x-product-ingredient-card>
                <form method="post" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div
                        class="py-4"
                    >
                        <x-image-preview
                            src="{{$product->photo}}"
                        />
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
                            value="{{$product->name}}"
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
                            value="{{$product->price}}"
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
                            {{$product->description}}
                        </x-textarea>
                        <x-input-error
                                class="mt-2"
                                :messages="$errors->get('description')"
                        />
                    </div>

                    <div class="py-4">
                        <x-input-label
                            for="category_id"
                            :value="__('Тип товара')"
                        />
                        <x-select
                            id="category_id"
                            name="category_id"
                            class="mt-1 block w-full"
                            :data="$categories"
                            selected="{{$product->category_id}}"
                            required
                        />
                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('category_id')"
                        />
                    </div>

                    <div
                        class="py-4"
                    >
                        <x-input-label
                            for="kkal"
                            :value="__('Калорийность')"
                        />
                        <x-text-input
                            id="kkal"
                            name="kkal"
                            type="number"
                            class="mt-1 block w-full"
                            min="0"
                            value="{{$product->kkal}}"
                            step=any
                            required
                        />
                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('kkal')"
                        />
                    </div>

                    <div class="my-2 flex flex-col">
                        <x-input-label>
                            <x-checkbox class="no_ingredients" name="no_ingredients" value="1" :checked="$product->no_ingredients"></x-checkbox>
                            Нет ингредиентов
                        </x-input-label>
                    </div>

                    <div class="py-4 ingredients_form">
                        <h1 class="font-semibold text-xl text-gray-800 leading-tight">Ингредиенты</h1>

                        <div class="py-4 flex flex-col justify-items-stretch container-line-Ingredient">
                            @if($product->ingredients->isNotEmpty())
                                @foreach($product->ingredients as $key => $ingredient)
                                    <x-product-ingredient-card :type="$key" :key="$key" :ingredientID="$ingredient->ingredient_id" :ingredientCount="$ingredient->count" :ingredients="$ingredients"></x-product-ingredient-card>
                                @endforeach
                            @else
                                <x-product-ingredient-card key="0" :ingredients="$ingredients"></x-product-ingredient-card>
                            @endif
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-4"
                    >
                        <x-primary-button>
                            {{ __('Сохранить') }}
                        </x-primary-button>

                        @if (session('status') === 'product-updated')
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
<script src="{{asset('/js/ProductIngredientForm.js')}}"></script>
<script src="{{asset('/js/no_ingredients.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new ProductIngredientForm();
        hiddenForm();
    })
</script>
