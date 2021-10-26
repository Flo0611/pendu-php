<?php

namespace App\Controller;

require __DIR__ . '/../../vendor/autoload.php';

if (!isset($_SESSION)) {
    session_start();
}

use App\Controller\Play;
use App\Controller\Game;
use App\Controller\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Routeur extends Twig
{
    private $jeux;
    private $partie;

    /**
     * Routeur constructor.
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function __construct()
    {
        Parent::__construct();
        $this->jeux = new Play();
        $this->partie = new Game();
        $this->route($_GET['action']);
    }


    /**
     * @param $action
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function route($action)
    {
        switch ($action) {
            case 'nouvelle-partie':
                $this->partie->reinitialisationValeurs();
                //On créé une nouvelle partie
                $this->jeux->new($_POST);
                //Test si l'utilisateur a rentré un mot
                $return = $this->twig->render('nouveaux-jeux.html.twig', [
                    "error"         => "Mot non défini, veuillez saisir un mot.",
                    'lienRacine'    =>  $_SESSION['lienRacine'],
                ]);
                if(isset($_SESSION['motEntier']) && $_SESSION['motEntier'] != ""){
                    $return = $this->partie->nouveauTour();
                }
                //On redirige l'utilisateur au bon endroit
                echo $return;
                break;
            case 'jeu':
                $return = $this->jeux->jeu($_GET['lettre']);
                if ($return === null){
                    $return = $this->partie->nouveauTour();
                }
                echo $return;
                break;
            case 'new-partie':
                $this->partie->new();
                break;
            default:
                break;
        }
    }
}

new Routeur();