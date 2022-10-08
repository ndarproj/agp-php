<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

enum Cls: string
{
    case Beast = 'beast';
    case Bug = 'bug';
    case Bird = 'bird';
    case Plant = 'plant';
    case Aquatic = 'aquatic';
    case Reptile = 'reptile';
    case Mech = 'mech';
    case Dusk = 'dusk';
    case Dawn = 'dawn';
}
