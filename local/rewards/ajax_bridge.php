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
 * @package    block_learning_plan
 * @copyright  3i Logic<lms@3ilogic.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @author     Azmat Ullah <azmat@3ilogic.com>
 */
require_once '../../config.php';
require_once "lib.php";
global $DB, $USER;
$attributes = array();

$action  = optional_param('action', null, PARAM_RAW);
$prizeid = optional_param('prizeid', null, PARAM_INT);

if (!isloggedin()) {
    redirect($CFG->wwwroot);
}

require_login(null, false);
$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/rewards/ajax_bridge.php');

$userid = $USER->id;
$i = 0;
$points = 0;
$reward_points = $DB->get_record_sql("select uid.id, uid.data from {user_info_data} uid
	join {user_info_field} uif on uif.id = uid.fieldid where shortname = 'reward_points' AND uid.userid = $userid");
if(!empty($reward_points)) {
	$points = $reward_points->data;
}

if ($action == 'redeem') {
	$prizedetails = get_prize_details($prizeid);
	$prizecost = $prizedetails->points;
	$prizeimage = get_image_url($prizedetails->image);

	if(empty($points) || ($points < $prizecost)) {
		echo "<h3 class='warning-alert'>Sorry you don't have enough points to redeem this award</h3>";
		die();
	}

    $profilefields = new stdClass();
    $remainingpoints = $points - $prizecost;
    $profilefields->profile_field_reward_points = $remainingpoints;

    if (!empty($profilefields)) {
        $profilefields->id = $userid;
        profile_save_data($profilefields);
        $data = new stdClass;
        $data->userid = $userid;
        $data->prizeid = $prizeid;

        save_prize_redemption($data);
        echo "<h3 class='suceess'>Prize redeemed</h3>";
        $senderemail = 'contact@vleacademy.com'; // Replace admin email id
        $receiver = $USER;
        $message = "<h4>You have suceessfully redeemed the following prize</h4>
        	<table>
        		<tr>
        			<th>Serial no</th>
        			<th>Prize name</th>
        			<th>Prize image</th>
        			<th>Prize points</th>
        			<th>Points remaining</th>
        		</tr>
        		<tr>
        			<td>01</td>
        			<td>$prizedetails->prizename</td>
        			<td><img style='height:100px;width:100px;' src='".$prizeimage."' alt='Prizeimage' /></td>
        			<td>$prizedetails->points</td>
        			<td>$remainingpoints</td>
        		</tr>
        	</table>";
        	$subject = 'Prize redemption';
        send_acknowledement_mail_to_user($senderemail, $receiver, $message, $subject);
        $receiveremail = "contact@vleacademy.com"; // Replace admin email id
        $message = 'The following user has claimed prize
        			<table><tr><td>'.$USER->firstname.' '.$USER->lastname.'('.$USER->email.')</td></tr>
        			<tr><td>'.$prizedetails->prizename.'</td><td><img style="height:100px;width:100px;" src='.$prizeimage.' /></td></tr></table>
        			';
        send_acknowledement_mail_to_admin($senderemail, $receiveremail, $message, $subject);
        die();
    }
    

}