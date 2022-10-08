<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

enum PartSkin: string
{
    case Global = 'global';
    case Mystic = 'mystic';
    case Japan = 'japan';
    case Xmas1 = 'xmas1';
    case Xmas2 = 'xmas2';
    case Bionic = 'bionic';
    case Summer = 'summer';
    case StrawberrySummer = 'strawberrySummer';
    case VanillaSummer = 'vanillaSummer';
    case Shiny = 'shiny';
    case StrawberryShiny = 'strawberryShiny';
    case VanillaShiny = 'vanillaShiny';
}
