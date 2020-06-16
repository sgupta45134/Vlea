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
 *
 * @package   theme_mb2nl
 * @copyright 2017 - 2020 Mariusz Boloz (https://mb2themes.com)
 * @license   Commercial https://themeforest.net/licenses
 *
 */

defined('MOODLE_INTERNAL') || die();


/*
 *
 * Method to get search form
 *
 */
function theme_mb2nl_search_form ()
{

	global $CFG;

	$output = '';
	$search_action = new moodle_url($CFG->wwwroot . '/course/search.php',array());
	$search_text = get_string('searchcourses');
	$global_search = (isset($CFG->enableglobalsearch) && $CFG->enableglobalsearch && theme_mb2nl_moodle_from(2016052300));
	$input_name = 'search';

	if ($global_search)
	{
		$search_action = new moodle_url($CFG->wwwroot . '/search/index.php',array());
		$search_text = get_string('globalsearch','admin');
		$input_name = 'q';
	}

	$output .= '<div class="theme-searchform">';
	$output .= '<form id="theme-search" action="' . $search_action . '">';
	$output .= '<input id="theme-coursesearchbox" type="text" value="" placeholder="' . $search_text . '" name="' . $input_name . '">';
	$output .= '<button type="submit"><i class="fa fa-search"></i></button>';
	$output .= '</form>';
	$output .= theme_mb2nl_search_links();
	$output .= '</div>';

	return $output;

}




/*
 *
 * Method to get search links
 *
 */
function theme_mb2nl_search_links ()
{
	global $PAGE;

	$search_menu_items = theme_mb2nl_theme_setting($PAGE,'searchlinks');

	if ($search_menu_items)
	{
		return theme_mb2nl_static_content($search_menu_items, true, array('listcls'=>'theme-searchform-links'));
	}

}






/*
 *
 * Method to get login form
 *
 *
 */
function theme_mb2nl_login_form ()
{

	global $PAGE, $OUTPUT, $USER, $CFG;

	$output = '';
	$iswww = '';
    $logintoken = '';

	$iswww = empty($CFG->loginhttps) ?  $CFG->wwwroot : str_replace('http://', 'https://', $CFG->wwwroot);
    $login_url = $iswww . '/login/index.php?authldap_skipntlmsso=1';

    if (method_exists('\core\session\manager','get_login_token'))
    {
        $login_url = get_login_url();
        $logintoken = '<input type="hidden" name="logintoken" value="' . s(\core\session\manager::get_login_token()) .'" />';
    }

	$link_to_login = theme_mb2nl_theme_setting($PAGE,'loginlinktopage',0);

	$output .= '<div class="theme-loginform" style="display:none;">';

	if ((!isloggedin() || isguestuser()) && !$link_to_login)
	{

		$output .= '<form id="header-form-login" method="post" action="' . $login_url . '">';
		$output .= '<div class="form-field">';
		$output .= '<label id="user"><i class="fa fa-user"></i></label>';
		$output .= '<input id="login-username" type="text" name="username" placeholder="' . get_string('username') . '" />';
		$output .= '</div>';
		$output .= '<div class="form-field">';
		$output .= '<label id="pass"><i class="fa fa-lock"></i></label>';
		$output .= '<input id="login-password" type="password" name="password" placeholder="' . get_string('password') . '" />';
		$output .= '</div>';
		//$output .= '<input type="submit" id="submit" name="submit" value="' . get_string('login') . '" />';
		$output .= '<button type="submit"><i class="fa fa-angle-right"></i></button>';
		$output .= $logintoken;
		$output .= '</form>';


		$m33 = 2017051500; // Firs Moodle 3.3 release
		if ($CFG->version >= $m33)
		{
			$authsequence = get_enabled_auth_plugins(true); // Get all auths, in sequence.
            $potentialidps = array();
            foreach ($authsequence as $authname)
			{
                $authplugin = get_auth_plugin($authname);
                $potentialidps = array_merge($potentialidps, $authplugin->loginpage_idp_list($PAGE->url->out(false)));
            }

            if (!empty($potentialidps))
			{
     			$output .= '<div class="potentialidps">';
               	$output .= '<h6>' . get_string('potentialidps', 'auth') . '</h6>';
                $output .= '<div class="potentialidplist">';
                foreach ($potentialidps as $idp)
				{
              		$output .= '<div class="potentialidp">';
                   	$output .= '<a class="btn btn-default" ';
                   	$output.= 'href="' . $idp['url']->out() . '" title="' . s($idp['name']) . '">';
                    if (!empty($idp['iconurl']))
					{
                        $output .= '<img src="' . s($idp['iconurl']) . '" width="24" height="24" class="m-r-1"/>';
                    }
                    $output .= s($idp['name']) . '</a></div>';
                }
                $output .= '</div>';
                $output .= '</div>';
            }
		}

		$loginLink = theme_mb2nl_theme_setting($PAGE,'loginlink',1) == 2 ? $CFG->wwwroot . '/login/forgot_password.php' : $CFG->wwwroot . '/login/index.php';
		$loginText = theme_mb2nl_theme_setting($PAGE,'logintext')  !='' ? theme_mb2nl_theme_setting($PAGE,'logintext') : get_string('logininfo','theme_mb2nl');
		$output .= '<p class="login-info"><a href="' . $loginLink . '">' . $loginText . '</a></p>';

	}
	elseif(isloggedin() && !isguestuser())
	{

		$m27 = 2014051220; // Last formal release of Moodle 2.7
		$output .= ($CFG->version > $m27) ? $OUTPUT->user_menu() : $OUTPUT->login_info();
		$output .= $OUTPUT->user_picture($USER, array('size' => 80, 'class' => 'welcome_userpicture'));

	}


	$output .= '</div>';


	return $output;


}




/*
 *
 * Method to get login form
 *
 */
function theme_mb2nl_header_tools ()
{

	global $OUTPUT, $PAGE, $USER, $CFG, $COURSE;
	$output = '';
	$type = theme_mb2nl_theme_setting($PAGE,'headertoolstype','text');
	$isLoginPage = theme_mb2nl_is_login($PAGE);

	$global_search = (isset($CFG->enableglobalsearch) && $CFG->enableglobalsearch && theme_mb2nl_moodle_from(2016052300));
	$search_text = '';
	$search_text_core = $global_search ? get_string('globalsearch','admin') : get_string('searchcourses','core');
	$login_text = '';
	$settings_text = '';
	$sitesettings_text = '';
	$signup_text = '';
	$text_close = ' <span class="text2">' . get_string('closebuttontitle','core') . '</span>';
	$jslink_cls = ' header-tools-jslink';

	if ( $type === 'text' )
	{
		$search_text = ' <span class="text1">' . $search_text_core . '</span>' . $text_close;
		$settings_text = ' <span class="text1">' . get_string( 'settings' ) . '</span>' . $text_close;
		$signup_text = ' <span class="text1">' . get_string( 'register', 'theme_mb2nl' ) . '</span>';
	}

	$output .= '<div class="header-tools type-' . $type . '">';

	if (theme_mb2nl_theme_setting($PAGE,'navbarplugin') && theme_mb2nl_moodle_from(2016120500)) // Feature since Moodle 3.2
	{
		$output .= '<div class="theme-plugins">';
		$output .= $OUTPUT->navbar_plugin_output();
		$output .= '</div>';
	}

	if ( is_siteadmin() )
	{
		$output .= '<a href="#" class="header-tools-link' . $jslink_cls . ' tool-links" title="' . get_string( 'settings' ) . '">';
		$output .= '<i class="icon1 fa fa-sliders"></i>';
		$output .= $settings_text;
		$output .= '</a>';
	}

	$output .= '<a href="#" class="header-tools-link' . $jslink_cls . ' tool-search" title="' . $search_text_core . '">';
	$output .= '<i class="icon1 fa fa-search"></i>';
	$output .= $search_text;
	$output .= '</a>';

	$output .= theme_mb2nl_tool_login();

	if ( theme_mb2nl_theme_setting( $PAGE, 'signuplink' ) && $PAGE->pagetype !== 'login-signup' && ( ! isloggedin() || isguestuser() ) )
	{
		$signupliknarr = explode( '|', theme_mb2nl_theme_setting( $PAGE, 'signuppage' ) );
		$signupliktarget = isset( $signupliknarr[1] ) ? ' target="_blank"' : '';

		$signuplink = theme_mb2nl_theme_setting( $PAGE, 'signuppage' ) ? trim( $signupliknarr[0] )
		: new moodle_url( $CFG->wwwroot . '/login/signup.php', array() );

		$output .= '<a href="' . $signuplink . '" class="header-tools-link tool-signup" title="' . get_string( 'register', 'theme_mb2nl' ) . '"' . $signupliktarget . '>';
		$output .= '<i class="icon1 fa fa-user"></i>';
		$output .= $signup_text;
		$output .= '</a>';
	}

	$output .= '</div>';

	return $output;

}




/*
 *
 * Method to set turnediting button
 *
 */
function theme_mb2nl_tool_turediting()
{

	global $PAGE, $CFG, $COURSE;
	$output = '';
	$editing = $PAGE->user_is_editing();

	if ( !isset( $COURSE->id ) || $COURSE->id < 1 )
	{
		return;
	}

	if ( ! in_array( theme_mb2nl_site_access(), array('admin','manager','editingteacher') ) )
	{
		return;
	}

	if ( $PAGE->pagelayout !== 'course' && $PAGE->pagelayout !== 'frontpage' )
	{
		return;
	}

	$tureditingtext = $editing ? get_string('turneditingoff') : get_string('turneditingon');
	$turneditingicon = $editing ? 'fa fa-power-off' : 'fa fa-pencil';
	$turneditinglink = new moodle_url( $CFG->wwwroot . '/course/view.php', array('id'=>$COURSE->id, 'sesskey'=> sesskey(),
		'edit'=> $PAGE->user_is_editing() ? 'off' : 'on') );
	$editingcls = $editing ? ' editing-on' : ' editing-off';

	$output .= '<a href="' . $turneditinglink . '" class="header-tools-link tool-turnediting' . $editingcls . '" title="' . $tureditingtext . '">';
	$output .= '<i class="icon1 ' . $turneditingicon . '"></i>';
	$output .= '</a>';

	return $output;

}





/*
 *
 * Method to set login button
 *
 */
function theme_mb2nl_tool_login()
{
	global $PAGE, $CFG, $USER;
	$output = '';
	$notlogin = ( !isloggedin() || isguestuser() );
	$link_to_login = theme_mb2nl_theme_setting( $PAGE, 'loginlinktopage' );
	$login_link = '#';
	$jslink_cls = ' header-tools-jslink';
	$login_text = '';
	$text_close = ' <span class="text2">' . get_string('closebuttontitle','core') . '</span>';
	$loginicon = $notlogin  ? 'lock' : 'user';
	$logintitle = $notlogin ? get_string( 'login' ) : $USER->firstname;

	if ( theme_mb2nl_is_login( $PAGE ) )
	{
		return;
	}

	if ( theme_mb2nl_theme_setting( $PAGE, 'headertoolstype', 'text' ) === 'text' )
	{
		$login_text = ' <span class="text1">' . $logintitle . '</span>' . $text_close;
	}

	if ( $notlogin && $link_to_login )
	{
		$jslink_cls = '';

	   if ( $CFG->alternateloginurl )
	   {
			$login_link = $CFG->alternateloginurl;
	   }
	   else
	   {
			$login_link = new moodle_url( $CFG->wwwroot . '/login/index.php', array() );
	   }
	}

	$output .= '<a href="' . $login_link . '" class="header-tools-link' . $jslink_cls . ' tool-login" title="' . $logintitle . '">';
	$output .= '<i class="icon1 fa fa-' . $loginicon . '"></i>';
	$output .= $login_text;
	$output .= '</a>';

	return $output;

}
