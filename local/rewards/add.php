<?php


use local_rewards\rewards_table;

require_once(dirname(__FILE__) . "/../../config.php");
require_once($CFG->libdir . '/adminlib.php');
require_once(dirname(__FILE__) . '/classes/rewards_form.php');
require_once(dirname(__FILE__) . '/lib.php');

$action     = optional_param('action', '', PARAM_TEXT);
$replace    = optional_param('replace', 0, PARAM_INT);
$id         = optional_param('id', 0, PARAM_INT);
$confirm    = optional_param('confirm', 0, PARAM_INT);
$oldemail   = optional_param('oldemail', 0, PARAM_TEXT);
$newemail = optional_param('newemail', 0, PARAM_TEXT);

$PAGE->set_url(new moodle_url('/local/rewards/add.php'));
$context = context_system::instance();

require_login();
$PAGE->set_context($context);
$PAGE->set_title(get_string('pluginname', 'local_rewards'));
$PAGE->set_heading(get_string('pluginname', 'local_rewards'));

global $USER, $DB;
$args = array('id'=>$id);

if (!has_capability('local/rewards:manageprize', $context)) {
	print_error('Sorry you can\'t perform this action');
}

$url = new moodle_url('/local/rewards/add.php');
$cancelurl = new moodle_url('/local/rewards/manage.php');
$mform = new rewards_form(null, $args);
if($mform->is_cancelled()) {
    redirect(new moodle_url('/local/rewards/manage.php'));
} else if ($fromform = $mform->get_data()) {
        $insert                 = new stdClass();
        $insert->prizename      =   $fromform->prizename;
        $insert->description    =   $fromform->description;
        $insert->points         =   $fromform->points;
        $insert->image         =    'default-image.jpg';
        $insert->timecreated    =   time();
        $insert->timemodified   =   time();
        $insert->createdby      =   $USER->id;
        $insertid = $DB->insert_record('local_rewards', $insert);

        if($insertid) {
            redirect(new moodle_url('/local/rewards/manage.php')); 
        }
	
 }
 else {
  echo $OUTPUT->header();
  $mform->display();
  echo $OUTPUT->footer();
}