@props([
    'dynamicHeroClass' =>
        $component['layout'] === 'constrained'
        ? 'container mx-auto my-6 rounded-[5px]'
        : '',

])
<div class="hero min-h-screen" style="background-image: url({{ Arr::get($component, 'background_image.filename') }}/m/800x0);">
    <div class="hero-overlay bg-opacity-60"></div>
    <div class="hero-content text-center text-neutral-content">
        <div class="max-w-md">
            <h1 class="mb-5 text-5xl font-bold">{{ $component['headline'] }}</h1>

            <p class="mb-5">{{ $component['subheadline'] }}</p>

            <a href="#start"  class="btn btn-primary">Get Started</a>
        </div>
    </div>
</div>
<div id="start"></div>
