<?php

namespace App\Http\Services;

use Illuminate\Support\Str;

class EncriptacionService
{
    private int $numeroCaracteres;

    public function __construct()
    {
        $this->numeroCaracteres = 40;
    }

    /* Genera un string aleatorio */
    public function generarCadenaAleatoria() : string
    {
        $cadena = Str::random($this->numeroCaracteres);
        return $cadena;
    }

    public function setNumeroCaracteres(int $numCaracteres) : void
    {

        $this->numeroCaracteres = $numCaracteres;
    }

    public function getNumeroCaracteres() : int
    {
        return $this->numeroCaracteres;
    }
} 