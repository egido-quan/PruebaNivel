<?php

class Marcador {

    private Jugador $jugador1, $jugador2;
    public static $scoreTenis = ["0", "15", "30", "40", "ventaja", "deuce", "ventaja"];
    private $resultadoFinal = [];

    private int $numSets;
    private Jugador $ganador;

    public function __construct(Jugador $jugador1, Jugador $jugador2, int $numSets) {
        $this->jugador1 = $jugador1;
        $this->jugador2 = $jugador2;
        $this->numSets = $numSets;
        self::inicioPartido();
    }
    public function inicioPartido() {
        $nombre1 = $this->jugador1->getNombre();
        $nombre2 = $this->jugador2->getNombre();
        $sets = $this->numSets;
        echo "<h3>$nombre1  vs  $nombre2<br>
            Partido a $sets sets<br>
            <br>Comienza el partido</h3>" . PHP_EOL;
    }

    public function puntoPara(Jugador $jugador) {
        $jugador->sumaPunto();
        echo PHP_EOL . "<br>Punto para " . $jugador->getNombre() . "<br>" . PHP_EOL;
        echo self::actualizarMarcador();
    }

    public function actualizarMarcador(): string {
       $puntosJug1 = $this->jugador1->getPuntos();
       $puntosJug2 = $this->jugador2->getPuntos();

    //Lógica que decide si el juego sigue o se ha acabado
        if ($puntosJug1 > 3 && ($puntosJug1 - $puntosJug2) >= 2) {
            self::sumarJuego($this->jugador1);
        } elseif ($puntosJug2 > 3 && ($puntosJug2 - $puntosJug1) >= 2) {
            self::sumarJuego($this->jugador2);
        } elseif ($puntosJug1 >= 3 && $puntosJug2 >= 3 && ($puntosJug1 == $puntosJug2)) {
                $this->jugador1->setPuntos(5);
                $this->jugador2->setPuntos(5);
        }
        return self::mostrarResultado();
    }
    

    private function sumarJuego(Jugador $jugador) {
        $jugador->sumaJuego();
        $jug = $jugador->getNombre();
        echo "<h3>Juego para $jug</h3>";
        $this->jugador1->resetPuntos();
        $this->jugador2->resetPuntos();

        //Lógica que decide si el set sigue o se ha acabado
        if ($this->jugador1->getJuegos() >= 6 && ($this->jugador1->getJuegos() - $this->jugador2->getJuegos() >=2)) {
            self::sumarSet($this->jugador1);
        }
        if ($this->jugador2->getJuegos() >= 6 && ($this->jugador2->getJuegos() - $this->jugador1->getJuegos() >=2)) {
            self::sumarSet($this->jugador2);
        }
    }

    private function sumarSet(Jugador $jugador) {
        $jugador->sumaSet();
        $this->resultadoFinal[] = $this->jugador1->getJuegos();
        $this->resultadoFinal[] = $this->jugador2->getJuegos();
        $jug = $jugador->getNombre();
        echo "<h2>Set para $jug</h2>";
        $this->jugador1->resetPuntos();
        $this->jugador1->resetJuegos();
        $this->jugador2->resetPuntos();
        $this->jugador2->resetJuegos();
        if (self::esFinDePartido()) {
            $this->ganador = $jugador;
            echo "<h1>Partido para " . $jugador->getNombre() . "</h1>";
            } 
        }

    public function esFinDePartido() {
        //Gana el partido quien gane 2 sets si juegan a 3 o 3 sets si juegan a 5 
        return ($this->jugador1->getSets() >= (round($this->numSets / 2)) || $this->jugador2->getSets() >= (round($this->numSets / 2))) ? true : false;
    }
    public function estadisticas() {
        self::mostrarResultadoFinal();
        self::mostrarPuntosTotales();
        self::setDeMayorContundencia();
    }

    //Muestara el resultado tras cada punto disputado
    private function mostrarResultado() {
        return $this->jugador1->miMarcador() . "<br>" . PHP_EOL . $this->jugador2->miMarcador() . "<br>" . PHP_EOL;
    }

    public function mostrarResultadoFinal() {
        echo "<h1>Resultado final: </h1>";
        echo "<h1>Ganador: " . $this->ganador->getNombre() . "</h1>";
        for ($i = 0; $i < count($this->resultadoFinal); $i += 2) {
            echo "<h3>" . $this->resultadoFinal[$i] . " - " . $this->resultadoFinal[$i+1] . "</h3>";
        }
    }

    private function mostrarPuntosTotales() {
        echo "<h3> Puntos totales " . $this->jugador1->getNombre() . ": " . $this->jugador1->getPuntosAcumulados() . "</h3>";
        echo "<h3> Puntos totales " . $this->jugador2->getNombre() . ": " . $this->jugador2->getPuntosAcumulados() . "</h3>";
    }

    private function setDeMayorContundencia() {
        for ($i = 0; $i < count($this->resultadoFinal); $i += 2) {
            $difSets[] = abs($this->resultadoFinal[$i] - $this->resultadoFinal[$i+1]);
        }
        $max = 0;
        $pos = 0;
        for ($i = 0; $i < count($difSets); $i++) {
            if ($difSets[$i] > $max) {
                $max = $difSets[$i];
                $pos = $i + 1;
            }
        }
        echo "<h3>Set de mayor contundencia: $pos</h3>";
        echo "<h3>Mayor diferencia de juegos: $max</h3>";
    }


}
