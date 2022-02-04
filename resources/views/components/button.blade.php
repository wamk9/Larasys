<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 bg-gray-800 border border-transparent btn-lg btn btn-secondary']) }}>
    {{ $slot }}
</button>
