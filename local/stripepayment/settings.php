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
 * Course list block settings
 *
 * @package    block_dashboard
 * @copyright  2007 Petr Skoda
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

//defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

	$settings = new admin_settingpage('local_stripepayment', get_string('pluginname', 'local_stripepayment'));
    

	$name = 'local_stripepayment/testmode';
    $title = get_string('testmode', 'local_stripepayment');
    $description = get_string('testmode_desc', 'local_stripepayment');
    $default = false;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
    $settings->add($setting);

	$name = 'local_stripepayment/test_public_key';
    $title = new lang_string('testpublickey', 'local_stripepayment');
    $description = new lang_string('testpublickeydesc', 'local_stripepayment');
    $setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
    $settings->add($setting);

    $name = 'local_stripepayment/test_secret_key';
    $title = new lang_string('testsecretkey', 'local_stripepayment');
    $description = new lang_string('testsecretkeydesc', 'local_stripepayment');
    $setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
    $settings->add($setting);

    $name = 'local_stripepayment/live_public_key';
    $title = new lang_string('livepublickey', 'local_stripepayment');
    $description = new lang_string('livepublickeydesc', 'local_stripepayment');
    $setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
    $settings->add($setting);

    $name = 'local_stripepayment/live_secret_key';
    $title = new lang_string('livesecretkey', 'local_stripepayment');
    $description = new lang_string('livesecretkeydesc', 'local_stripepayment');
    $setting = new admin_setting_configtext($name, $title, $description, '#', PARAM_RAW);
    $settings->add($setting);

	$ADMIN->add('localplugins', $settings);
}