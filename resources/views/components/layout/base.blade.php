<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width" />
    <link rel="icon" type="image/x-icon" href="/favicon.ico" />
    <title>{{ Arr::get($story, "story.name", "Laravel x Storyblok 101") }}</title>
    @vite('resources/css/app.css')
</head>
<body class="mx-auto antialiased">
    <x-header :story="$story" :language="$language" />
    {{ $slot }}
    <script type="text/javascript" src="//app.storyblok.com/f/storyblok-v2-latest.js"></script>
    <script type="text/javascript">
        const storyblokInstance = new StoryblokBridge({
            preventClicks: true,
        })
        storyblokInstance.on('change', () => {
            window.location.reload(true);
        })

    </script>

</body>
</html>
