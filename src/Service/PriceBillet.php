<?php

// src/Service/PriceBillet.php
namespace App\Service;

class PriceBillet
{
    function getPriceTicket( $age, $ticketType, $reduc) {
            if($reduc==true and $age > 12){
                $price = 10;
                    
            }else{
                if($age < 4){
                    $price = 0;
                } elseif($age >= 4 and $age < 12){
                    $price = 8;
                }elseif($age >= 12 and $age < 60){
                    $price = 16;
                }elseif($age >= 60 ){
                    $price = 12;
                }

            }
            
            if ($ticketType == 'demi-journee'){
                $price = $price/2;
            }
            return $price;
        }

        



            
    
}
