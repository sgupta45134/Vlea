<?php
/**
 * Copyright (C) Lingel Learning Pty Ltd - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Unauthorized modification of this file is strictly prohibited
 * Proprietary and confidential
 * Written by Sandeep Gill <sandeep@lingellearning.com>, January 2018
 */

use block_vslate_quicklinks\form\quicklink_form;
use block_vslate_quicklinks\helper;
use block_vslate_quicklinks\persistent\Quicklink;
use core\notification;

/**
 * @package    block_vslate_quicklinks
 * @copyright  2018 Sandeep Gill {@link http://lingellearning.com}
 */

require_once(dirname(__FILE__) . "/../../config.php");
require_once($CFG->libdir . '/adminlib.php');
require_once(dirname(__FILE__) . '/classes/rewards_form.php');
require_once(dirname(__FILE__) . '/lib.php');

defined('MOODLE_INTERNAL') || die;

$id        = required_param('id', PARAM_INT);

$context = context_system::instance();
require_login();

$url = new moodle_url('/local/rewards/edit.php', array('id'=>$id));
$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_heading(get_string('edit_quicklink', 'block_vslate_quicklinks'));
$PAGE->set_pagelayout('admin');

$url = new moodle_url('/local/rewards/edit.php');
$cancelurl = new moodle_url('/local/rewards/manage.php');

$args = array('id'=>$id);
$mform = new rewards_form(null, $args);
if($mform->is_cancelled()) {
    redirect(new moodle_url('/local/rewards/manage.php'));
} else if ($fromform = $mform->get_data()) {
        $update                 = new stdClass();
        $update->id      		    =   $id;
        $update->prizename      =   $fromform->prizename;
        $update->description    =   $fromform->description;
        $update->image          =   'default-image.jpg';
        $update->points         =   $fromform->points;
        $update->timemodified   =   time();
        $update->createdby      =   $USER->id;
        $updated = $DB->update_record('local_rewards', $update);

        if($updated) {
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