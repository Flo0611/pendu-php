<?php

require __DIR__ . '/vendor/autoload.php';

use App\Controller\Game;

session_start();

class Index
{
    private $game;
    public function __construct()
    {
        $this->game = new Game();
        $this->newGame();
    }

    public function newGame()
    {
        $this->saveURI();
        $this->game->reinitialisationValeurs();
        $this->game->new();
    }

    public function saveURI()
    {
        $lienRacine = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $_SESSION['lienRacine'] = $lienRacine;
    }
}

new Index();