
@props(['name', 'id', 'value', 'image', 'alt','text'])

<div class="">
    <label for="{{ $id }}" class="relative block cursor-pointer">
        <input class="" type="radio" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" {{ $attributes }}>
        <img class="w-full h-auto border-solid border transform checked:scale-105 transition ease-in-out duration-300 {{ $attributes->get('checked') ? 'border-red-500' : 'border-gray-300' }}" src="{{asset($image)}}" alt="{{ $alt }}"> {{ $text }}
    </label>
</div>
