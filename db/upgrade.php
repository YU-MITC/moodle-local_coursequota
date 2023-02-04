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
 * This file keeps track of upgrades to new local_coursequota plugin.
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package   local_coursequota
 * @copyright (C) 2023 Yamaguchi University <gh-cc@mlex.cc.yamaguchi-u.ac.jp>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author    Tomoya Saito
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Execute newmodule upgrade from the given old version.
 *
 * @param int $oldversion - version number of old plugin.
 * @return bool - this function always return true.
 */
function xmldb_local_coursequota_upgrade($oldversion) {
    global $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2023020300) {
        $table = new xmldb_table('local_coursequota');
        if (!$dbman->table_exists($table)) {
            $field1 = new xmldb_field('id');
            $field1->set_attributes(XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null, null);

            $field2 = new xmldb_field('courseid');
            $field2->set_attributes(XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, 0, 'id');
            $field2->setDefault('0');

            $field3 = new xmldb_field('timemodified');
            $field3->set_attributes(XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, null, 0, 'courseid');
            $field3->setDefault('0');

            $key = new xmldb_key('primary');
            $key->set_attributes(XMLDB_KEY_PRIMARY, array('id'), null, null);

            $unique = new xmldb_index('courseid');
            $unique->set_attributes(XMLDB_INDEX_UNIQUE, array('courseid'), null);

            $table->addField($field1);
            $table->addField($field2);
            $table->addField($field3);
            $table->addKey($key);
            $table->addIndex($unique);

            $dbman->create_table($table);
        }

        // Plugin local_coursequota savepoint reached.
        upgrade_plugin_savepoint(true, 2023020300, 'local', 'coursequota');
    }

    return true;
}

