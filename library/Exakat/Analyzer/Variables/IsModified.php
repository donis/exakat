<?php
/*
 * Copyright 2012-2017 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/


namespace Exakat\Analyzer\Variables;

use Exakat\Analyzer\Analyzer;
use Exakat\Data\Methods;

class IsModified extends Analyzer {
    public function dependsOn() {
        return array('Classes/Constructor');
    }
    
    public function analyze() {
        $atoms = 'Variable';

        $this->atomIs(array('Variablearray', 'Variable'))
             ->inIsIE('VARIABLE')
             ->hasIn(array('PREPLUSPLUS', 'POSTPLUSPLUS', 'DEFINE', 'CAST'))
             ->back('first');
        $this->prepareQuery();

        $this->atomIs(array('Variablearray', 'Variable'))
             ->inIsIE(array('VARIABLE', 'APPEND'))
             ->inIs(array('LEFT', 'VARIABLE'))
             ->atomIs(array('Assignation', 'Arrayappend'))
             ->hasNoIn('VARIABLE')
             ->back('first');
        $this->prepareQuery();

        // catch
        $this->atomIs($atoms)
             ->inIs('VARIABLE')
             ->atomIs('Catch')
             ->back('first');
        $this->prepareQuery();

        // arguments : reference variable in a custom function
        $this->atomIs('Functioncall')
             ->tokenIs(array('T_STRING', 'T_NS_SEPARATOR'))
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->atomIs($atoms)
             ->savePropertyAs('rank', 'rank')
             ->_as('results')
             ->back('first')
             ->functionDefinition()
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->samePropertyAs('rank', 'rank')
             ->is('reference', true)
             ->back('results');
        $this->prepareQuery();

        // function/methods definition : all modified by incoming values
        // simple variable
        $this->atomIs(self::$FUNCTION_METHOD)
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->atomIs(self::$VARIABLES_ALL);
        $this->prepareQuery();

        // simple variable + default value : already done in line 18

        // typehint
        $this->atomIs(self::$FUNCTION_METHOD)
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->outIs('TYPEHINT')
             ->atomIs($atoms);
        $this->prepareQuery();

        // PHP functions that are using references
        $data = new Methods($this->config);
        
        $functions = $data->getFunctionsReferenceArgs();
        $references = array();
        
        foreach($functions as $function) {
            if (!isset($references[$function['position']])) {
                $references[$function['position']] = array('\\'.$function['function']);
            } else {
                $references[$function['position']][] = '\\'.$function['function'];
            }
        }
        
        foreach($references as $position => $functions) {
            $this->atomFunctionIs($functions)
                 ->outIs('ARGUMENTS')
                 ->outIs('ARGUMENT')
                 ->is('rank', $position)
                 ->outIsIE('VARIABLE')
                 ->atomIs(self::$VARIABLES_ALL);
            $this->prepareQuery();
        }

        // Class constructors (__construct)
        $this->atomIs('Newcall')
             ->tokenIs(array('T_STRING', 'T_NS_SEPARATOR'))
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->atomIs($atoms)
             ->savePropertyAs('rank', 'rank')
             ->_as('results')
             ->back('first')
             ->classDefinition()
             ->outIs('METHOD')
             ->analyzerIs('Classes/Constructor')
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->samePropertyAs('rank', 'rank')
             ->is('reference', true)
             ->back('results');
        $this->prepareQuery();
    }
}

?>
