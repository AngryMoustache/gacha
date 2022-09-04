<div
    class="relative"
    x-data="{
        hover: false,
        top: 0,
        left: 0,
    }"
>
    <div
        {{ $attributes->merge(['class' => 'relative']) }}
        @mouseenter="hover = true"
        @mouseleave="hover = false"
        @mousemove="(e) => {
            top = e.clientY + 5
            left = e.clientX - 2
        }"
    >
        {{ $slot }}
    </div>

    @isset($tooltip)
        <div
            x-show="hover"
            class="fixed z-50"
            style="pointer-events: none; display: none; max-width: 30rem"
            :style="{
                top: top + 'px',
                left: left + 'px',
            }"
        >
            <div
                style="background: rgba(0, 0, 0, .8)"
                class="border text-white rounded-lg py-2 px-3 m-2"
            >
                {{ $tooltip }}
            </div>
        </div>
    @endisset
</div>
