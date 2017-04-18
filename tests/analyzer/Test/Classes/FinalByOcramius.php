<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Classes_FinalByOcramius extends Analyzer {
    /* 5 methods */

    public function testClasses_FinalByOcramius01()  { $this->generic_test('Classes/FinalByOcramius.01'); }
    public function testClasses_FinalByOcramius02()  { $this->generic_test('Classes/FinalByOcramius.02'); }
    public function testClasses_FinalByOcramius03()  { $this->generic_test('Classes/FinalByOcramius.03'); }
    public function testClasses_FinalByOcramius04()  { $this->generic_test('Classes/FinalByOcramius.04'); }
    public function testClasses_FinalByOcramius05()  { $this->generic_test('Classes/FinalByOcramius.05'); }
}
?>