<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

class BinRegion
{
    const get = [
        // 256 Regions
        '00000' => Region::Global,
        '00001' => Region::Japan,
        // 512 Regions
        '0000' => Region::Global,
        '0001' => Region::Mystic,
        '0011' => Region::Japan,
        '0101' => Region::Xmas,
        '0110' => Region::Summer,
        '0111' => Region::StrawberrySummer,
        '1000' => Region::VanillaSummer,
        '1001' => Region::Shiny,
        '1010' => Region::StrawberryShiny,
        '1011' => Region::VanillaShiny,
    ];
}
