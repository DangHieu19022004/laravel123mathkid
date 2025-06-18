<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

class GradeController extends Controller
{
    public function index(string $grade = 'lop4')
    {
        $configGames = config("group-game.$grade", []);
        if (empty($configGames)) {
            abort(404);
        }

        $seoTitle       = $configGames['title'];
        $seoDescription = $configGames['description'];

        SEOMeta::setTitle($seoTitle, false);
        SEOMeta::setDescription($seoDescription);
        TwitterCard::setTitle($seoTitle);
        OpenGraph::setTitle($seoTitle);

        SEOMeta::setRobots('all');

        return view('games.lop4.index', compact('configGames'));
    }
}
