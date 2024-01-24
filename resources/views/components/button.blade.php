<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-white dark:bg-gray-700 overflow-hidden shadow-sm sm:rounded-lg mb-3 w-full']) }}>
    {{ $slot }}
</button>
