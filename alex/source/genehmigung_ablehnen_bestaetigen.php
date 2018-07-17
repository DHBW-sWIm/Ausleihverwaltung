<?php
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

$PAGE->set_url('/mod/genehmigungsansicht/genehmigung_ablehnen.php', array('id' => $cm->id));
$PAGE->set_title(format_string($genehmigungsansicht->name));
$PAGE->set_heading(format_string($course->fullname));

// Hier beginnt die Ausgabe
echo $OUTPUT->header();
echo nl2br("\n");
$strName = "Antrag abgelehnt";
echo $OUTPUT->heading($strName);
echo nl2br("\n");

$antragID = $_GET['antragid'];

$attributes = array();
//// Alle Datensätze aus der DB-Tabelle >>resources<< abfragen.
$sql= 'SELECT * FROM {ausleihverwaltung_borrowed} WHERE id ='.$antragID.';';
$resource = $DB->get_record_sql($sql, array($antragID));
$resource->accepted = 3;

$DB->update_record('ausleihverwaltung_borrowed',$resource,$bulk=false); 

$name = $resource->studentname;
$mail_add = $resource->studentmailaddress;
$res_id = $resource->resourceid;

$mailText = "Sehr geehrte/r " . $name . ",\n\nSie haben kürzlich einen Antrag über das Ausleihen einer Ressource (ID: " . $res_id . ") gestellt.\n\nDer Antrag wurde abgelehnt.\n\n\nDies ist eine automatisch generierte Mail. Antworten auf diese Mail werden daher unbeantwortet bleiben.\n\nMit freundlichem Gruß,\ndas IT Team der DHBW Mannheim";
$mail_add = "alexanderburghardt@web.de";
mail_to($mail_add, $name, 'Ausleihantrag abgelehnt', $mailText);

//Erfolgsmeldung
$message =  "Der Antrag wurde abgelehnt und der Antragsteller wurde per Email darüber informiert.";

echo $message;
echo nl2br("\n");
echo nl2br("\n");
echo nl2br("\n");

//Funktionstaste zum Fortfahren definieren
echo $OUTPUT->single_button(new moodle_url('../genehmigungsansicht/view.php', array('id' => $cm->id)), 'Zurück');

//Finish
echo $OUTPUT->footer();
?>