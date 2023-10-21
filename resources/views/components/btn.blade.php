@props(['body'=>'primary'])
<?php
    $color=[];
    switch ($body){
        case 'danger':
            $color['bg']='bg-red-600';
            $color['hover']='hover:bg-red-700';
            $color['focus']='focus:border-red-900';
            $color['active']='active:bg-red-800';
            $color['ring']='ring-red-600';
            $color['text']='text-white';
            break;
        case 'success':
            $color['bg']='bg-green-600';
            $color['hover']='hover:bg-green-700';
            $color['focus']='focus:border-green-900';
            $color['active']='active:bg-green-800';
            $color['ring']='ring-green-600';
            $color['text']='text-black';
            break;
        case 'gray':
            $color['bg']='bg-gray-300';
            $color['hover']='hover:bg-gray-400';
            $color['focus']='focus:border-gray-900';
            $color['active']='active:bg-gray-500';
            $color['ring']='ring-gray-600';
            $color['text']='text-white';
            break;
        case 'primary':
            $color['bg']='bg-blue-600';
            $color['hover']='hover:bg-blue-700';
            $color['focus']='focus:border-blue-900';
            $color['active']='active:bg-blue-800';
            $color['ring']='ring-blue-600';
            $color['text']='text-gray-50';
            break;
        case 'info':
            $color['bg']='bg-blue-300';
            $color['hover']='hover:bg-blue-400';
            $color['focus']='focus:border-blue-900';
            $color['active']='active:bg-blue-500';
            $color['ring']='ring-blue-600';
            $color['text']='text-black';
            break;
    }
?>
<button {{ $attributes->merge(['type'=>'button','class' => $color['bg'].' '.$color['hover']." ".$color['focus']." ".
            $color['active']." ".$color['ring']." ".$color['text']." ".
            'inline-flex mx-1 items-center p-1.5 border border-transparent
            rounded-md focus:outline-none focus:ring disabled:opacity-25
            transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
