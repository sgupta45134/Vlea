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
 * User sign-up form.
 *
 * @package    core
 * @subpackage auth
 * @copyright  1999 onwards Martin Dougiamas  http://dougiamas.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class removecredit_form extends moodleform {
    function definition() {
        global $USER, $CFG, $PAGE, $DB;
        
         $PAGE->requires->js('/local/stripepayment/module.js');
        $mform = $this->_form;
        $userid = $this->_customdata;
        $mform->addElement('header', 'deduct_credits', get_string('deduct_credits', 'local_stripepayment'), ''); 
        
       $mform->addElement('text', 'credits_deducted', get_string('credits_deducted', 'local_stripepayment'), 'maxlength="200" size="25"');
       $mform->setType('credits_deducted', PARAM_RAW);
       $mform->addRule('credits_deducted', 'Numeric Values Only', 'numeric', null, 'client');
       $mform->addElement('html', '</div>');
       $mform->addElement('hidden', 'userid', $userid);
       $mform->setType('userid', PARAM_INT);
        // buttons
        $this->add_action_buttons(true, get_string('deduct_credits', 'local_stripepayment'));

    }


    function validation($data, $files) {
        global $CFG, $DB;
        $errors = array();
        return $errors;

    }


}


?>