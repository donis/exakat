<?php

    $b['B'] = C('D', $b['B']);
    $b['B'] = G($b['B']);     
    $b['B'] = J($b['B']);     
    $b['B'] = M('D', $b['B']);

    P::$c = C('D', P::$c);
    P::$c = G(P::$c);     
    P::$c = J(P::$c);     
    P::$c = M('D', P::$c);

    $b->AD = C('D', $b->AD);
    $b->AD = G($b->AD);     
    $b->AD = J($b->AD);     
    $b->AD = M('D', $b->AD);

    $b['B2'] = 'D'. $b['B'];
    $b['B2'] = G + $b['B'];     

    P::$c2 = C('D', P::$c3);
    P::$c2 = 'D'. P::$c4;     

    $b->AD2 = 'D'. $b->AD4;
    $b->AD2 = G % $b->AD5;     

?>