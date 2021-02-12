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

$observers = array(
    array(
        'eventname' => 'core\event\user_created',
        'includefile' => '/local/send_mail_user_create_complete/locallib.php',
        'callback' => 'send_mail_user_create',
        'internal' => false,
    ),
//    array(
//        'eventname' => 'core\event\course_completed',
//        'includefile' => '/local/send_mail_user_create_complete/locallib.php',
//        'callback' => 'send_mail_complete',
//        'internal' => false,
//    ),
    array(
        'eventname' => 'core\event\user_enrolment_created',
        'includefile' => '/local/send_mail_user_create_complete/locallib.php',
        'callback' => 'send_enrol_mail',
        'internal' => false,
    ),
);
