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
 * Language file for "Course Quota".
 *
 * @package   local_coursequota
 * @copyright (C) 2023 Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

$string['pluginname'] = 'Course Quota';

// Capability strings.
$string['coursequota:allow'] = 'Allow all for user roles';

// Settings.
$string['enable_quota'] = 'Enable quota by numer of content';
$string['enable_quota_desc'] = 'If enable, this plugin will warn to course(s) with too much content, or prohibit addition of new activity and resource.';
$string['quota_action'] = 'Quota aciton';
$string['quota_action_desc'] = 'Choose quota action to target course(s).';
$string['warningonly'] = 'Warning only';
$string['prohibit'] = 'Prohibit';
$string['target_roles'] = 'Target role(s)';
$string['target_roles_desc'] = 'Roles subject to warning or prohibition.';
$string['regular_limit'] = 'Regular limit';
$string['regular_limit_desc'] = 'Maximum number of contents for regular course(s).  0 means unlimited';
$string['special_limit'] = 'Special limit';
$string['special_limit_desc'] = 'Maximum number of contents for special course(s).  0 means unlimited';
$string['special_courses'] = 'Special course(s)';
$string['special_courses_desc'] = 'Array of course shortnames to apply other limit.  Please enter one shortname per line.';
$string['regular_percentage'] = 'Warning threshold (regular courses)';
$string['regular_percentage_desc'] = 'Print warning if percentage of number of content to the maximum value exceeds this value.';
$string['special_percentage'] = 'Warning threshold (special courses)';
$string['special_percentage_desc'] = 'Print warning if percentage of number of content to the maximum value exceeds this value.';
$string['warning_message'] = 'Number of contents in this course ({$a->contents}) is approaching its limit ({$a->limit}).';
$string['critical_message'] = 'Number of contents in this course ({$a->contents}) has reached its limit ({$a->limit}).';
$string['changed'] = 'This script has been changed capabilities.';
$string['notchanged'] = 'This script did not change any capability.';
$string['multichanged'] = 'This script has been changed capabilities of {$a} course(s).';

// Privacy strings.
$string['privacy:metadata'] = 'The Course Quota plugin does not store any personal data.';

