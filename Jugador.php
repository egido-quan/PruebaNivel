<?php

class Jugador {

    private string $nombre;
    private int $rankingAtp;
    private int $puntos, $puntosAcumulados, $juegos, $sets;


    public function __construct(string $nombre, int $rankingAtp) {
        $this->nombre = $nombre;
        $this->rankingAtp = $rankingAtp;
        $this->puntos = 0;
        $this->juegos = 0;
        $this->sets = 0;
        $this->puntosAcumulados = 0;
    }

    public function getNombre(): string {
        return $this->nombre;
    }
    public function getRankingAtp(): string {
        return $this->rankingAtp;
    }
    public function getPuntos() {
            return $this->puntos;
    }
    public function getPuntosAcumulados() {
        return $this->puntosAcumulados;
    }
    public function getJuegos() {
        return $this->juegos;
    }   
    public function getSets() {
        return $this->sets;
    }

    public function setPuntos($puntos) {
        $this->puntos = $puntos;
    }

    public function sumaPunto() {
        $this->puntos += 1;
        $this->puntosAcumulados += 1;
    }

    public function resetPuntos(): void {
        $this->puntos = 0;
    }

    public function sumaJuego() {
            $this->juegos += 1;
    }   
    
    public function resetJuegos(): void {
        $this->juegos = 0;
    }

    public function sumaSet() {
        $this->sets += 1;
        }

    public function miMarcador()  {
        return $this->nombre . " - Puntos: " . Marcador::$scoreTenis[$this->puntos] . " - Juegos: $this->juegos" . " - Sets: $this->sets";
    }

}