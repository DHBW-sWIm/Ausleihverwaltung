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
 * Prints a particular instance of apsechseins
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_apsechseins
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... apsechseins instance ID - it should be named as the first character of the module.

if ($id) {
    $cm           = get_coursemodule_from_id('apsechseins', $id, 0, false, MUST_EXIST);
    $course       = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $apsechseins  = $DB->get_record('apsechseins', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $apsechseins  = $DB->get_record('apsechseins', array('id' => $n), '*', MUST_EXIST);
    $course       = $DB->get_record('course', array('id' => $apsechseins->course), '*', MUST_EXIST);
    $cm           = get_coursemodule_from_instance('apsechseins', $apsechseins->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_apsechseins\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $apsechseins);
$event->trigger();

// Print the page header.
$PAGE->set_url('/mod/apsechseins/delete.php', array('id'=>$cm->id, 'resourceid'=>$_GET['resourceid']));
$PAGE->set_title(format_string($apsechseins->name));
$PAGE->set_heading(format_string($course->fullname));

// Output starts here.
echo $OUTPUT->header();
echo $OUTPUT->heading('Schadensdokumentation');

// CODE FOR AUSLEIHVERWALTUNG - SCHADENSDOKUMENTATION - EDIT SCREEN
$resourceid = $_GET['resourceid'];
$resource = $DB->get_record('schaeden', array('resourceid'=>$resourceid));
$defect = $resource->defect;
echo 'Möchten Sie den Vermerk ' . $defect . ' für die Ressource mit der ID ' . $resourceid . ' wirklich löschen? <br /><br />';
echo $OUTPUT->single_button(new moodle_url('../apsechseins/view.php', array('id'=>$cm->id, 'resourceid'=>$resourceid, 'lastAction'=>'deleteYes')), 'Ja', $attributes=null);
echo $OUTPUT->single_button(new moodle_url('../apsechseins/view.php', array('id'=>$cm->id, 'resourceid'=>$resourceid, 'lastAction'=>'deleteNo')), 'Nein', $attributes=null);
// END CODE FOR AUSLEIHVERWALTUNG - SCHADENSDOKUMENTATION - EDIT SCREEN

// Finish the page.
echo $OUTPUT->footer();
