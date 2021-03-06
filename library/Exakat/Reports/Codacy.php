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

namespace Exakat\Reports;

use Exakat\Analyzer\Analyzer;

class Codacy extends Reports {
    const FILE_EXTENSION = '';
    const FILE_FILENAME  = '';

    public function generate($folder, $name = null) {
        $list = Analyzer::getThemeAnalyzers('Codacy');
        $list = '"'.join('", "', $list).'"';

        $sqlite = new \Sqlite3($folder.'/dump.sqlite');
        $sqlQuery = 'SELECT LTRIM(file, "/") AS filename,
                            line AS line,
                            analyzer AS patternId,
                            "" AS message FROM results WHERE analyzer in ('.$list.')';
        $res = $sqlite->query($sqlQuery);

        $results = '';
        $titleCache = array();
        $severityCache = array();
        while($row = $res->fetchArray(\SQLITE3_ASSOC)) {
            $message = array();

            if (!isset($titleCache[$row['patternId']])) {
                $analyzer = Analyzer::getInstance($row['patternId'], $this->config);
                $titleCache[$row['patternId']] = $analyzer->getDescription()->getName();
            }

            $row['message'] = $titleCache[$row['patternId']];
            /*
            {
            "filename":"codacy/core/test.js",
            "message":"found this in your code",
            "patternId":"latedef",
            "line":2
            }
            */
            $results .= json_encode($row, JSON_UNESCAPED_SLASHES)."\n";
        }

        // output to stdout
        print $results;
    }
}

?>