# Laravel x Storyblok 101

Welcome to the open-source repository of the seventh Code & Chill with Storyblok episode, __Laravel x Storyblok 101__.

![Code & Chill with Storyblok #7 - Laravel x Storyblok 101](https://a.storyblok.com/f/88751/1940x1160/d069c49cb3/code-chill-laravel-x-storyblok-101-7-website-og.png/m/800x0/)

In the live stream, Roberto from the Storyblok team and one of the Storyblok Ambassadors, Richard, walk you through how to start Laravel and Storyblok from scratch.

- The event landing page is : https://www.storyblok.com/ev/code-chill-with-storyblok-7112023
- The Storyblok Twitch channel: https://www.twitch.tv/storyblok
- Laravel: https://laravel.com/
- Storyblok: https://www.storyblok.com/


## Installing Laravel

### Requirements
To install a new Laravel project from scratch, you need:
- PHP 8.1 (or newer)
- Composer (for installing packages)

### Create a new Laravel project
For creating a new Laravel project using the `composer` command:
```shell
composer create-project laravel/laravel laravel-storyblok-101
cd laravel-storyblok-101
```


## Enabling HTTPS
The Storyblok Visual Editor provides a preview functionality, so you can see the preview of your frontend while you are changing the content. To make it work for Browser security reasons, you must enable HTTPS even if you run your project locally.

With Valet, you can enable HTTPS, in the directory project via:

```shell
valet secure
```

Now you can access your page via https://laravel-storyblok-101.test

If you are using Laravel Herd, you can secure your local sites with TLS: https://herd.laravel.com/docs/1/advanced-usage/securing-sites


## Setting Environment Variables

In the `.env` file, you can set the environment variables in this way, or you can copy them from the `.env.example` file:

```conf
STORYBLOK_ACCESS_TOKEN_PREVIEW=your_preview_access_token
STORYBLOK_ACCESS_TOKEN_PUBLIC=your_public_access_token
STORYBLOK_ACCESS_TOKEN="${STORYBLOK_ACCESS_TOKEN_PREVIEW}"
STORYBLOK_VERSION=draft
STORYBLOK_CACHE_TTL_CV=0
STORYBLOK_CACHE_TTL_STORY=0
```

Now in the code, you can access these environment variables via `config("storyblok.access_token")` and `config("storyblok.version")`. The Laravel Storyblok configuration file is `config/storyblok.php`:
```php
    'access_token' => env('STORYBLOK_ACCESS_TOKEN', ''),
    'version' => env('STORYBLOK_VERSION'),
    'cache_ttl_cv' => env('STORYBLOK_CACHE_TTL_CV', 60),
    'cache_ttl_story' => env('STORYBLOK_CACHE_TTL_STORY', 60),

```

> If you want to create and obtain a new access token to the current space you can read this article: https://www.storyblok.com/faq/retrieve-and-generate-access-tokens
>
>

## OPTIONAL :  Adding some style to the Frontend

The focus here is to understand the integration with Laravel and the APIs provided by Storyblok. To speed up the process of creating a styled frontend, we can use Tailwindcss and daisyUI.

### Installing Tailwindcss and daisyUI

```shell
bun add -d tailwindcss postcss autoprefixer
bunx tailwindcss init -p
bun add -d daisyui@latest
bun add -d @tailwindcss/typography
```

### Configuring Tailwind and daisyUI

In the file `tailwind.config.js,` you need to set the `content` with the files you can use the Tailwindcss classes (the blade files), and in the `plugins` for loading the typography and daisyUI plugin:

```js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/typography'),
        require("daisyui")
    ],
}
```

Then, in the file `resources/css/app.css`, you can load the tailwind plugins:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Launching the web service
If you want the page in the browser to automatically reload when you change the HTML or the CSS, you can run the Vite local web service.
For launching the web service that provides the assets controlled by Vite:

```
bun run dev
```

Remember to check the root URL in the `.env` file:

```
APP_URL=https://laravel-storyblok-101.test/
```

Now you can open your browser at the page https://laravel-storyblok-101.test/.

## Defining the "catchall" route

To start quickly, we can create a "catchall" route. A "catchall" route is a routing rule that matches requests not handled by specific routes, allowing a default method controller to be executed.
The file for defining the web route rules is `routes/web.php`.

```php
Route::any('{catchall?}',
    [StoryblokController::class, 'load']
)->where('catchall', '.*');
```

## Creating the StoryblokController

For creating a controller for managing the catchall rules, we can use the `php artisan make:controller` command:
```shell
php artisan make:controller StoryblokController
```
The file created is `app/Http/Controllers/StoryblokController.php`.
The method to implement is `load()` (according to the route rule):

```php
public function load($catchall = 'home')
{}
```

To explore the code, you can jump into the [StoryblokController.php](app/Http/Controllers/StoryblokController.php) file.

## Loading the content via API using Laravel HTTP Client

For loading the data, because we have to perform an HTTP API Call, we are going to use the HTTP Client provided by Laravel (out-of-the-box solution): https://laravel.com/docs/10.x/http-client

> Laravel provides an expressive, minimal API around the Guzzle HTTP client, allowing you to quickly make outgoing HTTP requests to communicate with other web applications. Laravel's wrapper around Guzzle is focused on its most common use cases and a wonderful developer experience. (Quote: https://laravel.com/docs/10.x/http-client)

Using the HTTP Client lets us understand how the Storyblok Content Delivery API works.

## The blade view

The view loaded by the Storyblok Controller is the `resources/views/storyblok.blade.php` blade file.

```html
<x-layout.base :story="$story" :language="$language">
     <x-storyblok-component :component="Arr::get($story, 'story.content')" :language="$language"/>
 </x-layout.base>
```

We are using the `resources/views/components/layout/base.blade.php` as a layout (`x-layout.base`).

The main view also loads the Storyblok dynamic component via the `x-storyblok-component`.

## The Storyblok Dynamic Component

The Storyblok dynamic component `app/View/Components/StoryblokComponent.php` has the responsibility of loading the proper blade view component (`hero.blade.php` , `teaser.blade.php` etc.) according to the component technical name found in the JSON (`hero`, `teaser`, etc...).

If the blade view component doesn't exist, we can create a default/fallback to be loaded (for example, in this demo project, it is: `resources/views/components/default.blade.php`)

## The view components

We can create the blade components in the `resources/views/components/` folder. The assumption for this demo project is to create a new blade file for each Storyblok component. The Stroyblok component name (for example, `hero`) has a related blade file (`hero.blade.php`). In the blade file, we can access to:

- `$component` array with the content of the component
- `$editableAttributes` for making the component editable
- `$language` for retrieving the language code.

An example:

```html
<div {!! $editableAttributes !!}>
<h2>{{ $component["title"] }}</h2>
<div>LANGUAGE: {{ $language }}</div>
<pre>{{ print_r($component, true) }}</pre>
</div>
```



## The Storyblok Bridge
To allow the preview experience in the Storyblok Visual Editor, add the Stroyblok Bridge in your HTML. To add the Stroyblok Bridge, you have to:

- Add the storyblok bridge (using the JS provided by Storyblok Bridge
- Create the instance and listen to the event 'change'. The event `change` is triggered by the Editorial Editors when they click the button `Save` in the Storyblok UI.
- Make the component editable. In other words, allow the content editors to click on the frontend shown in the preview and jump directly into the related Stroyblok component, ready to edit it.

More info about:

- The Visual Editor: https://www.storyblok.com/docs/guide/essentials/visual-editor
- the Storyblok Bridge: https://www.storyblok.com/docs/Guides/storyblok-latest-js

### Using the Storyblok Bridge

In the `resources/views/components/layout/base.blade.php` file, you can add the Storyblok Bridge.

```HTML
<script type="text/javascript" src="//app.storyblok.com/f/storyblok-v2-latest.js"></script>
<script type="text/javascript">
    const storyblokInstance = new StoryblokBridge()
    storyblokInstance.on('change', () => {
        window.location.reload(true);
    })
</script>
```

With the JSON provided by the Storyblok Content Delivery API, for each component, you have an additional attribute `_editable` . This attribute contains an HTML comment with some helpful information for the Storyblok bridge to enable the editable features on the preview front. You can quickly wrap your component with this HTML (to allow the Storyblok bridge to understand where the components start), or you can extract the information from the editable field and add two attributes to the HTML component tag. The two new attributes are `data-blok-c` and `data-blok-uid`. 

In the `app/View/Components/StoryblokComponent.php` file, look at the `extractEditableInfo()` function for retrieving the proper information for the `_editable` field.

In the Blade component, you can use the `{!! $editableAttributes !!}` in the HTML tag of the component. For example: `resources/views/components/hero.blade.php`.





