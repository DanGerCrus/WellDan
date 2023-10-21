{{--Модальное окно отображения одной картинки--}}
<x-modal id="imgModal">
    <x-slot name="header"></x-slot>
</x-modal>
{{--Модальное окно отображения слайдера картинок--}}
<x-modal id="sliderModal">
    <x-slot name="header"></x-slot>
</x-modal>
{{--Модальное окно добавления жанра--}}
<x-modal id="genreCreate">
    <x-slot name="header">Добавить новый жанр</x-slot>
    {!! Form::open(['id'=>'genreCreateForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="clone">
        <div class="num">
            <p class="num font-semibold italic"># 1</p>
        </div>
        <x-label for="name" :value="__('Название:')" />
        <x-input class="block mt-1 w-full" type="text" name="name[]"
                 :value="old('name')"
                 minLength="3" maxLength="50" placeholder="Название жанра" required/>
    </div>
    <div class="content">

    </div>
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn type="submit">
            {{ __('Отправить') }}
        </x-btn>
        <x-btn class="addClone">
            {{ __('Добавить ещё') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно редактирования жанров--}}
<x-modal id="genreEdit">
    <x-slot name="header">Изменить название жанра</x-slot>
    {!! Form::open(['id'=>'genreEditForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <x-label for="name" :value="__('Название:')" />
    <x-input class="block mt-1 w-full" type="text" name="name"
             value=""
             minLength="3" maxLength="50" placeholder="Название жанра" required/>
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn type="submit">
            {{ __('Сохранить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно удаления жанра--}}
<x-modal id="genreDelete">
    <x-slot name="header">Удалить жанр</x-slot>
    {!! Form::open(['id'=>'genreDeleteForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <x-label for="name" value="" />
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn body="danger" type="submit">
            {{ __('Удалить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{--Модальное окно добавления автора--}}
<x-modal id="authorCreate">
    <x-slot name="header">Добавить нового автора</x-slot>
    {!! Form::open(['id'=>'authorCreateForm','class'=>'w-full','method'=>'POST']) !!}
        <div class="clone">
            <div class="num">
                <p class="num font-semibold italic"># 1</p>
            </div>
            <div>
                <x-label for="last_name" :value="__('Фамилия:')" />
                <x-input class="block mt-1 w-full" type="text" name="last_name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе\s]+$" minLength="2" maxLength="100" placeholder="Фамилия автора" required/>
            </div>
            <div class="mt-4">
                <x-label for="first_name" :value="__('Имя:')" />
                <x-input class="block mt-1 w-full" type="text" name="first_name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе\s]+$" minLength="2" maxLength="100" placeholder="Имя автора" required/>
            </div>
            <div class="mt-4">
                <x-label for="father_name" :value="__('Отчество (если есть):')" />
                <x-input class="block mt-1 w-full" type="text" name="father_name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Отчетсво автора"/>
            </div>
        </div>
        <div class="content">

        </div>
        <div class="flex flex-row items-center justify-center mt-4">
            <x-btn type="submit">
                {{ __('Отправить') }}
            </x-btn>
            <x-btn class="addClone">
                {{ __('Добавить ещё') }}
            </x-btn>
        </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно редактирования автора--}}
<x-modal id="authorEdit">
    <x-slot name="header">Изменить данные автора</x-slot>
    {!! Form::open(['id'=>'authorEditForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <div>
        <x-label for="last_name" :value="__('Фамилия:')" />
        <x-input class="block mt-1 w-full" type="text" name="last_name" value="" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Фамилия автора" required/>
    </div>
    <div class="mt-4">
        <x-label for="first_name" :value="__('Имя:')" />
        <x-input class="block mt-1 w-full" type="text" name="first_name" value="" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Имя автора" required/>
    </div>
    <div class="mt-4">
        <x-label for="father_name" :value="__('Отчество:')" />
        <x-input class="block mt-1 w-full" type="text" name="father_name" value="" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Отчетсво автора"/>
    </div>
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn type="submit">
            {{ __('Сохранить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно удаления автора--}}
<x-modal id="authorDelete">
    <x-slot name="header">Удалить автора</x-slot>
    {!! Form::open(['id'=>'authorDeleteForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <x-label for="last_name" value="" />
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn body="danger" type="submit">
            {{ __('Удалить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{--Модальное окно добавления издательства--}}
<x-modal id="publisherCreate">
    <x-slot name="header">Добавить новое издательство</x-slot>
    {!! Form::open(['id'=>'publisherCreateForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="clone">
        <div class="num">
            <p class="num font-semibold italic"># 1</p>
        </div>
        <x-label for="name" :value="__('Название:')" />
        <x-input class="block mt-1 w-full" type="text" name="name[]" :value="old('name')" minLength="2" maxLength="100" required placeholder="Название издательства"/>
    </div>
    <div class="content">

    </div>
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn type="submit">
            {{ __('Отправить') }}
        </x-btn>
        <x-btn class="addClone">
            {{ __('Добавить ещё') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно редактирования издательства--}}
<x-modal id="publisherEdit">
    <x-slot name="header">Изменить название издательства</x-slot>
    {!! Form::open(['id'=>'publisherEditForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <x-label for="name" :value="__('Название:')" />
    <x-input class="block mt-1 w-full" type="text" name="name"
             value=""
             minLength="3" maxLength="50" placeholder="Название издательства" required/>
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn type="submit">
            {{ __('Сохранить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно удаления издательства--}}
<x-modal id="publisherDelete">
    <x-slot name="header">Удалить издательство</x-slot>
    {!! Form::open(['id'=>'publisherDeleteForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <x-label for="name" value="" />
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn body="danger" type="submit">
            {{ __('Удалить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
{{-- Модальное окно удаления товара--}}
<x-modal id="productDelete">
    <x-slot name="header">Удалить товара</x-slot>
    {!! Form::open(['id'=>'productDeleteForm','class'=>'w-full','method'=>'POST']) !!}
    <div class="num">
        <p class="num font-semibold italic"></p>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <x-label for="name" value="" />
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn body="danger" type="submit">
            {{ __('Удалить') }}
        </x-btn>
    </div>
    {!! Form::close() !!}
</x-modal>
