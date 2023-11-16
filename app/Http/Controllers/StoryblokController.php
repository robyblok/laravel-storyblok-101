<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryblokController extends Controller
{
    public function load(Request $request, $catchall = 'home')
    {
        $return = Story::load($catchall);

        //dd($return);
        return view('storyblok')
            ->with('catchall', $catchall)
            ->with('story', $return);
    }
}
