<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn-outline-secondary']) }}>
    {{ $slot }}
</button>
