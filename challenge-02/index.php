<?php

function noIterate($strArr) 
{
    $N = $strArr[0];
    $K = $strArr[1];

    //obtenemos un array con los caracteres de k y contamos cuantos necesitamos de cada uno
    $need = array_count_values(str_split($K));
    $have = [];
    $required = count($need);
    $found = 0;
    $l = 0; //puntero izquierdo
    $minLen = 51;
    $minSub = "";

    //r es el puntero derecho
    for ($r = 0; $r < strlen($N); $r++) 
    {
        $char = $N[$r];
        if (isset($need[$char])) 
        {
            $have[$char] = ($have[$char] ?? 0) + 1;
            //cuando tenemos la cantidad necesaria de un caracter aumentamos el found
            if ($have[$char] == $need[$char]) 
            {
                $found++;
            }
        }

        //si ya tenemos la cantidad necesaria de todos los caracteres
        //intentamos reducir la ventana que contiene todos los caracteres
        while ($found == $required) 
        {
            //verificamos si la ventana actual es la mas pequeña
            //si es asi, actualizamos el minimo
            if ($r - $l + 1 < $minLen) 
            {
                $minLen = $r - $l + 1;
                $minSub = substr($N, $l, $minLen);
            }
            //si el caracter que descartamos es necesario, lo eliminamos del conteo
            //y saldremos del while en caso ya no tengamos los necesarios
            $leftChar = $N[$l];
            if (isset($need[$leftChar])) 
            {
                $have[$leftChar]--;
                if ($have[$leftChar] < $need[$leftChar]) 
                {
                    $found--;
                }
            }
            $l++;
        }
    }
    return $minSub;
}

echo noIterate(array("ahffaksfajeeubsne", "jefaa")) . PHP_EOL;

echo noIterate(array("aaffhkksemckelloe", "fhea")) . PHP_EOL;

echo noIterate(array("a", "a")) . PHP_EOL;

echo noIterate(array("a", "b")) . PHP_EOL;

echo noIterate(array("a", "ab")) . PHP_EOL;
