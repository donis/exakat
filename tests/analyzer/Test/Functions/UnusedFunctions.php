<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Functions_UnusedFunctions extends Analyzer {
    /* 6 methods */

    public function testFunctions_UnusedFunctions01()  { $this->generic_test('Functions_UnusedFunctions.01'); }
    public function testFunctions_UnusedFunctions02()  { $this->generic_test('Functions/UnusedFunctions.02'); }
    public function testFunctions_UnusedFunctions03()  { $this->generic_test('Functions/UnusedFunctions.03'); }
    public function testFunctions_UnusedFunctions04()  { $this->generic_test('Functions/UnusedFunctions.04'); }
    public function testFunctions_UnusedFunctions05()  { $this->generic_test('Functions/UnusedFunctions.05'); }
    public function testFunctions_UnusedFunctions06()  { $this->generic_test('Functions/UnusedFunctions.06'); }
}
?>