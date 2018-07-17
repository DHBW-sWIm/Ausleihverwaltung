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
 * Prints a particular instance of genehmigungsansicht
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_genehmigungsansicht
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace genehmigungsansicht with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... genehmigungsansicht instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('genehmigungsansicht', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $genehmigungsansicht  = $DB->get_record('genehmigungsansicht', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $genehmigungsansicht  = $DB->get_record('genehmigungsansicht', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $genehmigungsansicht->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('genehmigungsansicht', $genehmigungsansicht->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_genehmigungsansicht\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $genehmigungsansicht);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/genehmigungsansicht/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($genehmigungsansicht->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('genehmigungsansicht-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($genehmigungsansicht->intro) {
    echo $OUTPUT->box(format_module_intro('genehmigungsansicht', $genehmigungsansicht, $cm->id), 'generalbox mod_introbox', 'genehmigungsansichtintro');
}

// Replace the following lines with you own code.
echo $OUTPUT->heading('Genehmigungsansicht: Übersicht');

$attributes = array();
// Alle Datensätze aus der DB-Tabelle >>resources<< abfragen.
$resource = $DB->get_records('ausleihverwaltung_borrowed');

$table = new html_table();
$table->head = array('Gerät','Ausleiher', 'Zeitraum von', 'Zeitraum bis');

//Für jeden Datensatz
foreach ($resource as $res) {
    $id = $res->id;
    $duedate = $res->duedate;
    $resourceid = $res->resourceid;
    $studentmatrikelnummer = $res->studentmatrikelnummer;
    $studentmailaddress = $res->studentmailaddress;
    $borrowdate = $res->borrowdate;
    $studentname = $res->studentname;
    $borrowreason = $res->borrowreason;
    $comment = $res->comment;
    $accepted = $res->accepted;
    $returned = $res->returned;
    $abholort = $res->abholort;
    
    $borrowdate_conv = new DateTime("@$borrowdate");  // convert UNIX timestamp to PHP DateTime
    $duedate_conv = new DateTime("@$duedate");  // convert UNIX timestamp to PHP DateTime
//    echo $borrowdate_conv->format('d.m.Y'); // output = 2017-01-01 00:00:00
    
//Link zum Bearbeiten der aktuellen Ressource in foreach-Schleife setzen
  
    $htmlLink = html_writer::link(new moodle_url('../genehmigungsansicht/genehmigung.php', array('id' => $cm->id, 'antragid' => $res->id)), 'Edit', $attributes=null);

//Daten zuweisen an HTML-Tabelle
    if($accepted == 0){
        $table->data[] = array($resourceid, $studentname, $borrowdate_conv->format('d.m.Y'), $duedate_conv->format('d.m.Y'), $htmlLink);
    }
}
//Tabelle ausgeben
echo html_writer::table($table);

echo $OUTPUT->single_button(new moodle_url('../genehmigungsansicht/view.php', array('id' => $cm->id)), 'Abbrechen');

// Finish the page.
echo $OUTPUT->footer();