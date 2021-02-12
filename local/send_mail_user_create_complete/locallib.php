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
 * @package   local_send_mail_user_create_complete
 * @copyright  Sudhanshu Gupta<sudhanshug5@gmail.com>
 */
defined('MOODLE_INTERNAL') || die();

function send_mail_user_create(\core\event\user_created $event) {
  //Send mail on user creation
  global $DB, $USER, $CFG;
  require_once($CFG->libdir . '/moodlelib.php');
  $user = $DB->get_record('user', array('id' => $event->objectid));
  $name = $user->firstname . ' ' . $user->lastname;
  $config = get_config('local_send_mail_user_create_complete');
  $emailuser->email = $config->email;
  $emailuser->firstname = 'Assessor';
  $emailuser->lastname = '';
  $emailuser->maildisplay = true;
  $emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
  $emailuser->id = -99;
  $emailuser->firstnamephonetic = '';
  $emailuser->lastnamephonetic = '';
  $emailuser->middlename = '';
  $emailuser->alternatename = '';
  $from = \core_user::get_noreply_user();
  $subject = get_string('user_created', 'local_send_mail_user_create_complete');
  $message = "A new user named $name has been created in the system";
  email_to_user($emailuser, $from, $subject, $message);
}

//function send_mail_complete(\core\event\course_completed $event) {
//  //Send mail on course enrolment
//  global $DB, $USER, $CFG;
//  require_once($CFG->libdir . '/moodlelib.php');
//  $courseid = $event->courseid;
//  $course_name = $DB->get_field('course', 'fullname', array('id' => $courseid));
//  $user = $DB->get_record('user', array('id' => $event->other['relateduserid']));
//  $name = $user->firstname . ' ' . $user->lastname;
//  $context = context_course::instance($event->courseid);
//  $roleid = $DB->get_field('role', 'id', array('shortname' => 'manager'));
//  $enrolled_user = get_enrolled_users($context, null, null, 'u.id');
//  $touser = '';
//  foreach ($enrolled_user as &$userid) {
//    if (user_has_role_assignment($userid->id, $roleid)) {
//      $touser = $DB->get_record('user', array('id' => $userid->id));
//      break;
//    }
//  }
//  if (empty($touser)) {
//    $config = get_config('local_send_mail_user_create_complete');
//    $touser->email = $config->adminemail;
//    $touser->firstname = 'Admin';
//    $touser->id = -100;
//    $touser->lastname = '';
//    $touser->maildisplay = true;
//    $touser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
//    $touser->firstnamephonetic = '';
//    $touser->lastnamephonetic = '';
//    $touser->middlename = '';
//    $touser->alternatename = '';
//  }
//  $from = \core_user::get_noreply_user();
//  $subject = get_string('course_complete', 'local_send_mail_user_create_complete');
//  $message = "$name has completed the course $course_name Successfully";
//  email_to_user($touser, $from, $subject, $message);
//}

function send_enrol_mail(\core\event\user_enrolment_created $event) {
  global $DB, $USER, $CFG;
  $courseid = $event->courseid;
  $course_name = $DB->get_field('course', 'fullname', array('id' => $courseid));

  require_once($CFG->libdir . '/moodlelib.php');
  $user = $DB->get_record('user', array('id' => $event->relateduserid));
  $from = \core_user::get_noreply_user();
  $subject = get_string('subject', 'local_send_mail_user_create_complete');
//  $messageuser = "You have been enrolled in the course $course_name";
//  email_to_user($user, $from, $subject, $messageuser);
  
  //Send mail to Assessor
  $name = $user->firstname . ' ' . $user->lastname;
  $config = get_config('local_send_mail_user_create_complete');
  $emailuser->email = $config->email;
  $emailuser->firstname = 'Assessor';
  $emailuser->lastname = '';
  $emailuser->maildisplay = true;
  $emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
  $emailuser->id = -99;
  $emailuser->firstnamephonetic = '';
  $emailuser->lastnamephonetic = '';
  $emailuser->middlename = '';
  $emailuser->alternatename = '';
  $message = "A new user named $name has been enrolle in the course named:$course_name";
  email_to_user($emailuser, $from, $subject, $message);
}