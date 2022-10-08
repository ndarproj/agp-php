<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

class BinBodySkin
{
    const get = [
        '0000' => BodySkin::Normal,
        '0001' => BodySkin::Frosty,
        '0010' => BodySkin::Wavy,
    ];
}
