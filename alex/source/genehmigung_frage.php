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

$url = $PAGE->url;
$strUrl = $url.'';

if(strpos($strUrl, 'antragid=')==true){
    $antragID_get = $_GET['antragid'];
    $_SESSION['antragid'] = $antragID_get;
}

$antragID = $_SESSION['antragid'];


$PAGE->set_url('/mod/genehmigungsansicht/genehmigung_genehmigen.php', array('id' => $cm->id));
$PAGE->set_title(format_string($genehmigungsansicht->name));
$PAGE->set_heading(format_string($course->fullname));

// Hier beginnt die Ausgabe
echo $OUTPUT->header();
echo nl2br("\n");
$strName = "Frage stellen";
echo $OUTPUT->heading($strName);
echo nl2br("\n");


// Implement form for user
require_once(dirname(__FILE__).'/forms/mailform.php');

$mform = new mailform();
// $mform->render();

//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $mform->get_data()) {
    $fm_resid = $fromform->frage;

    $sql= 'SELECT * FROM {ausleihverwaltung_borrowed} WHERE id ='.$antragID.';';
    $resource = $DB->get_record_sql($sql, array($antragID));
    $name = $resource->studentname;
    $mail_add = $resource->studentmailaddress;
    $res_id = $resource->resourceid;
    

    $mailText = "Sehr geehrte/r " . $name . ",\n\nSie haben kürzlich einen Antrag über das Ausleihen einer Ressource (ID: " . $res_id . ") gestellt.\n\nDer Bearbeiter hat dazu folgende Frage an Sie:\n'" . $fm_resid . "'.\n\n\nDies ist eine automatisch generierte Mail. Antworten auf diese Mail werden daher unbeantwortet bleiben.\n\nMit freundlichem Gruß,\ndas IT Team der DHBW Mannheim";

    $mail_add = "alexanderburghardt@web.de";
    mail_to($mail_add, $name, 'Frage zu Ihrem Ausleihantrag', $mailText);
    
    $message =  "Frage wurde gesendet.";

    echo $message;
    echo nl2br("\n");
    echo nl2br("\n");
    echo nl2br("\n");
} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.

  // Set default data (if any)
  // Required for module not to crash as a course id is always needed
  $formdata = array('id' => $id);
  $mform->set_data($formdata);
  //displays the form
  $mform->display();

}

//Funktionstaste zum Fortfahren definieren
echo $OUTPUT->single_button(new moodle_url('../genehmigungsansicht/view.php', array('id' => $cm->id)), 'Zurück', $attributes=null);

//Finish
echo $OUTPUT->footer();
?>