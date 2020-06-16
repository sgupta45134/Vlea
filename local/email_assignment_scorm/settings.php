<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
  $settings = new admin_settingpage('local_email_assignment_scorm', 'Set Email Id');

  // Create 
  $ADMIN->add('localplugins', $settings);

  $settings->add(new admin_setting_configtext('local_email_assignment_scorm/emailid', get_string('emailid', 'local_email_assignment_scorm'), get_string('emailiddescp', 'local_email_assignment_scorm'), "", PARAM_TEXT, 20));
}
