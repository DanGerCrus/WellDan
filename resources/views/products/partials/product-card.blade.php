@props([
    'maxWidth' => 'xs',
    'welcome' => false,
])
@php
    $maxWidth = [
        'xs' => 'max-w-xs',
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
    ][$maxWidth];
@endphp
<div
    class="{{$maxWidth}} overflow-hidden mx-auto lg:mx-0 rounded-lg shadow-lg bg-white flex flex-col justify-between"
>
    <div
        class="px-4 py-2 bg-gray-900"
    >
        <h1
            class="text-xl font-bold uppercase text-gray-300"
        >
            {{$product->name}}
        </h1>
        <div class="flex flex-row justify-between items-center">
            <p
                class="mt-1 text-sm text-gray-200"
            >
                {{$product->category->name}}
            </p>
            @auth
                @if(!empty($isOrder))
                    <x-btn x-data=""
                           x-on:click.prevent="$dispatch('open-modal', 'modal_addIngredient{{$product->id}}')"
                           body="info"
                           type="button"
                    >В заказ</x-btn>
                    <x-modal id="modal_addIngredient{{$product->id}}" name="modal_addIngredient{{$product->id}}" focusable>
                        <div class="p-5">
                            <div
                                class="font-semibold text-xl text-gray-800 leading-tight"
                            >
                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <div class="flex flex-row items-center">
                                    <div class="pr-5">
                                        <x-input-label
                                            for="count"
                                            :value="__('Количество')"
                                        />
                                        <x-text-input
                                            id="count"
                                            name="count"
                                            type="number"
                                            class="mt-1 block"
                                            min="1"
                                            value="1"
                                            required
                                            autofocus
                                        />
                                    </div>
                                    <span class="pt-4">x {{$product->name}}</span>
                                </div>
                            </div>
                            <img
                                class="object-cover w-full h-96 mt-2" src="{{$product->photo}}"
                                alt="{{$product->name}}"
                            >
                            <x-product-ingredient-card key="0" clone="1" :ingredients="$ingredients"></x-product-ingredient-card>
                            <div class="py-4">
                                <h1 class="font-semibold text-xl text-gray-800 leading-tight">Добавить</h1>

                                <div class="py-4 flex flex-col justify-items-stretch container-line-Ingredient">
                                    <x-product-ingredient-card key="0" :ingredientCount="0" :ingredients="$ingredients"></x-product-ingredient-card>
                                </div>
                            </div>

                            <div class="m-6 flex justify-end">
                                <x-green-button class="addIngredient mr-2">
                                    {{ __('Добавить') }}
                                </x-green-button>
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Отмена') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </x-modal>
                @else
                    <x-in-basket :id="$product->id" :route="route('products.index')"></x-in-basket>
                @endif
            @endauth
        </div>
    </div>

    <a href="{{$welcome ? '#menu' : route('products.show', $product->id)}}">
        <img
            class="object-cover w-full h-48" src="{{$product->photo}}"
            alt="{{$product->name}}"
        >
    </a>


    <div
        class="flex items-center justify-between px-4 py-2 bg-gray-900"
    >
        <h1
            class="text-lg font-bold text-white"
        >
            {{$product->price}} руб.
        </h1>
        <div class="flex flex-row justify-between items-center">
            @auth
                @can('product-edit')
                    <a
                        class="mx-2 px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors
                    duration-300 transform bg-white rounded hover:bg-gray-200 focus:bg-gray-400 focus:outline-none"
                        href="{{route('products.edit', $product->id)}}"
                    >
                        Редактировать
                    </a>
                @endcan
            @endauth
        </div>
    </div>
</div>
