<?php
require 'vendor/autoload.php';

$part = file_get_contents(__DIR__ . '/src/Assets/traits.json');
print_r(json_decode($part));
// $part = traitsJson[cls][partType][partBin];
// if (part === undefined) throw new Error("cannot recognize part binary");
// let ret = part[skin];
// if (ret === undefined) {
//   const fallBack = part[PartSkin.Global];
//   if (fallBack === undefined) throw new Error("cannot recognize part skin");
//   ret = fallBack;
// }
// return ret;

return 'asasd';
