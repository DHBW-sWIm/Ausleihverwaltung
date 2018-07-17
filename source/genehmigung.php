<?php
// Replace ausleihverwaltung with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

$antragID = $_GET['antragid'];
$rowID;

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... ausleihverwaltung instance ID - it should be named as the first character of the module.

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

// Print the page header.

$PAGE->set_url('/mod/ausleihverwaltung/genehmigung.php', array('id' => $cm->id));
$PAGE->set_title(format_string($ausleihverwaltung->name));
$PAGE->set_heading(format_string($course->fullname));

// Output starts here.
echo $OUTPUT->header();

// Replace the following lines with you own code.
echo $OUTPUT->heading('ausleihverwaltung: Details');

$attributes = array();
// Alle Datensätze aus der DB-Tabelle >>resources<< abfragen.
$resource = $DB->get_records('ausleihverwaltung_borrowed');

$table = new html_table();
$table->head = array('Ausleiher','Grund der Ausleihe', 'Zeitraum', 'Anmerkungen');

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
    
    $borrowdate_conv = new DateTime("@$borrowdate");  // convert UNIX timestamp to PHP DateTime
    $duedate_conv = new DateTime("@$duedate");  // convert UNIX timestamp to PHP DateTime
//    echo $borrowdate_conv->format('d.m.Y'); // output = 2017-01-01 00:00:00

//Daten zuweisen an HTML-Tabelle
    if($id == $antragID){
        $table->data[] = array($studentname, $borrowreason, $borrowdate_conv->format('d.m.Y') . ' - ' . $duedate_conv->format('d.m.Y'), $comment);
        $rowID = $id;
    }
}
//Tabelle ausgeben
echo html_writer::table($table);

echo $OUTPUT->single_button(new moodle_url('../ausleihverwaltung/view.php', array('antragid' => $antragID)), 'Abbrechen');
echo $OUTPUT->single_button(new moodle_url('../ausleihverwaltung/genehmigung_genehmigen.php', array('id' => $cm->id, 'antragid' => $antragID, 'rowid' => $rowID)), 'Genehmigen', $attributes=null);
echo $OUTPUT->single_button(new moodle_url('../ausleihverwaltung/genehmigung_frage.php', array('id' => $cm->id, 'antragid' => $antragID, 'rowid' => $rowID)), 'Frage stellen', $attributes=null);
echo $OUTPUT->single_button(new moodle_url('../ausleihverwaltung/genehmigung_ablehnen.php', array('id' => $cm->id, 'antragid' => $antragID, 'rowid' => $rowID)), 'Ablehnen', $attributes=null);

// Finish the page.
echo $OUTPUT->footer();