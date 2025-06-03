<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#FCD34D] border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-500 focus:bg-yellow-100 active:bg-[#FCD34D] focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
