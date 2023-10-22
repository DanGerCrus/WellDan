<div
    class="drop-shadow-md max-h-48 flex flex-row justify-center items-center my-2"
>
    <img
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'modal_ImagePreview')"
        {{
            $attributes->merge([
                'class' => (empty($attributes['src']) ? 'hidden' : '') . ' max-h-48',
                'id' => 'canvas_ImagePreview'
            ])
        }}
    >
    <svg
        width="800px"
        height="800px"
        viewBox="0 0 32 32"
        id="default_ImagePreview"
        {{
            $attributes->merge([
                'class' => (empty($attributes['src']) ? '' : 'hidden') . ' max-h-48 fill-gray-700 py-2'
            ])
        }}
    >
        <g
            id="Page-1"
            stroke="none"
            stroke-width="1"
            fill-rule="evenodd"
        >
            <g
                id="Icon-Set"
                transform="translate(-204.000000, -1035.000000)"
            >
                <path
                    d="M224.95,1046.05 C224.559,1045.66 223.926,1045.66 223.536,1046.05 L220,1049.59 L216.464,1046.05 C216.074,1045.66 215.441,1045.66 215.05,1046.05 C214.66,1046.44 214.66,1047.07 215.05,1047.46 L218.586,1051 L215.05,1054.54 C214.66,1054.93 214.66,1055.56 215.05,1055.95 C215.441,1056.34 216.074,1056.34 216.464,1055.95 L220,1052.41 L223.536,1055.95 C223.926,1056.34 224.559,1056.34 224.95,1055.95 C225.34,1055.56 225.34,1054.93 224.95,1054.54 L221.414,1051 L224.95,1047.46 C225.34,1047.07 225.34,1046.44 224.95,1046.05 L224.95,1046.05 Z M234,1063 C234,1064.1 233.104,1065 232,1065 L208,1065 C206.896,1065 206,1064.1 206,1063 L206,1039 C206,1037.9 206.896,1037 208,1037 L232,1037 C233.104,1037 234,1037.9 234,1039 L234,1063 L234,1063 Z M232,1035 L208,1035 C205.791,1035 204,1036.79 204,1039 L204,1063 C204,1065.21 205.791,1067 208,1067 L232,1067 C234.209,1067 236,1065.21 236,1063 L236,1039 C236,1036.79 234.209,1035 232,1035 L232,1035 Z"
                    id="cross-square"
                ></path>
            </g>
        </g>
    </svg>
</div>
<x-modal id="modal_ImagePreview" name="modal_ImagePreview" focusable>
    <div class="flex flex-row justify-center items-center m-4">
        <img
            {{
                $attributes->merge([
                    'id' => 'modalImage_ImagePreview'
                ])
            }}
        >
    </div>

    <div class="m-6 flex justify-end">
        <x-secondary-button x-on:click="$dispatch('close')">
            {{ __('Отмена') }}
        </x-secondary-button>
    </div>
</x-modal>
<script src="{{asset('/js/ImagePreview.js')}}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new ImagePreview();
    })
</script>
