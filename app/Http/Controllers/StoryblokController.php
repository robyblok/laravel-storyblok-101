<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StoryblokController extends Controller
{
    public function load(Request $request, $catchall = 'home')
    {
        $cacheTtlStory = config('storyblok.cache_ttl_story', 60);
        //dd($cacheTtlStory);
        $return = Cache::remember($catchall, $cacheTtlStory, function () use ($catchall) {
            return Story::load($catchall);
        });

        //dd($return);
        return view('storyblok')
            ->with('catchall', $catchall)
            ->with('story', $return);
    }
}
