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
$userid = optional_param('id', 0, PARAM_INT);
require_once($CFG->dirroot . '/user/editlib.php');
require_once('removecredit_form.php');

$PAGE->set_url("/local/stripepayment/removecredit.php?id=$userid");
$PAGE->set_context(context_system::instance());

$mform_removecredit = new removecredit_form(null, $userid);

if ($mform_removecredit->is_cancelled()) {
  redirect("$CFG->wwwroot/admin/user.php");
}
else if ($data = $mform_removecredit->get_data()) {
  $credits = $data->credits_deducted;
  $userid = $data->userid;
  $sql = "SELECT * FROM {user_credits} uc
                   WHERE uc.userid = $userid AND uc.expire = 0 AND uc.status = 1 AND uc.total_credit_left != 0";
  $credit_purchased_records = $DB->get_records_sql($sql);
  $count = 1;
  $left_credits = 0;
  $credit_array = array();
  foreach ($credit_purchased_records as $credit_purchased_records_key => $credit_purchased_records_value) {
    $left_credits += $credit_purchased_records_value->total_credit_left;
    $credit_array[$credit_purchased_records_key] = $credit_purchased_records_value->total_credit_left;
    if ($left_credits >= $credits) {
      break;
    }
    $count++;
  }
  $already_adjusted = 0;
  $row = 1;
  $less_credit_mail = 0;
  foreach ($credit_array as $credit_array_key => $credit_array_value) {
    if ($count == $row) {
      $left = $credit_array_value - $credits;
    }
    else {
      $credits -= $credit_array_value;
      $left = 0;
    }
    $datanew = new stdClass();
    $datanew->id = $credit_array_key;
    $datanew->total_credit_left = $left;
    $DB->update_record('user_credits', $datanew);
    $row++;
  }
  $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
  if ($record = $DB->get_record('user_info_data', array('fieldid' => $fieldid, 'userid' => $userid))) {
    $balance = $record->data;
    $balance -= $data->credits_deducted;
    $sql = "update {user_info_data} set data = $balance where id=$record->id";
    if($DB->execute($sql)){
      redirect("$CFG->wwwroot/local/stripepayment/removecredit.php?id=$userid", get_string('credits_been_deducted', 'local_stripepayment'));
    }else{
      redirect("$CFG->wwwroot/local/stripepayment/removecredit.php?id=$userid", get_string('some_issue', 'local_stripepayment'));
    }
  }
}
else {

  $title = get_string('manual_credit', 'local_stripepayment');
  $PAGE->set_title($title);
  $PAGE->set_heading($SITE->fullname);
  $user = $DB->get_record('user', array('id' => $userid));
  $userfullname = fullname($user, true);

  echo $OUTPUT->header();
  echo $OUTPUT->heading($userfullname);
  $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
  $balance = $DB->get_field('user_info_data', 'data', array('fieldid' => $fieldid, 'userid' => $userid));
  $credits = ($balance > 0) ? $balance : 0;
  $total_credits = get_string('total_credits', 'local_stripepayment') . $credits;
  echo $OUTPUT->heading($total_credits);
  echo "</br></br>";
  echo $OUTPUT->heading(get_string('purchase_history', 'local_stripepayment'));
  echo html_writer::table(active_plans_user($userid));
  echo "</br></br>";
  $mform_removecredit->display();

  echo $OUTPUT->footer();
}

function active_plans_user($userid) {
  global $DB;
  $table = new html_table();
  $table->head = array(get_string('ord_no', 'local_stripepayment'), get_string('payment_method', 'local_stripepayment'), get_string('purchased_credit', 'local_stripepayment'),
    get_string('credit_left', 'local_stripepayment'),
    get_string('purchase_date', 'local_stripepayment'), get_string('expiry_date', 'local_stripepayment'));
  $table->size = array('16%', '16%', '16%', '16%', '16%', '16%');
  $table->attributes = array('class' => 'display');
  $table->align = array('center', 'center', 'center', 'center', 'center');
  $table->width = '100%';
  $records = $DB->get_records('user_credits', array('status' => 1, 'userid' => $userid, 'expire' => 0));
  if (!empty($records)) {
    foreach ($records as $recordkey => $recordvalue) {
      $row = array();
      $row[] = "ORD-" . $recordvalue->id;
      $payment_type = array('credit_card' => 'Stripe Top Up', 'manual' => 'Manual');
      $row[] = $payment_type[$recordvalue->payment_type];
      $row[] = $recordvalue->total_credit;
      $row[] = $recordvalue->total_credit_left;
      $row[] = date("d-M-Y", $recordvalue->timemodified);
      $row[] = date("d-M-Y", strtotime('+30 days', $recordvalue->timemodified));

      $table->data[] = $row;
    }
  }
  else {
    $table->data[] = array('', '', get_string('notfound', 'block_systemreports'), '', '');
  }
  return $table;
}
