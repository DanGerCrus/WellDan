<x-app-layout>
    <x-slot name="header">
        @include('orders.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="container mx-auto px-4 my-5">
            <form method="GET" action="{{route('orders.index')}}"
                  class="rounded-xl shadow bg-gray-100 p-4">
                @include('orders.datatable-filters')
            </form>
            @include('orders.datatable')
        </div>
    </div>
</x-app-layout>
