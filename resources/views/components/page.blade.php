<main >
    @foreach($component['body'] as $key => $value)
        <x-storyblok-component :component="$value" />
    @endforeach
</main>
