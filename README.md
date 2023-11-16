# Laravel x Storyblok 101

## Installing Laravel

### Requirements
To install a new Laravel project from scratch you need:
- PHP 8.1 (or newer)
- Composer (for installing packages)

### Create a new Laravel project
For creating a new Laravel project using the `composer` cmmand:
```shell
composer create-project laravel/laravel laravel-storyblok-101
cd laravel-storyblok-101
```


## Enabling HTTPS
With Valet, you can enable HTTPS, in the directory project via:

```shell
valet secure
```

Now you can access your page via https://laravel-storyblok-101



## Setting Environment Variables

In the `.env` file, you can set the environment variables in this way, or you can copy them from the `.env.example` file:

```conf
STORYBLOK_ACCESS_TOKEN_PREVIEW=your_preview_access_token
STORYBLOK_ACCESS_TOKEN_PUBLIC=your_public_access_token
STORYBLOK_ACCESS_TOKEN="${STORYBLOK_ACCESS_TOKEN_PREVIEW}"
STORYBLOK_VERSION=draft
```

Now in the code, you can access these environment variables via `config("storyblok.access_token")` and `config("storyblok.version")`. The Laravel Storyblok configuration file is `config/stroyblok.php`.


## Catch all route

```php
Route::any('{catchall?}',
    [StoryblokController::class, 'load']
)->where('catchall', '.*');
```


### Creating the StoryblokController

```shell
php artisan make:controller StoryblokController
```

### Installing Tailwindcss and daisyUI

```shell
bun add -d tailwindcss postcss autoprefixer
bunx tailwindcss init -p
bun add -d daisyui@latest
bun add -d @tailwindcss/typography
```
