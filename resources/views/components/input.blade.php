@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-[#f9f9f9] border-0 border-b border-b-[#FCD34D] focus:border-[#FCD34D] focus:ring-[#FCD34D] rounded-md shadow-sm']) !!}>
