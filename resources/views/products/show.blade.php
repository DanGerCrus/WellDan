<x-app-layout>
    <x-slot name="header">
        @include('products.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-lg flex flex-col justify-center items-center py-4 lg:max-w-none lg:p-6 bg-white shadow-xl sm:rounded-lg">
                <div class="flex flex-col justify-center items-start gap-2">
                    <img
                        class="max-w-lg"
                        src="{{$product->photo}}"
                        alt="{{$product->name}}"
                    >
                    <x-item-p label="Название: " value="{{$product->name}}"></x-item-p>
                    <x-item-p label="Описание: " >
                        <x-slot name="value">
                            {{$product->description}}
                        </x-slot>
                    </x-item-p>
                    <x-item-p label="Стоимость: " value="{{$product->price}}"></x-item-p>
                    <x-item-p label="Тип товара: " value="{{$product->category->name}}"></x-item-p>

                    <div class="flex flex-row w-full justify-center items-center gap-2">
                        <x-primary-a :href="route('products.edit', $product->id)">{{__('Редактировать')}}</x-primary-a>
                        <x-danger-button
                            type="submit"
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-product-deletion')"
                        >
                            {{__('Удалить')}}
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-product-deletion" focusable>
        <form method="post" action="{{ route('products.destroy', $product->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Вы уверены, что хотите удалить товар "' . $product->name . '"?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Отмена') }}
                </x-secondary-button>

                <x-danger-button class="ml-3" type="submit">
                    {{ __('Удалить') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
