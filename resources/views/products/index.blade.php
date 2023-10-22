<x-app-layout>
    <x-slot name="header">
        @include('products.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid max-w-lg gap-10 lg:grid-cols-3 py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
                @foreach($products as $product)
                    <x-product-card :product="$product"></x-product-card>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
