<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Commandline script to reset capabilities in designated course.
 *
 * @package   local_coursequota
 * @copyright (C) 2023 Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

define('CLI_SCRIPT', true);

require(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.php');
require_once($CFG->libdir . '/clilib.php');
require_once($CFG->libdir . '/accesslib.php');
require(dirname(dirname(__FILE__)) . '/locallib.php');

list($options, $unrecognized) = cli_get_params([
    'courseid' => '',
], [
    'c' => 'courseid',
]);

$courseid = $options['courseid'];

if (!$courseid) {
    exit(0);
}

$flag = local_coursequota_set_course_permission($courseid, false, true);

if ($flag == true) {
    echo get_string('changed', QUOTA_PLUGIN_NAME) . PHP_EOL;
} else {
    echo get_string('notchanged',  QUOTA_PLUGIN_NAME) . PHP_EOL;
}
