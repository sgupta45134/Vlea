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
 * This plugin serves as a database and plan for all learning activities in the organization,
 * where such activities are organized for a more structured learning program.
 * @package    block_systemreports
 * @copyright  3i Logic<lms@3ilogic.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @author     Azmat Ullah <azmat@3ilogic.com>
 */
require_once("{$CFG->libdir}/formslib.php");

/**
 * Class for add a learning plan.
 *
 * @copyright 3i Logic<lms@3ilogic.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class learningplan_form extends moodleform {

  
  public function definition() {
    
  }

  public function validation($data, $files) {
    
  }

  public function display_list() {
    global $DB, $OUTPUT, $CFG;
    // Page parameters.
    $yearid = optional_param('year', 0, PARAM_INT);

    $table = new html_table();
    $table->head = array(get_string('enrol_date', 'block_systemreports'), get_string('student_name', 'block_systemreports'),
      get_string('category', 'block_systemreports'),get_string('course_name', 'block_systemreports'));
    $table->size = array('20%', '20%', '20%', '20%', '20%');
    $table->attributes = array('class' => 'display');
    $table->align = array('center', 'left', 'left', 'center');
    $table->width = '100%';
    $sql = "Select ue.*, concat(u.firstname,' ', u.lastname) as fullname, c.fullname as coursename, cat.name as categoryname from {user_enrolments} as ue left join {user} as u on ue.userid = u.id left join "
        . "{enrol} as e on e.id = ue.enrolid left join {course} as c on e.courseid = c.id left join {course_categories} as cat on cat.id = c.category";
    $records = $DB->get_records_sql($sql);
    if (!empty($records)) {
      foreach ($records as $recordkey => $recordvalue) {
        $row = array();
        $row[] = date("d-M-Y", $recordvalue->timemodified);;
        $row[] = $recordvalue->fullname;
        $row[] = $recordvalue->categoryname;
        $row[] = $recordvalue->coursename;

        $table->data[] = $row;
      }
    }
    else {
      $table->data[] = array('', '', get_string('notfound', 'block_systemreports'), '', '');
    }
    return $table;
    // echo html_writer::table($table);
  }

}

/**
 * Class for assign users in to a learning plan.
 *
 * @copyright 3i Logic<lms@3ilogic.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class my_credit_history_form extends moodleform {

public function definition() {
    
  }

  public function validation($data, $files) {
    
  }

  public function display_list() {
    global $DB, $OUTPUT, $CFG, $USER;
    // Page parameters.
    $table = new html_table();
    $table->head = array(get_string('course_name', 'block_systemreports'), get_string('category', 'block_systemreports'),
               get_string('credits', 'block_systemreports'), get_string('enrol_date', 'block_systemreports'),
      );
    $table->size = array('20%', '20%', '20%', '20%', '20%');
    $table->attributes = array('class' => 'display');
    $table->align = array('center', 'left', 'left', 'center');
    $table->width = '100%';
    $sql = "Select ue.*, concat(u.firstname,' ', u.lastname) as fullname, e.customint7 as credits, c.fullname as coursename, cat.name as categoryname from {user_enrolments} as ue left join {user} as u on ue.userid = u.id left join "
        . "{enrol} as e on e.id = ue.enrolid left join {course} as c on e.courseid = c.id left join {course_categories} as cat on cat.id = c.category where u.id = $USER->id and e.enrol = 'credit'";
    $records = $DB->get_records_sql($sql);
    if (!empty($records)) {
      foreach ($records as $recordkey => $recordvalue) {
        $row = array();
        $row[] = $recordvalue->coursename;
        $row[] = $recordvalue->categoryname;
        $row[] = $recordvalue->credits;
        $row[] = date("d-M-Y", $recordvalue->timemodified);;

        $table->data[] = $row;
      }
    }
    else {
      $table->data[] = array('', '', get_string('notfound', 'block_systemreports'), '', '');
    }
    return $table;
    // echo html_writer::table($table);
  }

}

/**
 * Class for assign trainings in to a learning plan.
 *
 * @copyright 3i Logic<lms@3ilogic.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class my_purchase_history_form extends moodleform {

  public function definition() {
    
  }

  public function validation($data, $files) {
    
  }

  public function display_list() {
  global $DB,$USER;
  $userid = $USER->id;
  $table = new html_table();
  $table->head = array(get_string('payment_method', 'local_stripepayment'), get_string('plan', 'block_systemreports'),
    get_string('purchased_credit', 'local_stripepayment'),
    get_string('purchase_date', 'local_stripepayment'), get_string('expiry_date', 'local_stripepayment'));
  $table->size = array('16%', '16%', '16%', '16%', '16%', '16%');
  $table->attributes = array('class' => 'display');
  $table->align = array('center', 'center', 'center', 'center', 'center');
  $table->width = '100%';
  $records = $DB->get_records('user_credits', array('status' => 1, 'userid' => $userid, 'expire' => 0));
  $plan = array(180 => 'Essential', 320 => 'Premium', 500 => 'Ultimate');
  if (!empty($records)) {
    foreach ($records as $recordkey => $recordvalue) {
      $row = array();
      $payment_type = array('credit_card' => 'Stripe Top Up', 'manual' => 'Manual');
      $row[] = $payment_type[$recordvalue->payment_type];
      $row[] = $plan[$recordvalue->total_credit];
      $row[] = $recordvalue->total_credit;
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

}

/**
 * Class to set user's trainings status.
 *
 * @copyright 3i Logic<lms@3ilogic.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class trainingstatus_form extends moodleform {

  public function definition() {
    
  }

  public function display_list() {
    global $DB, $OUTPUT, $CFG;
    // Page parameters.
    $yearid = optional_param('year', 0, PARAM_INT);
    $table = new html_table();
    $table->head = array(get_string('s_no', 'block_systemreports'), get_string('max_course_completed', 'block_systemreports'),
      get_string('student_name', 'block_systemreports'), get_string('courses', 'block_systemreports'));
    $table->size = array('10%', '35%', '25%');
    $table->attributes = array('class' => 'display');
    $table->align = array('center', 'left', 'left', 'center');
    $table->width = '100%';
    $yearlist = array();
    for ($i = 2019; $i <= date("Y"); $i++)
      $yearlist["$i"] = $i;
    if ($yearid != 0) {
      $startyear = strtotime("01-01-" . $yearid);
      $currentyear = strtotime("31-12-" . $yearid);
    }
    else {
      $startyear = strtotime("01-01-2019");
      $currentyear = strtotime("31-12-" . date("Y"));
    }
    echo $OUTPUT->single_select(new moodle_url('?viewpage=6', array()), 'year', $yearlist, $yearid, 'Select Year', '', array('label' => 'Select Year'));
    $query = "SELECT concat(c.id,u.id) as roll,  concat(u.firstname ,' ', u.lastname) as fullname, u.id
                  FROM {course} AS c JOIN {context} AS ctx ON c.id = ctx.instanceid JOIN {role_assignments} 
                  AS ra ON ra.contextid = ctx.id JOIN {user} AS u ON u.id = ra.userid WHERE ra.roleid =5 AND ctx.instanceid = c.id";
    $record = $DB->get_records_sql($query);
    $system_students = array();
    $system_students_name = array();

    foreach ($record as $recordkey => $recordvalue) {
      $system_students[] = $recordvalue->id;
      $system_students_name[$recordvalue->id] = $recordvalue->fullname;
    }
    $student_unique = array_unique($system_students);
    $ids = join("','", $student_unique);
    $query = "SELECT userid, count(*) as completed FROM {course_completions} WHERE (userid) IN ('$ids') AND `timecompleted` <= $currentyear and `timecompleted` >= $startyear and timecompleted is not NULL group by userid ORDER BY completed DESC";
    $completed = $DB->get_records_sql($query);
    $student_completed = array();
    foreach ($student_unique as $student_id) {
      $student_completed[$student_id] = isset($completed[$student_id]->completed) ? $completed[$student_id]->completed : 0;
    }
    arsort($student_completed);
    $inc = 1;
    if (!empty($student_unique)) {
      foreach ($student_completed as $student_completed_key => $student_completed_value) {
        $row = array();
        $row[] = $inc;
        $row[] = $student_completed_value;
        $row[] = "$system_students_name[$student_completed_key]";
        $row[] = '<button type="button" id="courses-list" class="btn btn-primary" userid="' . $student_completed_key . '" startyear="' . $startyear . '" currentyear="' . $currentyear . '"data-toggle="modal" data-target="#myModal">
                         View Courses
                      </button>';
        ?>
        <html lang="en">
            <body>

                <div class="container">
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </body>
        </html>
        <?php
        $table->data[] = $row;
        $inc++;
      }
    }
    else {
      $table->data[] = array('', '', get_string('notfound', 'block_systemreports'), '', '');
    }
    return $table;
  }

}

/**
 * Class to set user's trainings status.
 *
 * @copyright 3i Logic<lms@3ilogic.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class highest_lowest_grade extends moodleform {

  public function definition() {
    
  }

  public function display_list() {
    global $DB, $OUTPUT, $CFG;
    $course = optional_param('course', 1, PARAM_INT);
    $quizid = optional_param('quiz', 0, PARAM_INT);
    $yearid = optional_param('year', 0, PARAM_INT);

    $courselist = array();
    $courses = get_courses();
    if (!empty($courses)) {
      foreach ($courses as $courseid) {
        if ($courseid->id == 1)
          continue;
        $courselist[$courseid->id] = $courseid->fullname;
      }
    }

    $quizmoduleid = $DB->get_field('modules', 'id', array('name' => 'quiz'));
    $quizsql = "SELECT q.id, q.name, cm.id as cmid, q.course as courseid 
			from {course_modules} cm
			JOIN {quiz} q ON cm.instance = q.id
			WHERE q.course = $course 
			AND cm.module= $quizmoduleid
			";
    $quizzes = $DB->get_records_sql($quizsql);
    $quizlist = array();
    if (!empty($quizzes)) {
      foreach ($quizzes as $quiz) {
        $quizlist[$quiz->id] = $quiz->name;
      }
    }
    $yearlist = array();
    for ($i = 2019; $i <= date("Y"); $i++)
      $yearlist["$i"] = $i;
    if ($yearid != 0) {
      $startyear = strtotime("01-01-" . $yearid);
      $currentyear = strtotime("31-12-" . $yearid);
    }
    else {
      $startyear = strtotime("01-01-2019");
      $currentyear = strtotime("31-12-" . date("Y"));
    }
    echo $OUTPUT->single_select(new moodle_url('?viewpage=7', array('quiz' => $quizid)), 'course', $courselist, $course, 'Choose Course', array(), array('label' => 'Select Course'));
    echo $OUTPUT->single_select(new moodle_url('?viewpage=7', array('course' => $course)), 'quiz', $quizlist, $quizid, 'Choose Assessment', '', array('label' => 'Select Assessment'));
    echo $OUTPUT->single_select(new moodle_url('?viewpage=7', array('course' => $course, 'quiz' => $quizid)), 'year', $yearlist, $yearid, 'Select Year', '', array('label' => 'Select Year'));
    // Page parameters.
    $userlist = array();
    $users = $DB->get_records_sql("SELECT u.id as id, c.id as courseid, CONCAT(u.firstname,' ', u.lastname) as fullname FROM {user} u INNER JOIN {role_assignments} ra ON ra.userid = u.id INNER JOIN {context} ct ON ct.id = ra.contextid INNER JOIN {course} c ON c.id =ct.instanceid INNER JOIN {role} r ON r.id = ra.roleid  WHERE r.id =5 and c.id = $course 
            and u.suspended = 0 and u.deleted = 0");

    if (!empty($users)) {
      foreach ($users as $user) {
        $userlist[$user->id] = $user->fullname;
      }
    }
    $table = new html_table();
    $table->head = array(get_string('s_no', 'block_systemreports'), get_string('student_name', 'block_systemreports'),
      get_string('marks_in_quiz', 'block_systemreports'));
    $table->size = array('10%', '35%', '25%');
    $table->attributes = array('class' => 'display');
    $table->align = array('center', 'left', 'left', 'center');
    $table->width = '100%';
    $inc = 1;
    $query = "SELECT id, userid, grade from {quiz_grades} where `timemodified` < $currentyear and `timemodified` > $startyear and quiz = $quizid ORDER BY grade DESC ";
//       echo $query;die;
    $quiz_grades = $DB->get_records_sql($query);
    $quiz_grade_id = array();
    if (!empty($quiz_grades)) {
      foreach ($quiz_grades as $quiz_grade) {
        $quiz_grade_id[$quiz_grade->userid] = $quiz_grade->grade;
      }
    }
    if (!empty($quiz_grade_id)) {
      foreach ($quiz_grade_id as $quiz_grade_id_key => $quiz_grade_id_value) {
        $row = array();
        $row[] = $inc;
        $row[] = $userlist[$quiz_grade_id_key];
        $row[] = ($quiz_grade_id_value != 0) ? substr($quiz_grade_id_value, 0, 5) : '0.0';

        $table->data[] = $row;
        $inc++;
      }
    }
    else if ($quizid == 0) {
      $table->data[] = array('', get_string('choose_assessment', 'block_systemreports'), '');
    }
    else {
      $table->data[] = array('', get_string('no_one_graded', 'block_systemreports'), '');
    }
    return $table;
  }

}

/**
 * Class for assign trainings in to a learning plan.
 *
 * @copyright 3i Logic<lms@3ilogic.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class assigntraining_learningplan__form extends moodleform {

  public function definition() {
    
  }

  public function validation($data, $files) {
    
  }

  public function display_list() {
    global $DB, $OUTPUT, $CFG;
    // Page parameters.
    $yearid = optional_param('year', 0, PARAM_INT);

    $table = new html_table();
    $table->head = array(get_string('order_date', 'block_systemreports'), get_string('s_no', 'block_systemreports'),
      get_string('order_item', 'block_systemreports') ,get_string('name', 'block_systemreports'), get_string('paid', 'block_systemreports')
      , get_string('payment_method', 'block_systemreports'), get_string('delete', 'block_systemreports'));
    $table->size = array('20%', '20%', '20%', '20%', '20%');
    $table->attributes = array('class' => 'display');
    $table->align = array('center', 'left', 'left', 'center');
    $table->width = '100%';
    $sql = "Select uc.*, u.firstname from {user_credits} as uc left join {user} as u on uc.userid = u.id where uc.status =1";
    $records = $DB->get_records_sql($sql);
//    $records = $DB->get_records('user_credits', array('status' => 1));
    if (!empty($records)) {
      foreach ($records as $recordkey => $recordvalue) {
        $row = array();
        $row[] = date("d-M-Y", $recordvalue->timemodified);
        $row[] = "ORD-$recordvalue->id";
        $row[] = $recordvalue->total_credit . ' credits';
        $row[] = $recordvalue->firstname;
        $row[] = $recordvalue->total_credit . ".00";
        $row[] = $recordvalue->payment_type;
        $content = '<button type="button" id="viewdetail_' . $recordvalue->id . '" class="btn btn-primary viewdetail">
                             Delete
                          </button>';
        // $learning_plan_details = systemreports_learningplan_details($lprecord->id, $lp, $lprecord->stage);

        $cell = new html_table_cell($content);
        $cell->attributes['rowspan'] = 2;
        $row[] = $cell;

        $table->data[] = $row;
      }
    }
    else {
      $table->data[] = array('', '', get_string('notfound', 'block_systemreports'), '', '');
    }
    return $table;
  }

}
?>