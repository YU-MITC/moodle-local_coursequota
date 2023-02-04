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
 * Settings definition
 *
 * @package   local_coursequota
 * @copyright (C) 2023 Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

defined('MOODLE_INTERNAL') || die();

global $CFG, $DB;

require_once($CFG->dirroot . '/local/coursequota/locallib.php');

if ($hassiteconfig) {
    // Settings will be NULL.
    $settings = new admin_settingpage(QUOTA_PLUGIN_NAME, get_string('pluginname', QUOTA_PLUGIN_NAME));
    $ADMIN->add('localplugins', $settings);

    $nooryesoptions = [0 => get_string('no'), 1 => get_string('yes')];

    $actionoptions = [
                      0 => get_string('warningonly', QUOTA_PLUGIN_NAME),
                      1 => get_string('prohibit', QUOTA_PLUGIN_NAME)
                     ];

    $numcontentoptions = [
                            0 => '0',
                          100 => '100',
                          200 => '200',
                          300 => '300',
                          400 => '400',
                          500 => '500',
                          600 => '600',
                          700 => '700',
                          800 => '800',
                          900 => '900',
                          1000 => '1000'
                         ];

    $percentageoptions = [
                          50 => '50',
                          55 => '55',
                          60 => '60',
                          65 => '65',
                          70 => '70',
                          75 => '75',
                          80 => '80',
                          85 => '85',
                          90 => '90',
                          95 => '95'
                         ];

    // Enable course quota.
    $settings->add(
        new admin_setting_configselect(
            QUOTA_PLUGIN_NAME . '/enable_quota',
            get_string('enable_quota', QUOTA_PLUGIN_NAME),
            get_string('enable_quota_desc', QUOTA_PLUGIN_NAME),
            0, // Default value.
            $nooryesoptions
        )
    );

    // Set action for target course(s).
    $settings->add(
        new admin_setting_configselect(
            QUOTA_PLUGIN_NAME . '/quota_action',
            get_string('quota_action', QUOTA_PLUGIN_NAME),
            get_string('quota_action_desc', QUOTA_PLUGIN_NAME),
            0, // Default value.
            $actionoptions
        )
    );

    // Select maximum number of content for regular course(s).
    $settings->add(
        new admin_setting_configselect(
            QUOTA_PLUGIN_NAME . '/regular_limit',
            get_string('regular_limit', QUOTA_PLUGIN_NAME),
            get_string('regular_limit_desc', QUOTA_PLUGIN_NAME),
            300, // Default value.
            $numcontentoptions
        )
    );

    // Select warning threshold for regular course(s).
    $settings->add(
        new admin_setting_configselect(
            QUOTA_PLUGIN_NAME . '/regular_percentage',
            get_string('regular_percentage', QUOTA_PLUGIN_NAME),
            get_string('regular_percentage_desc', QUOTA_PLUGIN_NAME),
            80, // Default value.
            $percentageoptions
         )
    );

    // Apply other limit to the following course(s).
    $settings->add(
        new admin_setting_configtextarea(
            QUOTA_PLUGIN_NAME . '/special_shortnames',
            get_string('special_courses', QUOTA_PLUGIN_NAME),
            get_string('special_courses_desc', QUOTA_PLUGIN_NAME),
            ''
        )
    );

    // Maximum number of content for special course(s).
    $settings->add(
        new admin_setting_configselect(
            QUOTA_PLUGIN_NAME . '/special_limit',
            get_string('special_limit', QUOTA_PLUGIN_NAME),
            get_string('special_limit_desc', QUOTA_PLUGIN_NAME),
            500, // Default value.
            $numcontentoptions
        )
    );

    // Select warning threshold for special course(s).
    $settings->add(
        new admin_setting_configselect(
            QUOTA_PLUGIN_NAME . '/special_percentage',
            get_string('special_percentage', QUOTA_PLUGIN_NAME),
            get_string('special_percentage_desc', QUOTA_PLUGIN_NAME),
            80, // Default value.
            $percentageoptions
         )
    );

}
