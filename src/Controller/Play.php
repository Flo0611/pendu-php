<?php

namespace App\Controller;

require __DIR__ . '/../../vendor/autoload.php';

use App\Controller\Game;

class Play
{
    private $partie;

    public function __construct()
    {
        $this->partie = new Game();
    }

    /**
     * @param $datas
     */
    public function new($datas)
     {
         $motSansAccents = strtolower($this->removeAccent($datas['mot']));
         if (isset($_POST['bot'])){
             $motSansAccents = strtolower($this->playWithBot());
         }
         $_SESSION['motEntier'] = $motSansAccents;
         $_SESSION['mot'] = str_split($motSansAccents);
         $_SESSION['lettres'] = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",];
         $_SESSION['level'] = $datas['level'];
         $_SESSION['nbEssais'] = ($datas['level'] == 'easy')?11:7;
     }

    /**
     * @param $lettre
     * @return string|null
     */
    public function jeu($lettre)
     {
         if (in_array(strtolower($lettre), $_SESSION['mot'])){
             $_SESSION['lettreTrouvees'][] = $lettre;
             if(str_replace("<br>", " ", $this->partie->getMotProposer()) == $_SESSION['motEntier']){
                 return $this->partie->terminer("Gagner");
             }
         }else{
             if ($_SESSION['essais'] >= ($_SESSION['nbEssais']-1)){
                 return $this->partie->terminer("Perdu");
             }
             $_SESSION['essais']++;
         }
         $_SESSION['lettreUtilise'][] = $lettre;

         return null;
     }

     public function playWithBot()
     {
         $tabMot = [
            "Ado", "Bis", "Cor", "Fac", "Fla", "Gaz", "Gît", "Glu", "Gos", "Goy",
             "Gue", "Hip", "Hop", "Jet", "Kru", "Mai", "Rut", "Ski", "Sot", "Tic",
             "Ton", "Tua", "Val", "Zup", "Zut", "Ardu", "Bits", "Buna",
             "Cire", "Clip", "Corse", "Dock", "Fado", "Fées", "Gang", "Kaki", "Regs",
             "Rhum", "Taie", "Taux", "Thym", "Topa", "Tordu", "Toto", "Unes", "Wyatt",
             "Yogi", "Accès", "Alfas", "Aloès", "Awalé", "Banjo", "Boeuf", "Chéra",
             "Escot", "Guipa", "Honni", "Houez", "Igloo", "Iodas", "Moult", "Mucha",
             "Muscs", "Nicol", "Seaux", "Seuil", "Shunt", "Smalt", "Toqua", "Tyran",
            "Vêtît", "Volve", "Acajou", "Alephs", "Azimut", "Basson", "Burine", "Caïman",
             "Cercle", "Coccyx", "Cornée", "Faucon", "Gospel", "Guenon", "Hormis", "Menthe",
             "Mulard", "Notais", "Nouais", "Paginé", "Pontil", "Sabord", "Séisme",
            "Séisme", "Whisky", "Yankee", "Zipper",
         ];
         return $tabMot[array_rand($tabMot)];
     }

     public function removeAccent($mot)
     {
         $search  = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
         $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y');
         return str_replace($search, $replace, $mot);
     }
}