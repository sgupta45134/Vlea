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

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
  $settings = new admin_settingpage('local_send_mail_user_create_complete', 'Set Email Here to Send Email:');

  // Create 
  $ADMIN->add('localplugins', $settings);
  $settings->add(new admin_setting_configtext('local_send_mail_user_create_complete/email', get_string('email', 'local_send_mail_user_create_complete'), get_string('emaildescp', 'local_send_mail_user_create_complete'), '', PARAM_TEXT, 30));

  $settings->add(new admin_setting_configtext('local_send_mail_user_create_complete/adminemail', get_string('adminemail', 'local_send_mail_user_create_complete'), get_string('adminemaildescp', 'local_send_mail_user_create_complete'), '', PARAM_TEXT, 30));
}
