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
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot . '/user/editlib.php');
require_once('lib.php');

class login_signup_form extends moodleform implements renderable, templatable {
    function definition() {
        global $USER, $CFG;

        $mform = $this->_form;

        $mform->addElement('header', 'createuserandpass', get_string('createuserandpass'), '');


        $mform->addElement('text', 'username', get_string('username'), 'maxlength="100" size="12" autocapitalize="none"');
        $mform->setType('username', PARAM_RAW);
        $mform->addRule('username', get_string('missingusername'), 'required', null, 'client');

        if (!empty($CFG->passwordpolicy)){
            $mform->addElement('static', 'passwordpolicyinfo', '', print_password_policy());
        }
        $mform->addElement('password', 'password', get_string('password'), 'maxlength="32" size="12"');
        $mform->setType('password', core_user::get_property_type('password'));
        $mform->addRule('password', get_string('missingpassword'), 'required', null, 'client');

        $mform->addElement('header', 'supplyinfo', get_string('supplyinfo'),'');
      
        $mform->addElement('text', 'parent_surname', get_string('parent_surname'), 'maxlength="100" size="25"');
        $mform->setType('parent_surname', PARAM_RAW);
        $mform->addRule('parent_surname', get_string('missingparent_surname'), 'required', null, 'client');
                
        $mform->addElement('text', 'parent', get_string('parent'), 'maxlength="100" size="25"');
        $mform->setType('parent', PARAM_RAW);
        $mform->addRule('parent', get_string('missingparent'), 'required', null, 'client');
        
//        $namefields = useredit_get_required_name_fields();
//        foreach ($namefields as $field) {
//            $mform->addElement('text', $field, get_string($field), 'maxlength="100" size="30"');
//            $mform->setType($field, core_user::get_property_type('firstname'));
//            $stringid = 'missing' . $field;
//            if (!get_string_manager()->string_exists($stringid, 'moodle')) {
//                $stringid = 'required';
//            }
//            $mform->addRule($field, get_string($stringid), 'required', null, 'client');
//        }
        
//        $mform->addElement('text', 'school', get_string('school'), 'maxlength="100" size="25"');
//        $mform->setType('school', PARAM_RAW);
//        $mform->addRule('school', get_string('missingschool'), 'required', null, 'client');
//        
//        $mform->addElement('text', 'level', get_string('level'), 'maxlength="100" size="25"');
//        $mform->setType('level', PARAM_RAW);
//        $mform->addRule('level', get_string('missinglevel'), 'required', null, 'client');
//        
//        
//        $mform->addElement('text', 'student_id', get_string('student_id'), 'maxlength="100" size="25"');
//        $mform->setType('student_id', PARAM_RAW);
//        $mform->addRule('student_id', get_string('missingid'), 'required', null, 'client');
//        
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="25"');
        $mform->setType('email', core_user::get_property_type('email'));
        $mform->addRule('email', get_string('missingemail'), 'required', null, 'client');
        $mform->setForceLtr('email');
        
        $mform->addElement('text', 'phone1', get_string('contact'), 'maxlength="100" size="25"');
        $mform->setType('phone1', PARAM_INT);
        $mform->addRule('phone1', 'Numeric Values Only', 'numeric', null, 'client');
//
//        $mform->addElement('text', 'email2', get_string('emailagain'), 'maxlength="100" size="25"');
//        $mform->setType('email2', core_user::get_property_type('email'));
//        $mform->addRule('email2', get_string('missingemail'), 'required', null, 'client');
//        $mform->setForceLtr('email2');
//        
//        $mform->addElement('date_selector', 'dob', get_string('dob'));
//        $mform->addRule('dob', get_string('missingdob'), 'required', null, 'client');
//        
//        $radioarray=array();
//        $radioarray[] = $mform->createElement('radio', 'gender', '', get_string('male'), 'Male');
//        $radioarray[] = $mform->createElement('radio', 'gender', '', get_string('female'), 'Female');
//        $mform->addGroup($radioarray, 'gender_group', get_string('gender'), '', false);
//        $mform->setDefault('gender', 'Male');
//        
//        
//        
//        $mform->addElement('text', 'parent_email', get_string('parent_email'), 'maxlength="100" size="25"');
//        $mform->setType('parent_email', core_user::get_property_type('email'));
//        $mform->addRule('parent_email', get_string('missingparent_email'), 'required', null, 'client');
//        $mform->setForceLtr('parent_email');
//        
//        $mform->addElement('text', 'parent_phone', get_string('parent_phone'), 'maxlength="100" size="25"');
//        $mform->setType('parent_phone', PARAM_RAW);
//        $mform->addRule('parent_phone', get_string('missingparent_phone'), 'required', null, 'client');
//        
//        
//        $mform->addElement('text', 'address', get_string('address'), 'maxlength="100" size="25"');
//        $mform->setType('address', PARAM_RAW);
//        $mform->addRule('address', get_string('missingaddress'), 'required', null, 'client');        
//        
//        $mform->addElement('text', 'address_extend', get_string('address_extend'), 'maxlength="100" size="25"');
//        $mform->setType('address_extend', PARAM_RAW);
//        
//        $mform->addElement('text', 'zip', get_string('zip'), 'maxlength="100" size="25"');
//        $mform->setType('zip', PARAM_RAW);
//        $mform->addRule('zip', get_string('missingzip'), 'required', null, 'client');
//        
//        $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="20"');
//        $mform->setType('city', core_user::get_property_type('city'));
//        if (!empty($CFG->defaultcity)) {
//            $mform->setDefault('city', $CFG->defaultcity);
//        }
//
//        $country = get_string_manager()->get_list_of_countries();
//        $default_country[''] = get_string('selectacountry');
//        $country = array_merge($default_country, $country);
//        $mform->addElement('select', 'country', get_string('country'), $country);
//
//        if( !empty($CFG->country) ){
//            $mform->setDefault('country', $CFG->country);
//        }else{
//            $mform->setDefault('country', '');
//        }
        
//        $radioarray=array();
//        $radioarray[] = $mform->createElement('radio', 'package', '', get_string('basic'), 'Basic');
//        $radioarray[] = $mform->createElement('radio', 'package', '', get_string('advance'), 'Advance');
//        $mform->addGroup($radioarray, 'package_group', get_string('package'), '', false);
//        $mform->setDefault('package', 'Basic');
        
//        $levels = array();
//        $levels[] =& $mform->createElement('advcheckbox', 'level[P1]', '', get_string('P1'), 'P1');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[P2]', '', get_string('P2'), 'P2');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[P3]', '', get_string('P3'), 'P3');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[P4]', '', get_string('P4'), 'P4');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[P5]', '', get_string('P5'), 'P5');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[P6]', '', get_string('P6'), 'P6');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[S1]', '', get_string('S1'), 'S1');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[S2]', '', get_string('S2'), 'S2');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[S3]', '', get_string('S3'), 'S3');
//        $levels[] =& $mform->createElement('advcheckbox', 'level[S4]', '', get_string('S4'), 'S4');
//      
//        $mform->addGroup($levels, 'levelgroup', get_string('level'), array(' '), false);
//        $mform->setDefault('levelgroup', 'P1');
        
//$preprocedure=array(); 
//    $preprocedure[] =  $mform->createElement('advcheckbox', 'preprocedure[]','', 'Demo1', array('group' => 1), array('','demo1'));
//    $preprocedure[] =  $mform->createElement('advcheckbox', 'preprocedure[]','', 'Demo2', array('group' => 1), array('','demo2'));
//    $preprocedure[] =  $mform->createElement('advcheckbox', 'preprocedure[]','', 'Demo3', array('group' => 1), array('','demo3'));
//   $mform->addGroup($preprocedure, 'preproceduregroup', get_string('preprocedure', 'assignsubmission_metadata'),array('<br>'), false);


//        $issuancedetails = array();
//        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('website'), 'Website');
//        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('google'), 'Google');
//        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('facebook'), 'Facebook');
//        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('friend'), 'Friend');
//        $issuancedetails[] =& $mform->createElement('static', 'none_break', null, '<br/>');
//        $issuancedetails[] =& $mform->createElement('radio', 'find', '', get_string('others'), 1);
//        $issuancedetails[] =& $mform->createElement('text', 'findother', '');
//        
//        
//        $mform->addGroup($issuancedetails, 'findothergr', get_string('find'), array(' '), false);
//        $mform->setDefault('find', 'Website');
//        $mform->setType('findother', PARAM_RAW);
//        $mform->disabledIf('findother', 'find', 'neq', 1); 

        profile_signup_fields($mform);
        
//        $mform->addElement('text', 'refer', get_string('refer'), 'maxlength="100" size="25"');
//        $mform->setType('refer', PARAM_RAW);   

        if (signup_captcha_enabled()) {
            $mform->addElement('recaptcha', 'recaptcha_element', get_string('security_question', 'auth'));
            $mform->addHelpButton('recaptcha_element', 'recaptcha', 'auth');
            $mform->closeHeaderBefore('recaptcha_element');
        }

        // Hook for plugins to extend form definition.
        core_login_extend_signup_form($mform);

        // Add "Agree to sitepolicy" controls. By default it is a link to the policy text and a checkbox but
        // it can be implemented differently in custom sitepolicy handlers.
        $manager = new \core_privacy\local\sitepolicy\manager();
        $manager->signup_form($mform);

        // buttons
        $this->add_action_buttons(true, get_string('createaccount'));

    }

    function definition_after_data(){
        $mform = $this->_form;
        $mform->applyFilter('username', 'trim');

        // Trim required name fields.
        foreach (useredit_get_required_name_fields() as $field) {
            $mform->applyFilter($field, 'trim');
        }
    }

    /**
     * Validate user supplied data on the signup form.
     *
     * @param array $data array of ("fieldname"=>value) of submitted data
     * @param array $files array of uploaded files "element_name"=>tmp_file_path
     * @return array of "element_name"=>"error_description" if there are errors,
     *         or an empty array if everything is OK (true allowed for backwards compatibility too).
     */
    public function validation($data, $files) {
        $errors = parent::validation($data, $files);

        // Extend validation for any form extensions from plugins.
        $errors = array_merge($errors, core_login_validate_extend_signup_form($data));

        if (signup_captcha_enabled()) {
            $recaptchaelement = $this->_form->getElement('recaptcha_element');
            if (!empty($this->_form->_submitValues['g-recaptcha-response'])) {
                $response = $this->_form->_submitValues['g-recaptcha-response'];
                if (!$recaptchaelement->verify($response)) {
                    $errors['recaptcha_element'] = get_string('incorrectpleasetryagain', 'auth');
                }
            } else {
                $errors['recaptcha_element'] = get_string('missingrecaptchachallengefield');
            }
        }
        if (strlen($data['phone1']) != 8) {
            $errors['phone1'] = get_string('number_limit');
        }

        $errors += signup_validate_data($data, $files);

        return $errors;
    }

    /**
     * Export this data so it can be used as the context for a mustache template.
     *
     * @param renderer_base $output Used to do a final render of any components that need to be rendered for export.
     * @return array
     */
    public function export_for_template(renderer_base $output) {
        ob_start();
        $this->display();
        $formhtml = ob_get_contents();
        ob_end_clean();
        $context = [
            'formhtml' => $formhtml
        ];
        return $context;
    }
}
?>