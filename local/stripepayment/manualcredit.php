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
require_login();
$userid = optional_param('id',0, PARAM_INT);
require_once($CFG->dirroot . '/user/editlib.php');
require_once('manualcredit_form.php');

$PAGE->set_url("/local/stripepayment/manualcredit.php?id=$userid");
$PAGE->set_context(context_system::instance());

$mform_manualcredit = new manualcredit_form(null,$userid);

if ($mform_manualcredit->is_cancelled()) {
    redirect("$CFG->wwwroot/my");

} else if ($creditdata = $mform_manualcredit->get_data()) {
    $data = new stdClass();
    $userid = $creditdata->userid;
    $data->userid = $userid;
    $data->total_credit = $creditdata->manual_credit;
    $data->total_credit_consumed = 0;
    $data->total_credit_left = $creditdata->manual_credit;
    $data->expire = 0;
    $data->status = 1;
    $data->timemodified = time();
    $data->payment_type = 'manual';
    $DB->insert_record('user_credits', $data);
    
    $new_credit = $creditdata->manual_credit;
    $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
    if ($record =  $DB->get_record('user_info_data', array('fieldid' => $fieldid, 'userid' => $userid))) {
    $balance = $record->data;
    $balance += $new_credit;
    $sql = "update {user_info_data} set data = $balance where id=$record->id";
    $DB->execute($sql);
  }
  else {
    $payment = new stdClass();
    $payment->userid = $userid;
    $payment->fieldid = $fieldid;
    $payment->data = $new_credit;
    $payment->dataformat = 0;
    $insertid = $DB->insert_record('user_info_data', $payment);
  }
    redirect("$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid");
} else {
    

//$coursename = $DB->get_field('course', 'shortname', array('id' => $courseid));
//$courselink = new moodle_url('/course/view.php', array('id'=>$courseid));
//$PAGE->navbar->add($coursename,$courselink);
//$PAGE->navbar->add($feeddata);
//
$title = get_string('manual_credit', 'local_stripepayment');
$PAGE->set_title($title);
$PAGE->set_heading($SITE->fullname);
$user = $DB->get_record('user',array('id' => $userid));
$userfullname = fullname($user, true);

echo $OUTPUT->header();
echo $OUTPUT->heading($userfullname);
$mform_manualcredit->display();
echo $OUTPUT->footer();
}
