<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
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

    public function load(Request $request, $catchall = 'home')
    {
        ['lang' => $lang, 'path' => $path] = $this->getLangSlug($catchall);
        $path = $path == '' ? 'home' : $path;
        $cacheTtlStory = config('storyblok.cache_ttl_story', 60);
        $return = Cache::remember($catchall, $cacheTtlStory, function () use ($path, $lang) {
            return Story::load($path, $lang);
        });
        if (count($return) === 0) {
            abort(404);
        }

        return view('storyblok')
            ->with('catchall', $catchall)
            ->with('story', $return);
    }
}
