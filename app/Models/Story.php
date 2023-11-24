<?php

namespace App\Models;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class Story
{
    public static function list(array $identifiers)
    {
        $list = [];

    }

    /**
     * @param  string  $identifier the slug or id of the Story
     * @param  string  $lang the lang (optional, if empty, the dfault language is loaded)
     * @param  string  $resolveRelations (optional a string with the resolved relations)
     * @return mixed
     *
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws Exception
     */
    public static function load(string $identifier, $lang = '', $resolveRelations = '')
    {
        $start = hrtime(true);

        $cacheTtlCv = config('storyblok.cache_cv_ttl', 60);
        $cv = $cacheTtlCv === 0 ? 'undefined' : Cache::get('cv', 'undefined');

        $apiResponse = Http::withUrlParameters([
            'base_url' => 'https://api.storyblok.com/v2/cdn/',
            'endpoint' => 'stories',
            'slug' => $identifier,

        ])->withQueryParameters(
            [
                'token' => config('storyblok.access_token'),
                'version' => config('storyblok.version'),
                'cv' => $cv,
                'resolve_relations' => $resolveRelations,
                'language' => $lang,
            ]
        )->get('{+base_url}/{endpoint}/{slug}');
        // GET https://api.storyblok.com/v2/cdn/stories/home
        // ?token=ask9soUkv02QqbZgmZdeDAtt&version=draft

        $return = [];
        if ($apiResponse->ok()) {
            $return = $apiResponse->json();
            $end = hrtime(true);
            $eta = $end - $start;
            $return['responsetime'] = $eta / 1e+6;

            Cache::put('cv', $return['cv'], $cacheTtlCv);
            foreach ($return['rels'] as $key => $value) {
                if (is_array($value)) {
                    Cache::put($value['uuid'], $value);
                }
            }
        }

        return $return;
    }
}
