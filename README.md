# Laravel x Storyblok 101

## Installing Laravel

### Requirements
To install a new Laravel project from scratch you need:
- PHP 8.1 (or newer)
- Composer (for installing packages)

### Create a new Laravel project
For creating a new Laravel project using the `composer` command:
```shell
composer create-project laravel/laravel laravel-storyblok-101
cd laravel-storyblok-101
```


## Enabling HTTPS
With Valet, you can enable HTTPS, in the directory project via:

```shell
valet secure
```

Now you can access your page via https://laravel-storyblok-101.test



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


## Defining the "catchall" route
Just to start quickly, we can create a "catchall" route. A "catchall" route is a routing rule that matches requests not handled by specific routes, allowing a default method controller to be executed.
The file for defining the web route rules is `routes/web.php`.

```php
Route::any('{catchall?}',
    [StoryblokController::class, 'load']
)->where('catchall', '.*');
```


### Creating the StoryblokController

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

### Installing Tailwindcss and daisyUI

```shell
bun add -d tailwindcss postcss autoprefixer
bunx tailwindcss init -p
bun add -d daisyui@latest
bun add -d @tailwindcss/typography
```

### Configuring Tailwind and daisyUI

In the file `tailwind.config.js` you need to set the `content` with the files you can use the Tailwindcss classes (the blade files), and in the `plugins` for loading the typography and daisyui plugin:

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

Then in the file `resources/css/app.css` you can load the tailwind plugins:

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```

### Launching the web service
For launching the web service that provides the assets controlled by vite:

```
bun run dev
```

Remember to check the root URL in the `.env` file:

```
APP_URL=https://laravel-storyblok-101.test/
```
