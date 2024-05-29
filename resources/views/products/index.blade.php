<x-app-layout>
    <x-slot name="header">
        @include('products.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if ($message = Session::get('error'))
                <div class="w-full px-10 py-5 bg-red-500">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <form method="GET" action="{{route('products.index')}}"
                  class="rounded-xl shadow bg-gray-100 p-4">
                @include('products.datatable-filters')
            </form>
            @include('products.datatable')
        </div>
    </div>
</x-app-layout>
