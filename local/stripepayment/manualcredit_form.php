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
        global $USER, $CFG, $PAGE, $DB;
        
         $PAGE->requires->js('/local/stripepayment/module.js');
        $mform = $this->_form;
        $userid = $this->_customdata;
              $mform->addElement('header', 'refund', get_string('refund_credit', 'local_stripepayment'), ''); 
        $records = $DB->get_records('user_credits',array('status' => 1,'userid' => $userid,'expire' =>0));
        $active_plans = array();
        
        foreach($records as $recordkey => $recordvalue){
          if($recordvalue->total_credit_left == $recordvalue->total_credit) 
            continue;
          $key = "ORD-".$recordvalue->id; 
          $active_plans[$recordkey] = $key;  
        }
        
        $options = "<option value=''>" . get_string('select_plan', 'local_stripepayment') .
                   "</option>";
        foreach ($active_plans as $i => $value) {
            $options .= "<option value='{$i}'>$value</option>";
        }

        $mform->addElement('html', '<div class = "row mr_top_items">');

        $mform->addElement('html', '<div class = "col-sm-5">');

        $select = "<select class='coursevars form-control' onchange='onSelectcourse(this.value)'>
                 $options</select>";
        $htmlcourse = "<div class='fitem row'><div class='fitemtitle col-sm-6'>Consumed Plans:</div><div class='felement col-sm-6'>
                 $select</div></div>";
        $mform->addElement('html', $htmlcourse);

        $mform->addElement('html', '</div>');
        
       $mform->addElement('text', 'credits_refund', get_string('credits_refund', 'local_stripepayment'), 'maxlength="100" size="25"');
       $mform->setType('credits_refund', PARAM_RAW);
       $mform->addRule('credits_refund', 'Numeric Values Only', 'numeric', null, 'client');
       $mform->addElement('html', '<div class = "my_hidden_class">');
       $mform->addElement('text','selected_plan',get_string('selected_plans','local_stripepayment'),$attributes='size=20,maxlength=250');
       $mform->setType('selected_plan', PARAM_RAW);
       $mform->addElement('html', '</div>');
       $mform->addElement('hidden', 'userid', $userid);
       $mform->setType('userid', PARAM_INT);
        // buttons
        $this->add_action_buttons(true, get_string('submitrefunddata', 'local_stripepayment'));
        
        
        
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
        
                
        
        $mform->addElement('header', 'reward_points', get_string('reward_points', 'local_stripepayment'), '');
        $radioarray=array();
        $mform->addElement('text', 'points', get_string('points','local_stripepayment'));
        $mform->setType('points', PARAM_INT);
        $mform->setDefault('points', '0');
            
       $mform->addElement('hidden', 'userid', $userid);
       $mform->setType('userid', PARAM_INT);
        // buttons
        $this->add_action_buttons(true, get_string('submitrewarddata', 'local_stripepayment'));

    }


    function validation($data, $files) {
        global $CFG, $DB;
        $errors = array();
        return $errors;

    }


}


?>