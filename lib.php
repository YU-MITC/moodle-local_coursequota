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
 * Libraries for course quota.
 *
 * @package   local_coursequota
 * @copyright (C) 2023 Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once(dirname(__FILE__) . '/locallib.php');

defined('MOODLE_INTERNAL') || die();

/**
 * This function print notification message into course.
 * @return string - notification message.
 */
function local_coursequota_before_standard_top_of_body_html() {
    global $COURSE, $OUTPUT, $PAGE, $USER;

    if (is_siteadmin($USER->id)) {
        return "";
    }

    if (!local_coursequota_enable()) {
        return "";
    }

    $enablequota = get_config(QUOTA_PLUGIN_NAME, 'enable_quota');
    if (empty($enablequota) || (int)$enablequota == 0) {
        return "";
    }

    if (!local_coursequota_match_role()) {
        return "";
    }

    $url = $PAGE->url;
    $message = "";

    $invisible = 0;

    if (preg_match("/\/course\/view\.php\?id=[0-9]+/i", $url) && !empty($COURSE)) {
        $editmode = optional_param('notifyeditingon', 0, PARAM_INT);
        $contents = local_coursequota_get_contents();
        $limit = local_coursequota_get_limit();
        $percentage = local_coursequota_get_percentage();
        $restriction = false;
        if ($limit > 0 && $contents >= $limit) {
            $restriction = true;
        }
        $quotaaction = get_config(QUOTA_PLUGIN_NAME, 'quota_action');
        if ($restriction == false || ($restriction == true && (int)$quotaaction == ACTION_PROHIBIT)) {
            local_coursequota_change_capabilities($restriction);
        }

        $params = array('contents' => $contents, 'limit' => $limit);
        if ($restriction) {
            if ($quotaaction == ACTION_PROHIBIT) {
                $invisible = 1;
            }
            $message = get_string('critical_message', QUOTA_PLUGIN_NAME, $params);
            $PAGE->requires->js_call_amd('local_coursequota/notification', 'init', array($message, $USER->lang, $invisible));
        } else {
            if (local_coursequota_notification_level($contents, $limit, $percentage) == 'warning') {
                $message = get_string('warning_message', QUOTA_PLUGIN_NAME, $params);
                $PAGE->requires->js_call_amd('local_coursequota/notification', 'init', array($message, $USER->lang, $invisible));
            }
        }
    }

    return $message;
}

/**
 * This function is done before a course is deleted.
 * Delete records from {coursequota} table about the course.
 */
function local_courequota_pre_course_delete() {
    global $COURSE, $DB;

    $context = context_course::instance($COURSE->id);
    $DB->delete_records('local_coursequota', array('courseid' => $COURSE->id));
}

