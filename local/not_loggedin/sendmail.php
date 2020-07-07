<?php


require_once('../../config.php');
//require_login();
global $DB;
$param = new stdClass();
//send mail with no login since past two weeks
$PAGE->set_url("/local/not_loggedin/table.php");
$PAGE->set_context(context_system::instance());
$days = 14;
$time = time() - (86400 * $days);

$sql = "SELECT u.id, u.email ,concat(u.firstname, ' ' , u.lastname) as fullname FROM {user} u INNER JOIN {role_assignments} ra ON ra.userid = u.id 
  INNER JOIN {context} ct ON ct.id = ra.contextid INNER JOIN {course} c ON c.id =ct.instanceid INNER JOIN {role}
  r ON r.id = ra.roleid INNER JOIN {course_categories} cc ON cc.id = c.category WHERE r.id =5 and u.lastlogin < $time";
  echo $sql;
  $records = $DB->get_records_sql($sql);

  foreach ($records as &$record) {$param->fullname = "$record->fullname";
    $param->fullname = "$record->firstname $record->lastname";
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
    $subject = get_string('not_logged_in_subject', 'local_not_loggedin');
    $message = get_string('not_logged_in_message', 'local_not_loggedin');
//    email_to_user($emailuser, $from, $subject, $message);
  }