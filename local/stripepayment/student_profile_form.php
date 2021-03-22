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

class student_profile_form extends moodleform {
    function definition() {
        global $USER, $CFG, $PAGE, $DB;
        
         $PAGE->requires->js('/local/stripepayment/module.js');
        $mform = $this->_form;
        $paymentid = $this->_customdata;
        $mform->addElement('header', 'deduct_credits', get_string('deduct_credits', 'local_stripepayment'), ''); 
        $mform->addElement('text', 'school', get_string('school'), 'maxlength="100" size="25"');
        $mform->setType('school', PARAM_RAW);
        $mform->addRule('school', get_string('missingschool'), 'required', null, 'client');

        
        $mform->addElement('text', 'student_id', get_string('student_id'), 'maxlength="100" size="25"');
        $mform->setType('student_id', PARAM_RAW);
        $mform->addRule('student_id', get_string('missingid'), 'required', null, 'client');     

        
        $mform->addElement('date_selector', 'dob', get_string('dob'));
        $mform->addRule('dob', get_string('missingdob'), 'required', null, 'client');
        
        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'gender', '', get_string('male'), 'Male');
        $radioarray[] = $mform->createElement('radio', 'gender', '', get_string('female'), 'Female');
        $mform->addGroup($radioarray, 'gender_group', get_string('gender'), '', false);
        $mform->setDefault('gender', 'Male');
        
        
        
        $mform->addElement('text', 'parent_email', get_string('parent_email'), 'maxlength="100" size="25"');
        $mform->setType('parent_email', core_user::get_property_type('email'));
        $mform->addRule('parent_email', get_string('missingparent_email'), 'required', null, 'client');
        $mform->setForceLtr('parent_email');
        
        $mform->addElement('text', 'parent_phone', get_string('parent_phone'), 'maxlength="100" size="25"');
        $mform->setType('parent_phone', PARAM_RAW);
        $mform->addRule('parent_phone', get_string('missingparent_phone'), 'required', null, 'client');
        
        
        $mform->addElement('text', 'address', get_string('address'), 'maxlength="100" size="25"');
        $mform->setType('address', PARAM_RAW);
        $mform->addRule('address', get_string('missingaddress'), 'required', null, 'client');        
        
        $mform->addElement('text', 'address_extend', get_string('address_extend'), 'maxlength="100" size="25"');
        $mform->setType('address_extend', PARAM_RAW);
        
        $mform->addElement('text', 'zip', get_string('zip'), 'maxlength="100" size="25"');
        $mform->setType('zip', PARAM_RAW);
        $mform->addRule('zip', get_string('missingzip'), 'required', null, 'client');
        
        $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="20"');
        $mform->setType('city', core_user::get_property_type('city'));
        if (!empty($CFG->defaultcity)) {
            $mform->setDefault('city', $CFG->defaultcity);
        }

        $country = get_string_manager()->get_list_of_countries();
        $default_country[''] = get_string('selectacountry');
        $country = array_merge($default_country, $country);
        $mform->addElement('select', 'country', get_string('country'), $country);

        if( !empty($CFG->country) ){
            $mform->setDefault('country', $CFG->country);
        }else{
            $mform->setDefault('country', '');
        }
        
        $radioarray=array();
        $radioarray[] = $mform->createElement('radio', 'package', '', get_string('basic'), 'Basic');
        $radioarray[] = $mform->createElement('radio', 'package', '', get_string('advance'), 'Advance');
        $mform->addGroup($radioarray, 'package_group', get_string('package'), '', false);
        $mform->setDefault('package', 'Basic');
        


        $issuancedetails = array();
        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('website'), 'Website');
        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('google'), 'Google');
        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('facebook'), 'Facebook');
        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('friend'), 'Friend');
        $issuancedetails[] =& $mform->createElement('static', 'none_break', null, '<br/>');
        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('others'), 1);
        $issuancedetails[] =& $mform->createElement('text', 'findother', '');
        
        
        $mform->addGroup($issuancedetails, 'findothergr', get_string('find'), array(' '), false);
        $mform->setDefault('find', 'Website');
        $mform->setType('findother', PARAM_RAW);
        $mform->disabledIf('findother', 'find', 'neq', 1); 

        
        $mform->addElement('text', 'refer', get_string('refer'), 'maxlength="100" size="25"');
        $mform->setType('refer', PARAM_RAW);  
        
       $mform->addElement('hidden', 'paymentid', $paymentid);
       $mform->setType('paymentid', PARAM_INT);
// buttons
        $this->add_action_buttons(true, get_string('update_procced', 'local_stripepayment'));

    }


    function validation($data, $files) {
        global $CFG, $DB;
        $errors = array();
        return $errors;

    }


}


?>