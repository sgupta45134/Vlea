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
$userid = optional_param('id', 0, PARAM_INT);

?>
        <script>
function onSelectcourse(select) {
  var plan = select;
  $('#id_selected_plan').val(plan);
};
</script>
<?php
require_once($CFG->dirroot . '/user/editlib.php');
require_once('manualcredit_form.php');

$PAGE->set_url("/local/stripepayment/manualcredit.php?id=$userid");
$PAGE->set_context(context_system::instance());

$mform_manualcredit = new manualcredit_form(null, $userid);

if ($mform_manualcredit->is_cancelled()) {
  redirect("$CFG->wwwroot/admin/user.php");
}
else if ($creditdata = $mform_manualcredit->get_data()) {
  if ($creditdata->submitbutton == 'Refund Credits') {
          $userid = $creditdata->userid;
      if(empty($creditdata->selected_plan)){
//        print_error('please_select_plan','local_stripepayment', "$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid");
        redirect("$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid", get_string('please_select_plan', 'local_stripepayment'));
      }
    //update the credit in the user_credit table
      $records = $DB->get_record('user_credits',array('id'=>$creditdata->selected_plan));
      $left_credit = $records->total_credit_left;
      if(($creditdata->credits_refund + $left_credit) > $records->total_credit){
         redirect("$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid", get_string('refund_exceed', 'local_stripepayment'));
      }
      $new_left_credit =  $left_credit + $creditdata->credits_refund;
      $sql = "update {user_credits} set total_credit_left = $new_left_credit where id = $creditdata->selected_plan";
      $DB->execute($sql);
     //update info data
      $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
      $record = $DB->get_record('user_info_data', array('fieldid' => $fieldid, 'userid' => $userid));
      $balance = $record->data;
      $balance += $creditdata->credits_refund;
      $sql = "update {user_info_data} set data = $balance where id=$record->id";
      $DB->execute($sql);
      redirect("$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid", get_string('credit_refund', 'local_stripepayment'));
    
  }
  elseif ($creditdata->submitbutton == 'Add Credits') {
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
    if ($record = $DB->get_record('user_info_data', array('fieldid' => $fieldid, 'userid' => $userid))) {
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
  }
  else {
    redirect("$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid", get_string('some_issue', 'local_stripepayment'));
  }
  redirect("$CFG->wwwroot/local/stripepayment/manualcredit.php?id=$userid", get_string('credit_assigned', 'local_stripepayment'));
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
  $mform_manualcredit->display();

  echo $OUTPUT->footer();
}

function active_plans_user($userid) {
  global $DB;
  $table = new html_table();
  $table->head = array(get_string('payment_method', 'local_stripepayment'), get_string('purchased_credit', 'local_stripepayment'),
    get_string('credit_left', 'local_stripepayment'),
    get_string('purchase_date', 'local_stripepayment'), get_string('expiry_date', 'local_stripepayment'));
  $table->size = array('20%', '20%', '20%', '20%', '20%');
  $table->attributes = array('class' => 'display');
  $table->align = array('center', 'center', 'center', 'center', 'center');
  $table->width = '100%';
  $records = $DB->get_records('user_credits', array('status' => 1, 'userid' => $userid, 'expire' => 0));
  if (!empty($records)) {
    foreach ($records as $recordkey => $recordvalue) {
      $row = array();
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
