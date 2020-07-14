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

defined('MOODLE_INTERNAL') || die();

function xmldb_local_stripepayment_upgrade($oldversion) {
  global $CFG, $DB;

  $result = true;
  $dbman = $DB->get_manager();


  if ($oldversion < 2016042504) {

    $table = new xmldb_table('user');
    $field = new xmldb_field('school', XMLDB_TYPE_CHAR, null, null, XMLDB_NOTNULL, null, 'NA');
    $field2 = new xmldb_field('student_id', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null, 'NA');
    $field3 = new xmldb_field('dob', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, 0);
    $field4 = new xmldb_field('gender', XMLDB_TYPE_CHAR, '10', null, XMLDB_NOTNULL, null,'NA');
    $field5 = new xmldb_field('parent', XMLDB_TYPE_CHAR, '70', null, XMLDB_NOTNULL, null, 'NA');
    $field6 = new xmldb_field('zip', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'NA');
    $field7 = new xmldb_field('package', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'NA');
    $field8 = new xmldb_field('find', XMLDB_TYPE_CHAR, '20', null, XMLDB_NOTNULL, null, 'NA');
    $field9 = new xmldb_field('refer', XMLDB_TYPE_CHAR, '30', null, XMLDB_NOTNULL, null, 'NA');
    
    if (!$dbman->field_exists($table, $field)) {
      $dbman->add_field($table, $field);
    }
        if (!$dbman->field_exists($table, $field2)) {
      $dbman->add_field($table, $field2);
    }
        if (!$dbman->field_exists($table, $field3)) {
      $dbman->add_field($table, $field3);
    }
        if (!$dbman->field_exists($table, $field4)) {
      $dbman->add_field($table, $field4);
    }
    if (!$dbman->field_exists($table, $field5)) {
      $dbman->add_field($table, $field5);
    }
    if (!$dbman->field_exists($table, $field6)) {
      $dbman->add_field($table, $field6);
    }
        if (!$dbman->field_exists($table, $field7)) {
      $dbman->add_field($table, $field7);
    }
        if (!$dbman->field_exists($table, $field8)) {
      $dbman->add_field($table, $field8);
    }
        if (!$dbman->field_exists($table, $field9)) {
      $dbman->add_field($table, $field9);
    }

    upgrade_plugin_savepoint(true, 2016042504, 'local', 'stripepayment');
  }

  if ($oldversion < 2016042505) {

    $table = new xmldb_table('user_credits');
    $field = new xmldb_field('payment_type', XMLDB_TYPE_CHAR, null, null, XMLDB_NOTNULL, null, 'credit_card');
    
    if (!$dbman->field_exists($table, $field)) {
      $dbman->add_field($table, $field);
    }

    upgrade_plugin_savepoint(true, 2016042505, 'local', 'stripepayment');
  }
  
 
  if ($oldversion < 2016042507) {

    $table = new xmldb_table('user');
    $field = new xmldb_field('parent_email', XMLDB_TYPE_CHAR, '70', null, XMLDB_NOTNULL, null, 'NA');
    $field2 = new xmldb_field('parent_phone', XMLDB_TYPE_CHAR, '70', null, XMLDB_NOTNULL, null, 'NA');
        
    if (!$dbman->field_exists($table, $field)) {
      $dbman->add_field($table, $field);
    }
    if (!$dbman->field_exists($table, $field2)) {
      $dbman->add_field($table, $field2);
    }

    upgrade_plugin_savepoint(true, 2016042507, 'local', 'stripepayment');
  }
  
    if ($oldversion < 2016042509) {

    $table = new xmldb_table('user_credits');
    $field = new xmldb_field('less_credit_mail', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, 0);
    $field1 = new xmldb_field('expire_reminder_mail', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, 0);

        if (!$dbman->field_exists($table, $field)) {
      $dbman->add_field($table, $field);
    }
        if (!$dbman->field_exists($table, $field1)) {
      $dbman->add_field($table, $field1);
    }

    upgrade_plugin_savepoint(true, 2016042509, 'local', 'stripepayment');
  }
  
      if ($oldversion < 2016042510) {

    $table = new xmldb_table('user_credits');
    $field = new xmldb_field('deleted', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, 0);

    if (!$dbman->field_exists($table, $field)) {
      $dbman->add_field($table, $field);
    }


    upgrade_plugin_savepoint(true, 2016042510, 'local', 'stripepayment');
  }

  return $result;
}
