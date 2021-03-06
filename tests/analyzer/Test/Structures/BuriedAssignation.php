<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Structures_BuriedAssignation extends Analyzer {
    /* 7 methods */

    public function testStructures_BuriedAssignation01()  { $this->generic_test('Structures_BuriedAssignation.01'); }
    public function testStructures_BuriedAssignation02()  { $this->generic_test('Structures_BuriedAssignation.02'); }
    public function testStructures_BuriedAssignation03()  { $this->generic_test('Structures_BuriedAssignation.03'); }
    public function testStructures_BuriedAssignation04()  { $this->generic_test('Structures_BuriedAssignation.04'); }
    public function testStructures_BuriedAssignation05()  { $this->generic_test('Structures/BuriedAssignation.05'); }
    public function testStructures_BuriedAssignation06()  { $this->generic_test('Structures/BuriedAssignation.06'); }
    public function testStructures_BuriedAssignation07()  { $this->generic_test('Structures/BuriedAssignation.07'); }
}
?>