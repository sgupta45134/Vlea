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

class manualcredit_form extends moodleform {
    function definition() {
        global $USER, $CFG, $PAGE;
         
        $mform = $this->_form;
        $userid = $this->_customdata;
        $mform->addElement('header', 'credit', get_string('manual_credit_expire', 'local_stripepayment'), '');
        $radioarray=array();
        $radioarray[] =& $mform->createElement('radio', 'manual_credit', '', get_string('plan1', 'local_stripepayment'), '180');
        $radioarray[] =& $mform->createElement('static', 'none_break', null, '<br/>');
        $radioarray[] =& $mform->createElement('radio', 'manual_credit', '', get_string('plan2', 'local_stripepayment'), '320');
        $radioarray[] =& $mform->createElement('radio', 'manual_credit', '', get_string('plan3', 'local_stripepayment'), '500');
        $mform->addGroup($radioarray, 'manual_credit_group', get_string('manual_credit', 'local_stripepayment'), '', false);
        $mform->setDefault('manual_credit', '180');
//            $mform->addRule('manual_credit', get_string('rangeexceeds', 'local_trainer_record'), 'required', null, 'client');
            
       $mform->addElement('hidden', 'userid', $userid);
       $mform->setType('userid', PARAM_INT);
        // buttons
        $this->add_action_buttons(true, get_string('submitdata', 'local_stripepayment'));

    }


    function validation($data, $files) {
        global $CFG, $DB;
        $errors = array();
        return $errors;

    }


}


?>