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
 * local rewards
 *
 * @package     local_rewards
 * @author      Kevin Dibble
 * @copyright   2017 LearningWorks Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

/**
 *
 * Extend local_rewards navigation
 *
 * @param global_navigation $nav
 */
function local_rewards_extends_navigation(global_navigation $nav) {
    return local_rewards_extend_navigation($nav);
}

/**
 *
 * Extend navigation to show the local_rewards in the navigation block
 *
 * @param global_navigation $nav
 */
function local_rewards_extend_navigation(global_navigation $nav) {
    global $CFG, $DB;
    $context = context_system::instance();
    $pluginname = get_string('pluginname', 'local_rewards');
//    if (has_capability('local/rewards:manageprize', $context)) {
//        $mainnode = $nav->add(
//            get_string('pluginname', 'local_rewards'),
//            new moodle_url($CFG->wwwroot . "/local/rewards/manage.php"),
//            navigation_node::TYPE_CONTAINER,
//            'local_rewards',
//            'local_rewards',
//            new pix_icon('newspaper', $pluginname, 'local_rewards')
//        );
//        $mainnode->nodetype = 0;
//        $mainnode->showinflatnavigation = true;
//    }
    
}

function send_acknowledement_mail_to_user($fromuser, $touseremail, $message, $subject) {

        global $DB;

        $fromuser = $DB->get_record('user', array('email'=>$fromuser));
        $touser = new stdClass();
        $touser->id = 1;
        $touser->mailformat = 1;
        $fromuser->mailformat = 1;
        $touser->email = $touseremail;
        $touser->deleted = 0;
        $touser->auth = 'manual';
        $messagehtml = text_to_html($message);
        email_to_user($touser, $fromuser,
        $subject, $message, $messagehtml);
}

function get_single_record($id) {

    global $DB;

    $record = $DB->get_record('local_rewards', array('id'=>$id));
    return $record;

}