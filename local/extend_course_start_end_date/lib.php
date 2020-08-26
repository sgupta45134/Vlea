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

function extend_course_start_end_date_cron() {

global $DB;
$time = time();
$sql = "SELECT * from {course} where enddate < $time and enable = 1";
$records = $DB->get_records_sql($sql);
foreach($records as $recordkey => $record){
  $delay = $record->repeat_delay * 3600;
  $expiretime = $time + strtotime('+7 days');
  $data = new stdClass();
  $data->id = $record->id;
  $data->startdate =  strtotime('+7 days') + $delay;
  $data->enddate =  strtotime('+14 days') + $delay;
  $DB->update_record('course', $data);
}
}
