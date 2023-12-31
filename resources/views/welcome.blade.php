<x-app-layout>
    <x-slot name="header">
        @include('products.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-row">
                <x-a body="info" href="{{route('welcome')}}">
                    Все
                </x-a>
                @foreach($categories as $category)
                    <x-a body="info" href="{{route('welcome', ['category_id' => $category->id])}}">
                        {{$category->name}}
                    </x-a>
                @endforeach
            </div>
            <div class="grid max-w-lg gap-10 lg:grid-cols-3 py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
                @foreach($products as $product)
                    <x-product-card :product="$product"></x-product-card>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
