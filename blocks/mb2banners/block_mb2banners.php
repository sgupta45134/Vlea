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



class block_mb2banners extends block_base
{


	private $headerhidden = true;
	protected $editorcontext = null;




	public function init()
	{
        $this->title = get_string('mb2banners', 'block_mb2banners');
    }



	public function instance_allow_multiple() {
        return true;
    }



	function applicable_formats() {
        return array('all' => true);
    }



	function has_config()
	{

		return false;

	}



	function specialization()
	{

		$allUrl = isset($this->config->alllink) ? $this->config->alllink : '';
		$title = isset($this->config->title) ? $this->config->title : '';

		$this->title = '';

		if ($allUrl == '')
		{
			$this->title = $title ? format_string($title) : '';//format_string(get_string('mb2banners', 'block_mb2banners'));
		}


    }





	function config_print()
	{
		if (!$this->has_config()) {
			return false;
	  	}
	}




	public function get_content()
	{


		global $CFG, $PAGE, $USER, $DB, $OUTPUT;


		$output = '';
		$showBlock = true;
		$items = array();
		$cls = '';
      $admin_text = '';


      // JavaScript Cookie
   	// https://github.com/js-cookie/js-cookie
      $PAGE->requires->js('/blocks/mb2banners/assets/js.cookie.js');

      // Custom js scripts
		$PAGE->requires->js('/blocks/mb2banners/scripts/mb2banners.js');


		// Language tag
		$currentLang = current_language();
		$langField = $this->mb2banners_setting('langtag');
		$langArr = explode(',', $langField);


		if ($langField)
		{
			if (!in_array($currentLang, $langArr))
			{
				$showBlock = false;
			}
		}


		if ($this->content !== NULL)
		{
		  return $this->content;
		}


      $cls .= $this->mb2banners_setting('bannerclose') ? ' mb2banners-withcookie' : '';
      $cls .= is_siteadmin() ? ' show' : '';


      $welcome_text = '<p class="mb2banners-welcome">' . get_string('welcome', 'block_mb2banners') . '</p>';
      $banner_text = $this->mb2banners_setting('bannertext');
      $banner_text = isset($banner_text['text']) ? $banner_text['text'] : '';
      $banner_text = format_text($banner_text, FORMAT_HTML);
      if ($banner_text)
      {
         $welcome_text = '';
      }


      // Banner and user time
      $config_start_time = $this->mb2banners_setting('bannerstart', $this->mb2banners_get_default_date());
      $config_end_time = $this->mb2banners_setting('bannerend', $this->mb2banners_get_default_date(true));
      $config_usertime = $this->mb2banners_get_user_date();

		$start_time = $this->mb2banners_get_date($config_start_time);
      $end_time = $this->mb2banners_get_date($config_end_time);
      $usertime = $this->mb2banners_get_date($config_usertime);


      // Users $access
      $logged_in = (isloggedin() && !isguestuser());
      $visibility = $this->mb2banners_setting('bannershow',1);


      // Date error. Show for everyone
      if ($end_time <= $start_time)
      {
         $banner_text = '<span style="background-color:red;padding:0 5px;">' . get_string('datewarning', 'block_mb2banners') . '</span>';
      }


      // Check if is site administrator
      // If yes show more details about banner
      if (is_siteadmin())
      {
         $banner_text .= ' (' . $this->mb2banners_admin_content($start_time, $end_time, $usertime) . ')';
      }
      elseif ($usertime > $end_time)
      {
         $showBlock = false;
      }
      elseif ($visibility == 2 && !$logged_in)
      {
         $showBlock = false;
      }
		elseif ($visibility == 3 && $logged_in)
		{
			$showBlock = false;
		}


		// Banner background color
		$bg_color = $this->mb2banners_setting('bannercolor');
		$btn_color = $this->mb2banners_setting('bannerbtncolor');
		$style = $bg_color ? ' style="background-color:' . $bg_color . ';"' : '';
		$btn_style = $btn_color ? ' style="background-color:' . $btn_color . ';"' : '';


		$close_times = ($this->mb2banners_setting('bannerclose') && !$this->mb2banners_setting('bannerclosetext'));
		$close_btn = ($this->mb2banners_setting('bannerclose') && $this->mb2banners_setting('bannerclosetext'));


      $output .= '<div class="mb2banners mb2banners' . $this->context->id . $cls . '"' . $this->mb2banners_get_data_attr() . $style . '>';
      $output .= '<div class="mb2banners-inner mb2banners-clr">';
      $output .= $close_times ? '<a href="#" class="mb2banners-close times">&times;</a>' : '';
		$output .= $close_btn ? '<div class="mb2banners-content">' : '';
		$output .= $welcome_text;
      $output .= $banner_text;
      $output .= $admin_text;
		$output .= $close_btn ? '</div>' : '';
		$output .= $close_btn ? '<div class="mb2banners-btn">' : '';
		$output .= $close_btn ? '<a href="#" class="mb2banners-close"' . $btn_style . '>' .
		$this->mb2banners_setting('bannerclosetext') . '</a>' : '';
		$output .= $close_btn ? '</div>' : '';
      $output .= '</div>';
      $output .= '</div>';


		$this->content =  new stdClass;
		$this->content->text = $showBlock ? $output : NULL;
		$this->content->footer = '';


		return $this->content;

	}





   function mb2banners_admin_content($start_time, $end_time, $usertime)
   {

      $output = '';

      $expiry_color = 'green';
      $expity_text = get_string('published','block_mb2banners');

      $output .= '<span class="mb2banners-admin-info">';

      if ($usertime > $end_time)
      {
         $expiry_color = 'red';
         $expity_text = get_string('unpublished','block_mb2banners');
      }

      $output .= '<span style="background-color:' . $expiry_color . ';padding:0 5px;">';
      $output .= $expity_text;
      $output .= '</span>';

      $output .= ' <span>';
      $output .= get_string('start','block_mb2banners') . ': ' . date('Y-m-d H:i:s', $start_time);
      $output .= '</span>';

      $output .= ' <span>';
      $output .= get_string('end','block_mb2banners') . ': ' . date('Y-m-d H:i:s', $end_time);
      $output .= '</span>';

      $output .= '</span>';


      return $output;

   }




   function mb2banners_setting($name, $default = '', $global = '')
	{

		if (isset($this->config->$name))
		{
			$output = ($global !='' && $this->config->$name == '') ? $this->config->$global : $this->config->$name;
		}
		else
		{
			$output = $default;
		}

		return $output;

	}





   function mb2banners_get_data_attr()
   {

      $output = '';
		$bannerid = $this->mb2banners_setting('bannerid');

      $output .= ' data-mb2banners_id="' . $this->context->id . '_' . $bannerid . '"';
      $output .= ' data-mb2banners_cookieexpiry="' . $this->mb2banners_setting('bannercookieexpiry',3) . '"';

      return $output;

   }





   function mb2banners_get_user_date()
   {

      $date = new DateTime('now', core_date::get_user_timezone_object());
      $time = $date->getTimestamp();
      return $time;

   }





   function mb2banners_get_default_date($end = false)
   {

      $day = 'now';

      if ($end)
      {
         $day = '+1 day';
      }

      $date = new DateTime($day, core_date::get_user_timezone_object());
      $time = $date->getTimestamp();

      return $time;

   }




	function mb2banners_get_date ($time)
	{

		if (!$time)
		{
			return;
		}

		$time_bool = date('I',$time);

		// Check if is daylight savings time
		// If yes add one hour to the base time
		if ($time_bool)
		{
			$time = $time+60*60;
		}

		return $time;

	}




}
