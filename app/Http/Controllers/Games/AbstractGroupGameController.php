<?php

namespace App\Http\Controllers\Games;

use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;

abstract class AbstractGroupGameController
{
    protected string $group;

    protected string $view = 'games.lop4.game_list';

    public function __construct()
    {
        if (empty($this->group)) {
            throw new \RuntimeException('Property $group must be declared in class '.static::class);
        }
    }

    public function index()
    {
        $configs = config('group-game.lop4.group-game.'.$this->group);

        $title        = $configs['title'];
        $description  = $configs['description'];
        $listInfoGame = $configs['games'];

        SEOMeta::setTitle($title, false);
        SEOMeta::setDescription($description);
        TwitterCard::setTitle($title);
        OpenGraph::setTitle($title);

        SEOMeta::setRobots('all');

        return view($this->view, compact('title', 'description', 'listInfoGame'));
    }
}
