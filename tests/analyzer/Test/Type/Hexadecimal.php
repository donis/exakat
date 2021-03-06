<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Type_Hexadecimal extends Analyzer {
    /* 3 methods */

    public function testType_Hexadecimal01()  { $this->generic_test('Type_Hexadecimal.01'); }
    public function testType_Hexadecimal02()  { $this->generic_test('Type_Hexadecimal.02'); }
    public function testType_Hexadecimal03()  { $this->generic_test('Type/Hexadecimal.03'); }
}
?>