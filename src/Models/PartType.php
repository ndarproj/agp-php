<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

enum PartType: string
{
    case Eyes = 'eyes';
    case Ears = 'ears';
    case Mouth = 'mouth';
    case Horn = 'horn';
    case Back = 'back';
    case Tail = 'tail';
}
