<div {{ $attributes->merge([
    'class' => 'border shadow-sm bg-white p-5 rounded-lg'
]) }}>
    {{ $slot }}
</div>
