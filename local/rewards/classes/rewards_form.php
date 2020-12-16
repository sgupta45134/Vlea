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
 * @package    local-mail
 * @author     Albert Gasset <albert.gasset@gmail.com>
 * @author     Marc Català <reskit@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->libdir.'/formslib.php');

class rewards_form extends moodleform {
    
    //Add elements to form
    public function definition() {
        global $CFG;
 
        $mform = $this->_form; // Don't forget the underscore!        
       
        
        $label = get_string('add_rewards', 'local_rewards');
        $mform->addElement('header', 'general', $label);
 
        $mform->addElement('text', 'prizename', get_string('prizename','local_rewards'));
        $mform->setType('prizename', PARAM_TEXT);
        $mform->addRule('prizename', get_string('missingprizename', 'local_rewards'), 'required', null, 'client');
		
		$mform->addElement('textarea', 'description', get_string('description','local_rewards'));
        $mform->setType('description', PARAM_TEXT);
		
		$mform->addElement('hidden', 'id');
        $mform->setDefault('id', $this->_customdata['id']);
        $mform->setType('id', PARAM_INT);

        $mform->addElement('text', 'points', get_string('points','local_rewards'));
        $mform->setType('points', PARAM_TEXT);
        $mform->addRule('points', get_string('missingpoints', 'local_rewards'), 'required', null, 'client');

        $mform->addElement('filepicker', 'userfile', get_string('file'), null,
                   array('maxbytes' => 10240, 'accepted_types' => '*'));

        $fpoptions = rewards_filepicker_options();
		
        $this->add_action_buttons();
          
    }

    //Custom validation should be added here
    function validation($data, $files) {

        global $DB;
        $errors = array();
            
        return $errors;
    }
    
}
