<?php

$s = 3 ?? 4;
echo 0 || $d ?? $s;
var_dump(0 || 2 ?? 3 ? 4 : 5);

$s = 3 ?: 44;
$t = 3 ? 5 : 4;
