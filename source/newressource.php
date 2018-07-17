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
 * Prints a particular instance of ausleihverwaltung
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_ausleihverwaltung
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace ausleihverwaltung with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once(dirname(__FILE__).'/locallib.php');

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... ausleihverwaltung instance ID - it should be named as the first character of the module.
$ressourcename = optional_param('ressourcename','', PARAM_TEXT);
$category = optional_param('category','', PARAM_TEXT);
$tags = optional_param('tags','', PARAM_TEXT);
$type = optional_param('type',0, PARAM_INT);


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


// Um Tabelle >>resources<< zu belegen
/*
$record = new stdClass();
$record->name         = 'handy';
$record->description = 'dasd';
$record->serialnumber        = 'serial12';
$record->inventorynumber = 'invent123';
$record->comment        = 'Comment this Comment thisComment thisComment thisComment thisComment thisComment thisComment thisComment thisComment thisComment thisComment thisComment thisComment thisComment this';
$record->status = 0;
$record->amount         = 2;
$record->type = 0;
$record->maincategory    = "Handy";
$record->subcategory = "sub";

$DB->insert_record('resources', $record, $returnid=false, $bulk=false);
*/

/* PAGE belegen*/
$PAGE->set_url('/mod/ausleihverwaltung/newressource.php', array('id' => $cm->id, 'ressourcename' => $_GET['ressourcename'], 'category' => $_GET['category'], 'tags' => $_GET['tags'], 'type' => $_GET['type']));
$PAGE->set_title(format_string($ausleihverwaltung->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('ausleihverwaltung-'.$somevar);
 */

// Hier beginnt die Ausgabe
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($ausleihverwaltung->intro) {
    echo $OUTPUT->box(format_module_intro('ausleihverwaltung', $ausleihverwaltung, $cm->id), 'generalbox mod_introbox', 'ausleihverwaltungintro');
}

$strName = "Ressource anlegen";
echo $OUTPUT->heading($strName);

$type = $_SESSION['type'];
$ressourcename = $_SESSION['ressourcename'];
$category = $_SESSION['category'];
$tags = $_SESSION['tags'];

if ($type == 1){
    require_once(dirname(__FILE__).'/forms/newresourceformst.php');
    $mform = new newresourcesthtml_form(null, array('ressourcename'=>$ressourcename,'category'=>$category,'tags'=>$tags,'type'=>$type));
}else{
    require_once(dirname(__FILE__).'/forms/newresourceformsch.php');
    $mform = new newresourceschhtml_form(null);
}

if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
 } else if ($fromform = $mform->get_data()) {
    
    if ($type == 1){
        $inventarnummer = $fromform->invnr;
        $seriennummer = $fromform->sernr;
        $beschreibung = $fromform->besch;
        $kommentar = $fromform->kom;

        $stueck = new stdClass();
        $stueck->name = $ressourcename;
        $stueck->description = $beschreibung;
        $stueck->type = $type;
        $stueck->status = 1;
        $stueck->maincategory = $category;
        $stueck->subcategory = $tags;
        $stueck->comment = $kommentar;
        $stueck->serialnumber = $seriennummer;
        $stueck->inventorynumber = $inventarnummer;
        $success = $DB->insert_record('ausleihverwaltung_resources', $stueck, false, $bulk=false);
        if ($success){
            ?> <script type="text/javascript">alert("Ressource angelegt!")</script><?php
        };
        
        redirect(new moodle_url('../ausleihverwaltung/resources_view.php', array('id' => $cm->id, 'ressourcename' => $ressourcename, 'category' => $category, 'tags' => $tags, 'type' => $type)));
    }else{
        $beschreibung = $fromform->besch;
        $kommentar = $fromform->kom;
        $anzahl = $fromform->anz;

        $stueck = new stdClass();
        $stueck->name = $ressourcename;
        $stueck->description = $beschreibung;
        $stueck->type = $type;
        $stueck->status = 1;
        $stueck->maincategory = $category;
        $stueck->subcategory = $tags;
        $stueck->comment = $kommentar;
        $stueck->amount = $anzahl;
        $success = $DB->insert_record('ausleihverwaltung_resources', $stueck, false, $bulk=false);
        if ($success){
            ?> <script type="text/javascript">alert("Ressource angelegt!")</script><?php
        };
        
        redirect(new moodle_url('../ausleihverwaltung/resources_view.php', array('id' => $cm->id, 'ressourcename' => $ressourcename, 'category' => $category, 'tags' => $tags, 'type' => $type)));
    }

    //Button Funktionalität hinzugefügt
    //redirect(new moodle_url('../ausleihverwaltung/new_resource_view.php', array('id' => $cm->id)));
 
 } else {
    $formdata = array('id' => $id);
    $mform->set_data($formdata);
    //displays the form
    $mform->display();
 }

// Finish the page.
echo $OUTPUT->footer();
