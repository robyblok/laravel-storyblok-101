
<div {!! $editableAttributes !!} class="w-full">
    <div class="text-center bg-white bg-opacity-70 px-2 pt-40 lg:px-10">
        <h2 class="font-title relative z-[2] mx-auto text-[clamp(2rem,6vw,4.5rem)] font-black leading-none">
            <span style="opacity:1">{{ $component["headline"] }}</span> <br />

        </h2>
        <p class="text-base-content/90 font-title relative z-[2] py-4 font-light md:text-3xl">
            {{ Arr::get($component, "subheadline", "") }}
        </p>
        <div class="h-10" />

    </div>

</div>
