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
 * Local libraries of course quota.
 *
 * @package   local_coursequota
 * @copyright (C) 2023 Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

defined('MOODLE_INTERNAL') || die();

/**
 * QUOTA_PLUGIN_NAME - local plugin name.
 */
define('QUOTA_PLUGIN_NAME', 'local_coursequota');

/*
 * Actions.
 */
define('ACTION_WARNING', 0);
define('ACTION_PROHIBIT', 1);

/**
 * This function returns whether course quota is enable.
 * @return boolean - If course quota is enable, return true. Otherwise, false.
 */
function local_coursequota_enable() {
    $enablequota = get_config(QUOTA_PLUGIN_NAME, 'enable_quota');
    if (empty($enablequota) || (int)$enablequota == 0) {
        return false;
    }
    return true;
}

/**
 * This function retrieves number of contents in course.
 * @return int - number of contents (resources and activities) in course.
 */
function local_coursequota_get_contents() {
    global $COURSE, $DB;

    $contents = 0;

    $contentsql = "SELECT COUNT(m.id) contents, c.shortname shortname, c.fullname fullname ";
    $contentsql .= "FROM {course_modules} m JOIN {course} c ON c.id=m.course WHERE c.id=:courseid and m.deletioninprogress=0";
    $contentsql .= " group by m.course ORDER BY contents desc";

    $result = $DB->get_record_sql($contentsql, array('courseid' => $COURSE->id));

    if ($result !== null || !empty($result)) {
        $contents = $result->contents;
    }

    return (int)$contents;
}

/**
 * This function retrieves limit number of contents for course.
 * @return int - maximum number of contents for course.
 */
function local_coursequota_get_limit() {
    global $COURSE;

    $limit = get_config(QUOTA_PLUGIN_NAME, 'regular_limit');

    $shortnames = get_config(QUOTA_PLUGIN_NAME, 'special_shortnames');
    $shortnamearray = preg_split("/[\s,]+/", $shortnames);
    foreach ($shortnamearray as $shortname) {
        $shortname = trim($shortname);
        if (strcmp($shortname, $COURSE->shortname) == 0) {
            $special = get_config(QUOTA_PLUGIN_NAME, 'special_limit');
            if ($special !== null && $special != '') {
                $limit = $special;
            }
        }
    }

    return (int)$limit;
}

/**
 * This function retrieves warning threshold for number of content.
 * @return float - percentage to display warning message.
 */
function local_coursequota_get_percentage() {
    global $COURSE;

    $percentage = 0.8;

    $confvalue = get_config(QUOTA_PLUGIN_NAME, 'regular_percentage');
    if ($confvalue !== null && $confvalue != '' && (int)$confvalue > 0) {
        $percentage = (float)$confvalue / 100.0;
    }

    $shortnames = get_config(QUOTA_PLUGIN_NAME, 'special_shortnames');
    $shortnamearray = preg_split("/[\s,]+/", $shortnames);
    foreach ($shortnamearray as $shortname) {
        $shortname = trim($shortname);
        if (strcmp($shortname, $COURSE->shortname) == 0) {
            $confvalue = get_config(QUOTA_PLUGIN_NAME, 'special_percentage');
            if ($confvalue !== null && $confvalue != '' && (int)$confvalue > 0) {
                $percentage = (float)$confvalue / 100.0;
            }
        }
    }

    return (float)$percentage;
}

/**
 * This function returns whether user can edit course contents.
 * @return boolean - If user can edit course contents, returns true. Otherwise, returns false.
 */
function local_coursequota_match_role() {
    global $COURSE;

    $context = context_course::instance($COURSE->id);
    if (has_capability('moodle/course:manageactivities', $context)) {
        return true;
    }

    return false;
}

/**
 * This function set role capabilities in course.
 * @param bool $restriction - System should add/remove capabilities about addition of contents.
 */
function local_coursequota_change_capabilities($restriction) {
    global $COURSE;
    local_coursequota_set_course_permission($COURSE->id, $restriction, false);
}

/**
 * Reset permissions of designated course.
 * @param int $courseid - Course ID to reset permissions.
 * @param bool $restriction - System should add/remove capabilities about addition of contents.
 * @param bool $cli - True means that this function is called via CLI.
 * @return bool - if change course permission, returns true. Othewise, returns false.
 */
function local_coursequota_set_course_permission($courseid, $restriction, $cli) {
    global $DB;

    $flag = false;

    $params = array('courseid' => $courseid);
    $result = $DB->get_record('local_coursequota', $params);

    if (($result == null || empty($result)) && $restriction == false && $cli == false) {
        return false;
    }

    if (($result != null && !empty($result)) && $restriction == true) {
        return false;
    }

    $params = array('id' => $courseid);
    $result = $DB->get_record('course', $params);
    if ($result == null || empty($result)) {
        return false;
    }

    // Get course context.
    $context = context_course::instance($courseid);
    if ($context === null || empty($context)) {
        return false;
    }

    // Get system timestamp.
    $now = time();
    // Get roles have manamgment capability for activities in course.
    $roles = get_roles_with_cap_in_context($context, 'moodle/course:manageactivities');
    $targetids = $roles[0];

    foreach ($targetids as $targetid) {
        // Get capabilities of each role.
        $capresult = role_context_capabilities((int)$targetid, $context);
        // Retrieve all capabilities about a role.
        foreach ($capresult as $key => $value) {
            // When an "addinstance" capability is found.
            if (preg_match('/^mod\/.+:addinstance$/', $key)) {
                if ($restriction) {
                    role_change_permission((int)$targetid, $context, $key, CAP_PROHIBIT);
                } else {
                    role_change_permission((int)$targetid, $context, $key, CAP_INHERIT);
                }
            }
        }
    }

    $params = array('courseid' => $courseid);
    $result = $DB->get_record('local_coursequota', $params);

    if ($restriction) {
        if ($result == null || empty($result)) {
            $statement = 'insert into {local_coursequota} ';
            $statement .= 'values (0, :courseid, :timemodified)';
            $params = array('courseid' => $courseid,
                            'timemodified' => $now
                           );
            $DB->execute($statement, $params);
            $flag = true;
        }
    } else {
        if ($result !== null && !empty($result)) {
            $DB->delete_records('local_coursequota', array('id' => $result->id));
            $flag = true;
        }
    }

    return $flag;
}

/**
 * This function reset premissions.
 * @param string $target - reset target (database or site)
 */
function local_coursequota_reset_all($target) {
    global $DB;

    if (!$target || ($target != 'database' && $target != 'site')) {
        return;
    }

    $count = 0;

    $result = null;

    if ($target == 'database') {
        // Get all records from plugin's table.
        $result = $DB->get_records('local_coursequota');
    } else {
        $result = $DB->get_records('course');
    }

    // When there exists no record in local_coursequota table.
    if ($result === null || empty($result)) {
        echo get_string('notchanged', QUOTA_PLUGIN_NAME) . PHP_EOL;
    } else { // When there exists record(s) in local_coursequota table.
        // Get course context from retrieved array.
        foreach ($result as $row) {
            $courseid = null;
            if ($target == 'database') {
                $courseid = $row->courseid;
            } else {
                $courseid = $row->id;
            }

            $flag = local_coursequota_set_course_permission($courseid, false, true);

            if ($flag == true) {
                $count = $count + 1;
            }
        }

        echo get_string('multichanged', QUOTA_PLUGIN_NAME, $count) . PHP_EOL;
    }
}

/**
 * This function returns notification level.
 * @param int $contents - Number of contents in course.
 * @param int $limit - Maximum number of contents for course.
 * @param int $percentage - threshold of nomber of contents for notification.
 * @return string - Notification level.
 */
function local_coursequota_notification_level($contents, $limit, $percentage) {
    $level = 'safety';
    if ($limit > 0) {
        if ($contents >= $limit) {
            $level = 'critical';
        } else if ((float)$contents / (float)$limit >= $percentage) {
            $level = 'warning';
        }
    }
    return $level;
}

