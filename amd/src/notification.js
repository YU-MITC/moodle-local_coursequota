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
 * Notification script for coursequota.
 *
 * @copyright (C) 2023 Yamaguchi University (gh-cc@mlex.cc.yamaguchi-u.ac.jp)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

/**
 * @module local_coursequota/notification
 */
define(['jquery'], function($) {

    return {
        /**
         * Initial function.
         * @access public
         * @param {string} message - notification message.
         * @param {string} lang - language code.
         * @param {int} invisible - if 1, add activities menu is not viewed.
         */
        init: function(message, lang, invisible) {
            /**
             * This function print notification message.
             * @access public
             * @param {string} message - notification message.
             */
            function printNotification(message) {
                var html  = '';
                var code = '';
                if (lang == 'ja') {
                    code = '×';
                } else {
                    code = 'X';
                }
                html += '<div class="alert alert-danger alert-block fade in " role="alert">';
                html += '<button type="button" class="close" data-dismiss="alert">' + code + '</button>';
                html += message;
                html += '</div>';
               $("#user-notifications").append(html);
            }

            /**
             * This function remove "Add activities" menu from course.
             */
            function invisibleAddActivityMenu() {
                $('.section-modchooser,.section_add_menus').css({'display':'none'});
            }

            printNotification(message);
            if (invisible == 1) {
                invisibleAddActivityMenu();
            }
        }
    };
});
