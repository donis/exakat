<?php
/*
 * Copyright 2012-2016 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
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


namespace Tasks;

class Status extends Tasks {
    public function run(\Config $config) {
        $project = $config->project;

        $path = $config->projects_root.'/projects/'.$project;
        
        if (!file_exists($path.'/')) {
            die("Project '$project' does not exists. Aborting\n");
        }

        $status = array('project' => $project);
        $status['loc'] = $this->datastore->getHash('loc');
        $status['tokens'] = $this->datastore->getHash('tokens');

        // Check the logs
        $errors = array();
        // Error log
        if (!file_exists($path.'/log/errors.log')) {
            $errors['errors.log'] = 'errors.log is missing';
        } elseif (filesize($path.'/log/errors.log') != 191) {
            $log = file_get_contents($path.'/log/errors.log');
            preg_match_all("#files with next : (.+?)\n((  .*?\n)*)#m", $log, $r);
            $errors['errors.log'] = 'errors.log has '.(count($r[1]) + count(explode("\n", $r[2][0]))).' files in error';
        } // Else no report

        // Tokenizer log
        if (!file_exists($path.'/log/tokenizer.log')) {
            $errors['errors.log'] = 'errors.log is missing';
        } elseif (filesize($path.'/log/errors.log') != 191) {
            $log = file_get_contents($path.'/log/errors.log');
            preg_match_all("#files with next : (.+?)\n((  .*?\n)*)#m", $log, $r);
            $errors['errors.log'] = 'errors.log has '.(count($r[1]) + count(explode("\n", $r[2][0]))).' files in error';
        } // Else no report        
        if (!empty($errors)) {
            $status['errors'] = $errors;
        }
        
        // Status of progress
        // errors? 

        $formats = array();
        foreach(\Reports\Reports::FORMATS as $format) {
            $a = $this->datastore->getHash($format);
            if (!empty($a)) {
                $formats[$format] = $a;
            }
        }
        if (!empty($formats)) {
            $status['formats'] = $formats;
        }
        

        if ($config->json == true) {
            print json_encode($status);
        } else {
            $text = '';
            $size = 0;
            foreach($status as $k => $v) {
                $size = max($size, strlen($k));
            }

            foreach($status as $field => $value) {
                if (is_array($value)) {
                    $sub = substr($field.str_repeat(' ', $size), 0, $size)." : \n";

                    $sizea = 0;
                    foreach($value as $k => $v) {
                        $sizea = max($sizea, strlen($k));
                    }
                    foreach($value as $k => $v) {
                        $sub .= "    ".substr($k.str_repeat(' ', $sizea), 0, $sizea)." : $v\n";
                    }
                    $text .= "\n".$sub."\n";
                } else {
                    $text .= substr($field.str_repeat(' ', $size), 0, $size) . ' : '.$value."\n";
                }
            }
            
            print $text;
        }
    }
}

?>
