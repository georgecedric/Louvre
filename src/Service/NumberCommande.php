<?php

// src/Service/NumberCommande.php
namespace App\Service;

class NumberCommande
{
    function getRandom($car) {
        $string = "";
        $chaine = "abcdefghijklmnpqrstuvwxy0123456789";
        srand((double)microtime()*1000000);
        for($i=0; $i<$car; $i++) {
        $string .= $chaine [rand()%strlen($chaine  )];
        }
        return $string;
        }
        
}