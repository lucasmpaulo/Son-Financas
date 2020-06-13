<?php

function dateParse($date)
{
    // Recebe -> DD/MM/YYYY | transformar -> YYYY/MM/DD
    // O Explode vai transformar em 3 arrays separados -> [DD, MM, YYYY]
    $dateArray = explode('/', $date); 
    $dateArray = array_reverse($dateArray); // Vai inverter -> [YYYY, MM, DD]
    // Vai fazer o oposto de Explode e vai juntar os arrays em apenas 1 -> yyyy-mm-dd
    return implode('-', $dateArray); 
}

function numberParse($number)
{
    // 1.000,50 -> 1000.50
    $newNumber = str_replace('.', '', $number);
    $newNumber = str_replace(',', '.', $newNumber);
    return $newNumber;
}
