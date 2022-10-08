<?php

declare(strict_types=1);

namespace Ndarproj\AxieGeneParser\Models;

class BinClass
{
    const get = [
        // 256 Classes
        '0000' => Cls::Beast,
        '0001' => Cls::Bug,
        '0010' => Cls::Bird,
        '0011' => Cls::Plant,
        '0100' => Cls::Aquatic,
        '0101' => Cls::Reptile,
        '1000' => Cls::Mech,
        '1001' => Cls::Dawn,
        '1010' => Cls::Dusk,
        // 512 Classes
        '00000' =>  Cls::Beast,
        '00001' =>  Cls::Bug,
        '00010' =>  Cls::Bird,
        '00011' =>  Cls::Plant,
        '00100' =>  Cls::Aquatic,
        '00101' =>  Cls::Reptile,
        '10000' =>  Cls::Mech,
        '10001' =>  Cls::Dawn,
        '10010' =>  Cls::Dusk,
    ];
}
