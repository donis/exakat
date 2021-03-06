<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Functions_WithoutReturn extends Analyzer {
    /* 3 methods */

    public function testFunctions_WithoutReturn01()  { $this->generic_test('Functions_WithoutReturn.01'); }
    public function testFunctions_WithoutReturn02()  { $this->generic_test('Functions_WithoutReturn.02'); }
    public function testFunctions_WithoutReturn03()  { $this->generic_test('Functions_WithoutReturn.03'); }
}
?>