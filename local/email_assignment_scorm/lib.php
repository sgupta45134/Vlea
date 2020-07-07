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

function email_assignment_scorm_cron(){

global $DB, $CFG;
$time = time();
$date = '"'.date('d-m-Y', strtotime('-30 days')).'"';
$fieldid = $DB->get_field('user_info_field','id',array('shortname' => 'user_credits'));
$sql = "SELECT * FROM `mdl_user_credits` where expire = 0 AND status = 1 AND from_unixtime(timemodified, '%d-%m-%Y') = $date";
$records = $DB->get_records_sql($sql);
if(isset($records)){
foreach($records as $key => $value){
      $data = new stdClass();
      $data->id = $value->id;
      $data->expire = 1;
      if($DB->update_record('user_credits', $data) && $value->total_credit_left != 0){  
      $balance = $DB->get_field('user_info_data','data',array('fieldid' => $fieldid,'userid' => $value->userid));
      $id = $DB->get_field('user_info_data','id',array('fieldid' => $fieldid,'userid' => $value->userid));
      $datanew = new stdClass();
      $datanew->id = $id;
      $datanew->data = $balance - $value->total_credit_left;
//      if($DB->update_record('user_info_data', $datanew)){  
//      }
}
}
}
}