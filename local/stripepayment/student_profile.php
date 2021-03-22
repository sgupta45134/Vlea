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
 * user trainer_record page.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
require_once('lib.php');
require_login();
$paymentid = optional_param('p', 0, PARAM_INT);
global $USER, $DB;
$school_name = $DB->get_field('user','school',array('id'=>$USER->id));
$parents_email = $DB->get_field('user','school',array('id'=>$USER->id));
if(($school_name != 'NA' && $parents_email != 'NA') || is_siteadmin()){
  redirect(new moodle_url('/local/stripepayment/payment.php?p='.$paymentid));
}
require_once($CFG->dirroot . '/user/editlib.php');
require_once('student_profile_form.php');

$PAGE->set_url("/local/stripepayment/student_profile.php?p=$paymentid");
$PAGE->set_context(context_system::instance());

$mform_student_profile = new student_profile_form(null, $paymentid);

if ($mform_student_profile->is_cancelled()) {
  redirect("$CFG->wwwroot/admin/user.php");
}
else if ($data = $mform_student_profile->get_data()) {
  $data->id = $USER->id;
  $paymentid = $data->paymentid;
  $update = $DB->update_record('user', $data);
  $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
  if ($DB->update_record('user', $data)) {
      redirect("$CFG->wwwroot/local/stripepayment/student_profile.php?p=$paymentid", get_string('record_updated', 'local_stripepayment'));
    }else{
      redirect("$CFG->wwwroot/local/stripepayment/student_profile.php?p=$paymentid", get_string('some_issue', 'local_stripepayment'));
    }
  }
else {

  $title = get_string('manual_credit', 'local_stripepayment');
  $PAGE->set_title($title);
  $PAGE->set_heading($SITE->fullname);
  $user = $DB->get_record('user', array('id' => $USER->id));
  $userfullname = fullname($user, true);
  echo $OUTPUT->header();
  $heading = get_string('update_profile_first', 'local_stripepayment').$userfullname;
  echo $OUTPUT->heading($heading);
  $mform_student_profile->display();
  echo $OUTPUT->footer();

}

