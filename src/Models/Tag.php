<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

enum Tag: string
{
    case Default = '';
    case Origin = 'origin';
    case Meo1 = 'meo1';
    case Meo2 = 'meo2';
    case Agamogenesis = 'agamogenesis';
}
