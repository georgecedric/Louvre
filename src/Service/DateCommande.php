<?php

// src/Service/DateCommande.php
namespace App\Service;

class DateCommande
{
    function getBlocDate($datetime1, $ticketType) {
        $toolate = NULL;
        $datetoday = new \Datetime() ;
        $datetoday->setTime(00, 00);

        if ($datetime1 == $datetoday){
            $datetime1 = new \Datetime() ;
        }

        $datenow = new \Datetime() ;
        $datenow->setTime(15, 30);
        $endoftheday = new \Datetime() ;
        $endoftheday->setTime(23, 59);
        $datehalfday = new \Datetime() ;
        $datehalfday->setTime(12, 00);

        if ( $endoftheday > $datetime1 and $datetime1 > $datenow){
            
                $toolate = "toolate";

        } elseif ($endoftheday > $datetime1 and $datetime1 > $datehalfday and $ticketType == 'journée'){
                $toolate = "troptard";
        }
     return $toolate;   
    }
}
