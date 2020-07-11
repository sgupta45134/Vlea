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
 *
 * @package   local_send_enrol_message
 * @copyright  Sudhanshu Gupta<sudhanshug5@gmail.com>
 */
defined('MOODLE_INTERNAL') || die();

function send_enrol_message(\core\event\user_enrolment_created $event) {
  global $DB, $USER, $CFG;

  if ($event->other['enrol'] == 'credit') {
    $enrol_id = $DB->get_field('user_enrolments', 'enrolid', array('id' => $event->objectid));
    ;
    $credits = $DB->get_field('enrol', 'customint7', array('id' => $enrol_id));
    $userid = $event->userid;
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
      $less_credit_mail = $DB->get_field('user_credits', 'less_credit_mail', array('id' => $$credit_array_key));

      if ($left < 50 && $less_credit_mail == 0) {

        $sql = "SELECT u.id, u.parent_email ,u.parent as fullname FROM {user} u WHERE u.id =$userid and WHERE parent_email != 'NA'";

        $records = $DB->get_records_sql($sql);
        if (isset($records)) {
          foreach ($records as &$record) {
            $param->fullname = "$record->fullname";
            $emailuser->email = $record->email;
            $emailuser->firstname = $record->firstname;
            $emailuser->lastname = $record->lastname;
            $emailuser->maildisplay = true;
            $emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
            $emailuser->id = -99;
            $emailuser->firstnamephonetic = '';
            $emailuser->lastnamephonetic = '';
            $emailuser->middlename = '';
            $emailuser->alternatename = '';
            $from = \core_user::get_noreply_user();
            $subject = get_string('less_credit_subject', 'local_send_enrol_message');
            $message = get_string('less_credit_message', 'local_send_enrol_message', $param);
            if (email_to_user($emailuser, $from, $subject, $message)) {
              $less_credit_mail = 1;
            }
          }
        }
      }
      $data = new stdClass();
      $data->id = $credit_array_key;
      $data->less_credit_mail = $less_credit_mail;
      $data->total_credit_left = $left;
      $DB->update_record('user_credits', $data);
      $row++;
    }
  }
}
