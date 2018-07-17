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
 * This file keeps track of upgrades to the ausleihverwaltung module
 *
 * Sometimes, changes between versions involve alterations to database
 * structures and other major things that may break installations. The upgrade
 * function in this file will attempt to perform all the necessary actions to
 * upgrade your older installation to the current version. If there's something
 * it cannot do itself, it will tell you what you need to do.  The commands in
 * here will all be database-neutral, using the functions defined in DLL libraries.
 *
 * @package    mod_ausleihverwaltung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();
/**
 * Execute ausleihverwaltung upgrade from the given old version
 *
 * @param int $oldversion
 * @return bool
 */
function xmldb_ausleihverwaltung_upgrade($oldversion) {
<<<<<<< HEAD
    global $DB;

    $dbman = $DB->get_manager(); // Loads ddl manager and xmldb classes.

    if ($oldversion < 2018071106) {

        // Define table ausleihverwaltung_borrowed to be created.
        $table = new xmldb_table('ausleihverwaltung_borrowed');

        // Adding fields to table ausleihverwaltung_borrowed.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('duedate', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '9999999999');
        $table->add_field('resourceid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('studentmatrikelnummer', XMLDB_TYPE_INTEGER, '7', null, XMLDB_NOTNULL, null, null);
        $table->add_field('studentmailaddress', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('borrowdate', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, null);
        $table->add_field('studentname', XMLDB_TYPE_CHAR, '255', null, XMLDB_NOTNULL, null, null);
        $table->add_field('borrowreason', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('comment', XMLDB_TYPE_TEXT, null, null, null, null, null);
        $table->add_field('accepted', XMLDB_TYPE_INTEGER, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('returned', XMLDB_TYPE_BINARY, null, null, XMLDB_NOTNULL, null, null);

        // Adding keys to table ausleihverwaltung_borrowed.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for ausleihverwaltung_borrowed.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // ausleihverwaltung savepoint reached.
        upgrade_mod_savepoint(true, 2018071106, 'ausleihverwaltung');
    }

    if ($oldversion < 2018071106) {

        // Define table ausleihverwaltung_resp to be created.
        $table = new xmldb_table('ausleihverwaltung_resp');

        // Adding fields to table ausleihverwaltung_resp.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('dudesname', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('dudesmail', XMLDB_TYPE_CHAR, '255', null, null, null, null);

        // Adding keys to table ausleihverwaltung_resp.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for ausleihverwaltung_resp.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // ausleihverwaltung savepoint reached.
        upgrade_mod_savepoint(true, 2018071106, 'ausleihverwaltung');
    }
=======
    
>>>>>>> master
    return true;
}