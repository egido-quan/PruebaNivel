<?php

include "Jugador.php";
include "Marcador.php";

//Función que devuelve la probablididad (%) de que el jugador 1 gane cada punto según la diferencia de ranking
function probPuntoJug1($jugador1, $jugador2) {
    $rankDiff = $jugador2->getRankingAtp() - $jugador1->getRankingAtp();
    return match(true) {
        ($rankDiff >= 100) => 90,
        (($rankDiff < 100) && ($rankDiff >= 50)) => 80,
        (($rankDiff < 50) && ($rankDiff >= 10)) => 60,
        (($rankDiff < 10) && ($rankDiff >= -10)) => 50,
        (($rankDiff < -10) && ($rankDiff >= -50)) => 40,
        (($rankDiff < -50) && ($rankDiff >= -100)) => 20,
        ($rankDiff < -100) => 10
    };
}

//Función que da el ganador de cada punto ponderando la aleatoriedad con la probabilidad de ganar el punto
function jugarPunto(Jugador $jugador1, Jugador $jugador2, float $probPuntoJug1) {
    return (rand(1, 100) < $probPuntoJug1) ? $jugador1 : $jugador2;
}

//Declaración de objetos: los dos jugadores y el marcador
$numsets = (rand(0,1) == 0) ? 3: 5;
$alcaraz = new Jugador("Carlos Alcaraz", 3);
$sinner = new Jugador("Jannik sinner", 1);
$marcador = new Marcador($alcaraz, $sinner, $numsets);

//Probabilidad de que Alcaraz gane un punto a Sinner
$probPuntoJug1 = probPuntoJug1($alcaraz, $sinner);

//Bucle que va generanado puntos y envía el ganador de cada punto al marcador hasta que se acaba el partido
while (! $marcador->esFinDePartido()) {
    $marcador->puntoPara(jugarPunto($alcaraz, $sinner, $probPuntoJug1));
}

//Mostramos las estadísticas del partido
$marcador->estadisticas();








