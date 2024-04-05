<div
    @php if(!empty($clone)) { echo 'id="line-clone-ProductOrder"'; } @endphp
    class="p-5 border-2 border-gray-500 rounded mb-2 line-ProductOrder {{empty($clone) ? '' : 'hidden'}}"
>
    <div
        class="font-semibold text-xl text-gray-800 leading-tight"
    >
        <div class="flex flex-row items-center">
            <div class="pr-5">
                <x-input-label
                    for="product_count"
                    :value="__('Количество')"
                />
                <x-text-input
                    id="product_count"
                    name="products[{{$key}}][count]"
                    type="number"
                    class="mt-1 block"
                    min="1"
                    :value="isset($productCount) ? $productCount : 1"
                    required
                    autofocus
                />
            </div>
            <span class="pt-4">x</span>
            <div class="pl-5">
                <x-input-label
                    for="product_id"
                    :value="__('Товар')"
                />
                <x-select
                    id="product_id"
                    name="products[{{$key}}][id]"
                    class="mt-1 block w-full"
                    :data="$products"
                    :selected="!empty($productID) ? $productID : 0"
                    required
                    :disabled="!empty($blockAdd) ? 1 : 0"
                />
            </div>
        </div>
    </div>

    <div class="py-4">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">Доп. ингридиенты</h1>

        <div class="py-4 flex flex-col justify-items-stretch container-line-Ingredient" data-productKey="{{$key}}">
            @if(!empty($productIngredients) && $productIngredients->isNotEmpty())
                @foreach($productIngredients as $keyIngredient => $ingredient)
                    <x-product-ingredient-card :productKey="$key" :type="$keyIngredient" :key="$keyIngredient" :ingredientID="$ingredient->ingredient_id" :ingredientCount="$ingredient->count" :ingredients="$ingredients"></x-product-ingredient-card>
                @endforeach
            @else
                <x-product-ingredient-card :productKey="$key" key="0" :ingredientCount="0" :ingredients="$ingredients"></x-product-ingredient-card>
            @endif
        </div>
    </div>

    <div class="flex flex-row justify-end items-end">
        @if(empty($blockAdd))
        <x-green-button
            type="button"
            class="add-line-ProductOrder {{empty($type) ? '' : 'hidden'}}"
        >
            {{ __('Добавить') }}
        </x-green-button>
        @endif
        <x-danger-button
            type="button"
            class="remove-line-ProductOrder {{!empty($type) ? '' : 'hidden'}}"
        >
            {{ __('Удалить') }}
        </x-danger-button>
    </div>
</div>
