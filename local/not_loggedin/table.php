<?php

require_once('../../config.php');
//require_login();
global $DB;
//send mail with no login since past two weeks
$PAGE->set_url("/local/not_loggedin/table.php");
$PAGE->set_context(context_system::instance());
$days = 14;
$time = time() - (86400 * $days);

$PAGE->set_title('User Not Login');
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

$count = 0;
$sql = "SELECT count(u.id) as count FROM {user} u INNER JOIN {role_assignments} ra ON ra.userid = u.id 
  INNER JOIN {context} ct ON ct.id = ra.contextid INNER JOIN {course} c ON c.id =ct.instanceid INNER JOIN {role}
  r ON r.id = ra.roleid INNER JOIN {course_categories} cc ON cc.id = c.category WHERE r.id =5 and u.lastlogin < $time order by u.lastlogin";
  $records = $DB->get_records_sql($sql);
  print_object($records);die;
$count = $DB->count_records_sql($sql);
echo $count; die;
$head = 'User Not Login(Past 2 Weeks): '.$count;
echo $OUTPUT->heading('User Not Login(Past 2 Weeks):');
echo html_writer::table(active_plans_user($time));
echo $OUTPUT->footer();

function active_plans_user($time) {
  global $DB;
  $table = new html_table();
  $table->head = array('id', 'Email Address', 'Fullname', 'Last login');
  $table->size = array('16%', '16%', '16%', '16%', '16%', '16%');
  $table->attributes = array('class' => 'display');
  $table->align = array('center', 'center', 'center', 'center', 'center');
  $table->width = '100%';
  $sql = "SELECT u.id, u.email ,concat(u.firstname, ' ' , u.lastname) as fullname, u.lastlogin FROM {user} u INNER JOIN {role_assignments} ra ON ra.userid = u.id 
  INNER JOIN {context} ct ON ct.id = ra.contextid INNER JOIN {course} c ON c.id =ct.instanceid INNER JOIN {role}
  r ON r.id = ra.roleid INNER JOIN {course_categories} cc ON cc.id = c.category WHERE r.id =5 and u.lastlogin < $time order by u.lastlogin";
  $records = $DB->get_records_sql($sql);
  if (!empty($records)) {
    foreach ($records as $recordkey => $recordvalue) {
      $row = array();
      $row[] = $recordvalue->id;
      $row[] = $recordvalue->email;
      $row[] = $recordvalue->fullname;
      $row[] = date("d-M-Y", $recordvalue->lastlogin);
      $table->data[] = $row;
    }
  }
  else {
    $table->data[] = array('', '', get_string('notfound', 'block_systemreports'), '', '');
  }
  return $table;
}
