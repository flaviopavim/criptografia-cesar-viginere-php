<?php

function cesar($string,$nivel) {
    /*
     * 'Cifra de César'
     * Código criado por: Flávio Pavim
     * 
     * Essa função é uma adaptação básica da cifra de César
     * Funciona apenas com os caracteres da matriz a-z, A-z, 0-9
     * 
     * Dica: utilize base64 ou algum tipo de codificação que tenha os mesmos caracteres dessa cifra
     * dificultando cada vez mais a decodificação
     */
    
    $m[]='ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $m[]='abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz';
    $m[]='01234567890123456789';
    $r='';
    for($a=0;$a<2;$a++) { //vai passar pelo loop 3 vezes pra ler cada uma das matrizes '$m'
        if (!empty($r)) { //se não for a primeira, transforma o retorno em string e limpa o retorno pra gerar um novo
            $string=$r;
            $r='';
        }
        for($i=0;$i<strlen($string);$i++) { //percorre um por um dos caracteres
            $posm=strpos($m[$a],$string[$i]); //posição do caracter na matriz $m
            if (is_numeric($posm)) { //se existir e for numérico
                $s=$posm+$nivel;
                if ($s<=0) { //se for negativo
                    $n=26; //letras do alfabeto das 2 primeiras matrizes
                    if ($a==2) {
                        $n=10; //terceira matriz. apenas 10 números
                    }
                    $s=$s+$n; //soma 26
                }
                $r.=$m[$a][$s]; //altera o caracter
            } else {
                $r.=$string[$i]; //se não houver nada na matriz $m, coloca o mesmo caracter da string
            }
        }
    }
    return $r;
}

function decesar($string,$nivel) {
    /*
     * Função reversa ao cesar - Descriptografia
     */
    return cesar($string,-$nivel);
}

function charval($c) {
    /*
     * Função pra dar um valor à cada letra usada na chave
     */
    if (is_numeric($c)) { //caso for número
        return $c;
    }
    $m='abcdefghijklmnopqrstuvwxyz';
    $s=strpos($m,strtolower($c));
    if (is_numeric($s)) {
        return $s+1;
    }
    return 0;
}

function viginere($string,$key='123',$reverse=false) {
    /*
     * Cifra de Viginere
     */
    $r='';
//    $key=base64_encode($key); //caso quiser codar a chave
    $lk=strlen($key);
    for($i=0;$i<strlen($string);$i++) {
        $iactual=$i;
        while($iactual>=$lk) {
            $iactual=$iactual-$lk;
        }
        if ($reverse==true) {
            $r.=cesar($string[$i],-charval($key[$iactual]));
        } else {
            $r.=cesar($string[$i],charval($key[$iactual]));
        }
    }
    return $r;
}

function deviginere($string,$key='123') {
    /*
     * Cifra de Viginere
     */
    return viginere($string,$key,true);
}