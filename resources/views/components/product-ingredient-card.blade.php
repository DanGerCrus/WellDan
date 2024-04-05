@php
    if (!isset($key)) {
        $key = 0;
    }
    $nameID = "ingredients[" . $key . "][id]";
    $nameCount = "ingredients[" . $key . "][count]";
    if (isset($productKey)) {
        $nameID = "products[$productKey][ingredients][$key][id]";
        $nameCount = "products[$productKey][ingredients][$key][count]";
    }
@endphp
<div
    @php if(!empty($clone)) { echo 'id="line-clone-Ingredient"'; } @endphp
    class="flex flex-row justify-between items-end py-4 line-Ingredient {{empty($clone) ? '' : 'hidden'}}"
>
    <div>
        <x-input-label
            for="ingredient_id"
            :value="__('Ингредиент')"
        />
        <x-select
            id="ingredient_id"
            name="{{$nameID}}"
            class="mt-1 block w-full"
            :data="$ingredients"
            :selected="!empty($ingredientID) ? $ingredientID : 0"
        />
    </div>

    <div>
        <x-input-label
            for="ingredient_count"
            :value="__('Количество')"
        />
        <x-text-input
            id="ingredient_count"
            name="{{$nameCount}}"
            type="number"
            class="mt-1 block w-full"
            min="0"
            :value="isset($ingredientCount) ? $ingredientCount : 1"
        />
    </div>

    <div class="flex flex-row justify-end items-end">
        <x-green-button
            type="button"
            class="add-line-Ingredient {{empty($type) ? '' : 'hidden'}}"
        >
            {{ __('+') }}
        </x-green-button>
        <x-danger-button
            type="button"
            class="remove-line-Ingredient {{!empty($type) ? '' : 'hidden'}}"
        >
            {{ __('-') }}
        </x-danger-button>
    </div>
</div>
