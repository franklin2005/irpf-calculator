<?php

namespace App\Domain\Irpf\ValueObjects;

enum Region: string
{
    case Andalucia = 'andalucia';
    case Aragon = 'aragon';
    case Asturias = 'asturias';
    case Baleares = 'baleares';
    case Canarias = 'canarias';
    case Cantabria = 'cantabria';
    case CastillaLaMancha = 'castilla_la_mancha';
    case CastillaYLeon = 'castilla_y_leon';
    case Cataluna = 'cataluna';
    case ComunidadValenciana = 'comunidad_valenciana';
    case Extremadura = 'extremadura';
    case Galicia = 'galicia';
    case LaRioja = 'la_rioja';
    case Madrid = 'madrid';
    case Murcia = 'murcia';
    case Navarra = 'navarra';
    case PaisVasco = 'pais_vasco';
}
