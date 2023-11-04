<x-app-layout>
    <x-slot name="header">
        @include('products_categories.partials.header')
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-lg flex flex-col justify-center items-center py-4 lg:max-w-none lg:p-6 bg-white shadow sm:rounded-lg">
                <div class="flex flex-col justify-center items-start gap-2">
                    <x-item-p label="Название: " value="{{$category->name}}"></x-item-p>
                    <div class="flex flex-row w-full justify-center items-center gap-2">
                        @can('category-edit')
                        <x-primary-a :href="route('categories.edit', $category->id)">{{__('Редактировать')}}</x-primary-a>
                        @endcan
                        @can('category-delete')
                        <x-danger-button
                            type="button"
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-product-type-deletion')"
                        >
                            {{__('Удалить')}}
                        </x-danger-button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="confirm-product-type-deletion" focusable>
        <form method="post" action="{{ route('categories.destroy', $category->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Вы уверены, что хотите удалить категорию товара "' . $category->name . '" и все товары этого типа?') }}
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
