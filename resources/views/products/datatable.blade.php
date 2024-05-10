@if (session('status') === 'basket-created')
    <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 5000)"
        class="text-sm text-gray-600"
    >{{ __('В корзине.') }}</p>
@endif
<div class="grid max-w-lg gap-10 lg:grid-cols-3 py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
    @if(!empty($products->items()))
        @foreach($products as $product)
            <x-product-card :product="$product"></x-product-card>
        @endforeach
    @else
        <x-no-data></x-no-data>
    @endif
</div>
<x-paginate :paginator="$products"></x-paginate>
