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
 * Prints a particular instance of checkdeadline
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_ausleihverwaltung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// Replace checkdeadline with the name of your module and remove this line.
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');
$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... checkdeadline instance ID - it should be named as the first character of the module.
if ($id) {
    $cm         = get_coursemodule_from_id('ausleihverwaltung', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $ausleihverwaltung  = $DB->get_record('ausleihverwaltung', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $ausleihverwaltung  = $DB->get_record('ausleihverwaltung', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $ausleihverwaltung->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('ausleihverwaltung', $ausleihverwaltung->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}
require_login($course, true, $cm);
$event = \mod_ausleihverwaltung\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $ausleihverwaltung);
$event->trigger();
/* PAGE belegen*/
$PAGE->set_url('/mod/ausleihverwaltung/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($ausleihverwaltung->name));
$PAGE->set_heading(format_string($course->fullname));
// Hier beginnt die Ausgabe
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($ausleihverwaltung->intro) {
    echo $OUTPUT->box(format_module_intro('ausleihantrag', $ausleihverwaltung, $cm->id), 'generalbox mod_introbox', 'ausleihantragintro');
}

echo $OUTPUT->heading('Genehmigungen: Übersicht');

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
  
    $htmlLink = html_writer::link(new moodle_url('../ausleihverwaltung/genehmigung.php', array('id' => $cm->id, 'antragid' => $res->id)), 'Genehmigen/Ablehnen', $attributes=null);

//Daten zuweisen an HTML-Tabelle
    if($accepted == 0){
        $table->data[] = array($resourceid, $studentname, $borrowdate_conv->format('d.m.Y'), $duedate_conv->format('d.m.Y'), $htmlLink);
    }
}
//Tabelle ausgeben
echo html_writer::table($table);

// Finish the page.
echo $OUTPUT->footer();