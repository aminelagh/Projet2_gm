<?php
/*
Helper pour le Vendeur
*/


// convert HT to TTC
if (!function_exists('getTTC')) {
    function getTTC($prix_HT)
    {
        return ($prix_HT + $prix_HT * 0.2);
    }
}

// apply promotion
if (!function_exists('getPrixTaux')) {
    function getPrixTaux($prix, $taux)
    {
        return ($prix - $prix * $taux / 100);
    }
}

