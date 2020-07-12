<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful, $
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require_once(dirname(__FILE__) . '/../../config.php');

function expire_reminder_email_cron() {

  global $DB, $CFG;
  $time = time() + strtotime('-23 days');
  $expiretime = $time + strtotime('+30 days');
  $expiredate = date('d/m/Y', $expiretime);
  $param = new stdClass();
  $param->expiredate = $expiredate;
  $sql = "SELECT u.id, u.parent_email, uc.id as credit_id  , u.parent as fullname FROM {user} u INNER JOIN {user_credits} uc ON uc.userid = u.id
    WHERE uc.status = 1 and uc.expire = 0 and uc.timemodified = $time and uc.expire_reminder_mail = 0 and u.parent_email != 'NA'";
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
      $subject = get_string('expire_reminder_emailsubject', 'expire_reminder_email' , $param);
      $message = get_string('expire_reminder_email_message', 'expire_reminder_email',$param);
//      if (email_to_user($emailuser, $from, $subject, $message)) {
//        $data = new stdClass();
//        $data->id = $record->credit_id;
//        $data->expire_reminder_mail = 1;
//        $DB->update_record('user_credits', $data);
//      }
    }
  }
}
