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
$strName = "Möchten Sie den Antrag wirklich ablehnen?";
echo $OUTPUT->heading($strName);
echo nl2br("\n");

$antragID = $_GET['antragid'];

//Funktionstaste zum Fortfahren definieren
echo $OUTPUT->single_button(new moodle_url('../genehmigungsansicht/view.php', array('id' => $cm->id)), 'Nein');
echo $OUTPUT->single_button(new moodle_url('../genehmigungsansicht/genehmigung_ablehnen_bestaetigen.php', array('id' => $cm->id, 'antragid' => $antragID)), 'Ja', $attributes=null);

//Finish
echo $OUTPUT->footer();
?>