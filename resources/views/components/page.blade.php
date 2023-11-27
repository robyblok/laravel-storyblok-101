<main {!! $editableAttributes !!} class="w-full place-items-center">

    @foreach($component['body'] as $key => $value)
        <x-storyblok-component :component="$value" />
    @endforeach
</main>
