<?php
/**
 * Copyright (C)  - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Unauthorized modification of this file is strictly prohibited
 * Proprietary and confidential
 */

use local_rewards\rewards_table;

require_once(dirname(__FILE__) . "/../../config.php");
require_once($CFG->libdir . '/adminlib.php');
require_once(dirname(__FILE__) . '/classes/rewards_form.php');
require_once(dirname(__FILE__) . '/lib.php');

$id        = required_param('id', PARAM_INT);

$context = context_system::instance();
require_login();

$url = new moodle_url('/local/rewards/edit.php', array('id'=>$id));
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_heading(get_string('pluginname', 'local_rewards'));
$PAGE->set_pagelayout('admin');

$cancelurl = new moodle_url('/local/rewards/manage.php');

$args = array('id'=>$id);
$mform = new rewards_form(null, $args);
if($mform->is_cancelled()) {
    redirect($cancelurl);
} else if ($fromform = $mform->get_data()) {
        $content = $mform->get_file_content('userfile');
        $newfilename = $mform->get_new_filename('userfile');

        $update                 = new stdClass();
        $update->id      		    =   $id;
        $update->prizename      =   $fromform->prizename;
        $update->description    =   $fromform->description;

        if(!empty($newfilename)) {
          $update->image          =   $newfilename;
        }
        
        $update->points         =   $fromform->points;
        $update->timemodified   =   time();
        $update->createdby      =   $USER->id;
        $updated = $DB->update_record('local_rewards', $update);

        if($updated) {
            if(!empty($newfilename)) {
              $fmoptions = rewards_filepicker_options();
              $fileapiparams = file_api_params();
              $tempfile = $mform->save_stored_file(
                  'userfile',
                  $context->id,
                  $fileapiparams['component'],
                  $fileapiparams['tempfilearea'],
                  $id,
                  $fileapiparams['filepath'],
                  $newfilename,
                  true
              );

              $newfile = set_file_from_stored_file($tempfile, $newfilename, $id);
            }
            redirect(new moodle_url('/local/rewards/manage.php'));
        }
	
 }
 else {
  echo $OUTPUT->header();
  $row = get_single_record($id);
  $mform->set_data($row);
  $mform->display();
  echo $OUTPUT->footer();
}