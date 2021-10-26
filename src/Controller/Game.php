<?php

namespace App\Controller;

require __DIR__ . '/../../vendor/autoload.php';

use App\Controller\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Game extends Twig
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function new()
    {
        echo $this->twig->render('nouveaux-jeux.html.twig', [
            'lienRacine'    =>  $_SESSION['lienRacine'],
        ]);
    }

    /**
     * @param $statut
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function terminer($statut): string
    {
         return $this->twig->render('partie-termine.html.twig', [
             "statut"   =>  $statut,
             'lienRacine'    =>  $_SESSION['lienRacine'],
         ]);
     }

    /**
     * @return int
     */
    public function getCoupsRestants(): int
     {
         return $_SESSION['nbEssais']-$_SESSION['essais'];
     }

    /**
     * @return array
     */
    public function getLettreTrouvees(): array
    {
        $tab = [];
         foreach ($_SESSION['mot'] as $lettreMot) {
             if (in_array(strtoupper($lettreMot), $_SESSION['lettreTrouvees']) || in_array($lettreMot, ["'", " "])) {
                 $tab[] = ($lettreMot==" ")?"<br>":$lettreMot;
             } else {
                 $tab[] = "_";
             }
         }
         return $tab;
     }

    /**
     * @return string
     */
    public function getMotProposer(): string
     {
         $motProposer = "";
         foreach ($this->getLettreTrouvees() as $lettre){
             $motProposer .= $lettre;
         }
        return $motProposer;
     }

    public function reinitialisationValeurs():void
     {
         $lienRacine = $_SESSION['lienRacine'];
         session_unset();
         $_SESSION['lettreUtilise'] = [];
         $_SESSION['lettreTrouvees'] = [];
         $_SESSION['essais'] = 0;
         $_SESSION['lienRacine'] = $lienRacine;
     }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function nouveauTour(): string
    {
        return $this->twig->render('jeu.html.twig', [
            'coupsRestants'     =>  $this->getCoupsRestants(),
            'lettresTrouvees'   =>  $this->getLettreTrouvees(),
            'lettres'           =>  $_SESSION['lettres'],
            'lettresUtilisees'  =>  $_SESSION['lettreUtilise'],
            'essais'            =>  $_SESSION['essais'],
            'lienRacine'        =>  $_SESSION['lienRacine'],
            'level'             =>  $_SESSION['level'],
        ]);
    }
}