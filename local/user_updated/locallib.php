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
 * Signup event handlers
 *
 * @package    enrol_signup
 * @copyright  2011 Qontori Pte Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/formslib.php');
require_once($CFG->libdir . '/moodlelib.php');

/**
 * Event handler for signup enrol plugin.
 */
class local_user_updated_handler {

    public static function user_updated (\core\event\user_updated $event) {
        global $CFG, $DB;
     $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
    $balance = $DB->get_field('user_info_data', 'data', array('fieldid' => $fieldid, 'userid' => $event->relateduserid));
    $fieldid_subscribed_plan = $DB->get_field('user_info_field', 'id', array('shortname' => 'subscribed_plan'));
    $subscribed_plan_data= $DB->get_field('user_info_data', 'data', array('fieldid' => $fieldid_subscribed_plan, 'userid' => $event->relateduserid));
        $data = new stdClass();
        $data->userid = $event->relateduserid;
        $data->actionuserid = $event->userid;
        $data->credit = $balance;
        $data->plan = $subscribed_plan_data;
        $data->timemodified = time();
        $DB->insert_record('user_updated', $data);
    }
}
