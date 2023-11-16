<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Story
{
    public static function list(array $identifiers)
    {
        $list = [];

    }

    public static function load(string $identifier)
    {
        $start = hrtime(true);

        $cv = Cache::get('cv', 'undefined');

        $apiResponse = Http::withUrlParameters([
            'base_url' => 'https://api.storyblok.com/v2/cdn/',
            'endpoint' => 'stories',
            'slug' => $identifier,
        ])->withQueryParameters(
            [
                'token' => config('storyblok.access_token'),
                'version' => config('stroyblok.version'),
                'cv' => $cv,
                'resolve_relations' => 'popular-articles.articles',
            ]
        )->get('{+base_url}/{endpoint}/{slug}');

        $return = $apiResponse->json();

        $end = hrtime(true);
        $eta = $end - $start;
        //dd($eta/1e+6);
        $return['responsetime'] = $eta / 1e+6;

        Cache::put('cv', $return['cv']);
        foreach ($return['rels'] as $key => $value) {
            if (is_array($value)) {
                Cache::put($value['uuid'], $value);
            }
        }
        if (count($return['rels']) > 0) {

        }

        return $return;
    }
}
