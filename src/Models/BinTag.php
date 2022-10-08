<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

class BinTag
{
    const get = [
        // 256 Tags
        '00000' => Tag::Default,
        '00001' => Tag::Origin,
        '00010' => Tag::Agamogenesis,
        '00011' => Tag::Meo1,
        '00100' => Tag::Meo2,
        // 512 Tags
        '000000000000000' => Tag::Default,
        '000000000000001' => Tag::Origin,
        '000000000000010' => Tag::Meo1,
        '000000000000011' => Tag::Meo2,
    ];
}
