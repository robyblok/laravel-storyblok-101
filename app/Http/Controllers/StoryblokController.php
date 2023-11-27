<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Support\Facades\Cache;

class StoryblokController extends Controller
{
    private $availableLanguages = ['es'];

    private function getLangSlug($path = '')
    {
        $returnLang = '';
        $returnPath = $path;

        $parts = explode('/', $path);
        if (count($parts) > 0) {
            if (in_array($parts[0], $this->availableLanguages)) {
                $returnLang = $parts[0];
                $returnPath = implode(array_slice($parts, 1));
            }
        }

        return [
            'lang' => $returnLang,
            'path' => $returnPath,
        ];
    }

    public function load($catchall = 'home')
    {
        /*
        URL stucture: /<lang>/<path>
        where lang is optional (no lang == default lang)
        where path can be "nested" /page/some/other
        URL path examples:
        1) /about (default language and "about" slug)
        2) /page/some (default language and "page/some" slug)
        3) /it/about ("it" language and "about" slug)
        4) /it/page/some ("it" language and "page/some" slug)
        */

        ['lang' => $lang, 'path' => $path] = $this->getLangSlug($catchall);
        $path = $path == '' ? 'home' : $path;
        $cacheTtlStory = config('storyblok.cache_ttl_story', 60);
        $return = Cache::remember($catchall, $cacheTtlStory, function () use ($path, $lang) {
            return Story::load($path, $lang, 'popular-articles.articles');
        });
        if (count($return) === 0) {
            abort(404);
        }
        /**
         * $return is a JSON with keys: story, cv, rels, links, responsetime.
         */
        return view('storyblok')
            ->with('catchall', $catchall)
            ->with('story', $return)
            ->with('language', $lang);
    }
}
