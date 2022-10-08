<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

enum Region: string
{
    case Global = 'global';
    case Mystic = 'mystic';
    case Japan = 'japan';
    case Xmas = 'xmas';
    case Summer = 'summer';
    case StrawberrySummer = 'strawberrySummer';
    case VanillaSummer = 'vanillaSummer';
    case Shiny = 'shiny';
    case StrawberryShiny = 'strawberryShiny';
    case VanillaShiny = 'vanillaShiny';
}
