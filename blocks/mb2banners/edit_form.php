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
 * @package		Mb2 Banners
 * @author		Mariusz Boloz (http://mb2extensions.com)
 * @copyright	Copyright (C) 2018 Mariusz Boloz (http://marbol2.com). All rights reserved
 * @license		Commercial (http://codecanyon.net/licenses)
**/

defined('MOODLE_INTERNAL') || die;



class block_mb2banners_edit_form extends block_edit_form
{

	protected function specific_definition($mform)
	{


	   global $CFG, $PAGE;


		$PAGE->requires->jquery();
		$PAGE->requires->css('/blocks/mb2banners/assets/spectrum/spectrum.css');
	   $PAGE->requires->js('/blocks/mb2banners/assets/spectrum/spectrum.js');
	   $PAGE->requires->js('/blocks/mb2banners/scripts/admin.js');


      $bannerShowArr = array(
			'1' => get_string('bannershow_all','block_mb2banners'),
			'2' => get_string('bannershow_logged_in','block_mb2banners'),
			'3' => get_string('bannershow_not_logged_in','block_mb2banners')
		);

		$mform->addElement('hidden', 'config_bannerid');
		$mform->setType('config_bannerid', PARAM_INT);
		$mform->setDefault('config_bannerid',0);


		// Form elements
		$sepAttr = ' class="mb2form-separator" style="height:1px;border-top:solid 1px #e5e5e5;margin:30px 0;"';


		// General options
		$mform->addElement('header', 'config_generaloptions', get_string('generaloptions', 'block_mb2banners'));


		$mform->addElement('editor', 'config_bannertext', get_string('bannertext','block_mb2banners'));
		$mform->setType('config_bannertext', PARAM_RAW);


      $mform->addElement('date_time_selector', 'config_bannerstart', get_string('bannerstart','block_mb2banners'));
      $mform->addElement('date_time_selector', 'config_bannerend', get_string('bannerend','block_mb2banners'));


      $mform->addElement('select', 'config_bannershow', get_string('bannershow','block_mb2banners'), $bannerShowArr);
      $mform->setDefault('config_bannershow',1);


      $mform->addElement('selectyesno', 'config_bannerclose', get_string('bannerclose','block_mb2banners'));
      $ifClose= array('data-showon'=>'config_bannerclose', 'data-showonval'=>1);


		$mform->addElement('text','config_bannerclosetext', get_string('bannerclosetext','block_mb2banners'),$ifClose);
		$mform->setType('config_bannerclosetext', PARAM_TEXT);


      $mform->addElement('text', 'config_bannercookieexpiry', get_string('bannercookieexpiry','block_mb2banners'), $ifClose);
      $mform->setDefault('config_bannercookieexpiry',3);
      $mform->setType('config_bannercookieexpiry', PARAM_INT);


		$mform->addElement('text','config_bannercolor', get_string('bannercolor','block_mb2banners'), array('class'=>'mb2banners_color'));
		$mform->setType('config_bannercolor', PARAM_TEXT);

		$mform->addElement('text','config_bannerbtncolor', get_string('bannerbtncolor','block_mb2banners'), array('class'=>'mb2banners_color'));
		$mform->setType('config_bannerbtncolor', PARAM_TEXT);



	}



	function set_data($defaults)
   {
      parent::set_data($defaults);


		if ($data = parent::get_data())
	 	{


			 //$data->config_bannerid = 125;

			 //print_r($data);


		}
   }


}
