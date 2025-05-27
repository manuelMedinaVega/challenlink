<?php

function findPoint($strArr) 
{
    // obtener en un array los elementos de cada string
    $arr1 = explode(',', $strArr[0]);
    $arr2 = explode(',', $strArr[1]);
    
    // limpiar los espacios en cada elemento del array
    $arr1 = array_map('trim', $arr1);
    $arr2 = array_map('trim', $arr2);
    
    // obtener los elementos que se intersectan
    $intersect = array_intersect($arr1, $arr2);
    
    // si no hay intersección, retornar 'false'
    if (empty($intersect)) return 'false';
    
    // ordenamos los elementos de la intersección
    sort($intersect);

    //retornamos un string separado por comas con los elementos del array
    return implode(',', $intersect);
}

echo findPoint(array("1, 3, 4, 7, 13", "1, 2, 4, 13, 15")) . PHP_EOL;

echo findPoint(array("1, 3, 9, 10, 17, 18", "1, 4, 9, 10")) . PHP_EOL;

echo findPoint(array("1, 2, 3", "4, 5, 6")) . PHP_EOL;

echo findPoint(array("", "")) . PHP_EOL;

echo findPoint(array("", "1, 2")) . PHP_EOL;

