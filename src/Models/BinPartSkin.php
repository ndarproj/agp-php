<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

class BinPartSkin
{
    const get = [
        // 256 Classes
        '00000' => PartSkin::Global,
        '00001' => PartSkin::Japan,
        '010101010101' => PartSkin::Xmas1,
        '01' => PartSkin::Bionic,
        '10' => PartSkin::Xmas2,
        '11' => PartSkin::Mystic,
        // 512 PartSkin
        '0000' => PartSkin::Global,
        '0001' => PartSkin::Mystic,
        '0011' => PartSkin::Japan,
        '0100' => PartSkin::Xmas1,
        '0101' => PartSkin::Xmas2,
        '0010' => PartSkin::Bionic,
        '0110' => PartSkin::Summer,
        '0111' => PartSkin::StrawberrySummer,
        '1000' => PartSkin::VanillaSummer,
        '1001' => PartSkin::Shiny,
        '1010' => PartSkin::StrawberryShiny,
        '1011' => PartSkin::VanillaShiny,
    ];
}
