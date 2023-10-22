<div
    @php if(!empty($clone)) { echo 'id="line-clone-Order"'; } @endphp
    class="flex flex-row justify-between items-end py-4 line-Order {{empty($clone) ? '' : 'hidden'}}"
>
    <div>
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
        />
    </div>

    <div>
        <x-input-label
            for="count"
            :value="__('Количество')"
        />
        <x-text-input
            id="count"
            name="products[{{$key}}][count]"
            type="number"
            class="mt-1 block w-full"
            min="1"
            :value="!empty($productCount) ? $productCount : 1"
            required
            autofocus
        />
    </div>

    <div class="flex flex-row justify-end items-end">
        <x-green-button
            type="button"
            class="add-line-Order {{empty($type) ? '' : 'hidden'}}"
        >
            {{ __('+') }}
        </x-green-button>
        <x-danger-button
            type="button"
            class="remove-line-Order {{!empty($type) ? '' : 'hidden'}}"
        >
            {{ __('-') }}
        </x-danger-button>
    </div>
</div>
