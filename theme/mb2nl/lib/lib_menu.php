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
 * Method to get langauge list
 *
 *
 */
function theme_mb2nl_language_list ()
{


	global $PAGE, $OUTPUT, $CFG;

	$moodle33 = 2017051500;
	$output = '';
	$langs = get_string_manager()->get_list_of_translations();
	$strlang =  get_string('language');
	$currentlang = current_language();
	$langinmenu = theme_mb2nl_theme_setting($PAGE,'langinmenu');


	$customFlagFile = $CFG->dirroot . theme_mb2nl_theme_dir() . '/mb2nl/pix/flags/custom/' . strtoupper($currentlang) . '.png';
	$flagFile = $CFG->dirroot . theme_mb2nl_theme_dir() . '/mb2nl/pix/flags/48x32/' . strtoupper($currentlang) . '.png';
	$noFlagFile = $CFG->dirroot . theme_mb2nl_theme_dir() . '/mb2nl/pix/flags/48x32/noflag.png';
	$isCustomFlag = file_exists($customFlagFile) ? true : false;
	$isFlag = file_exists($flagFile) ? true : false;


	if($isCustomFlag)
	{
		$currentFlagUrl = $CFG->version >= 	$moodle33 ? $OUTPUT->image_url('flags/custom/' . strtoupper($currentlang),'theme') : $OUTPUT->pix_url('flags/custom/' . strtoupper($currentlang),'theme');
	}
	elseif ($isFlag)
	{
		$currentFlagUrl = $CFG->version >= 	$moodle33 ? $OUTPUT->image_url('flags/48x32/' . strtoupper($currentlang),'theme') : $OUTPUT->pix_url('flags/48x32/' . strtoupper($currentlang),'theme');
	}
	else
	{
		$currentFlagUrl = $CFG->version >= 	$moodle33 ? $OUTPUT->image_url('flags/48x32/noflag','theme') : $OUTPUT->pix_url('flags/48x32/noflag','theme');
	}


	$currentFlagImg = '<span class="lang-flag" style="background-image:url(\'' . $currentFlagUrl . '\');"></span> ';
	$lanText = isset($langs[$currentlang]) ? $langs[$currentlang] : $strlang;


	if (count($langs)>1 && $langinmenu)
	{

		$output .= '<li class="lang-item dropdown">';
		$output .= '<a href="' . new moodle_url($PAGE->url, array('lang' => $currentlang)) . '" title="' . $lanText . '">';
		$output .= $currentFlagImg;
		$output .= '<span class="lang-shortname">' . str_replace('_',' ', $currentlang). '</span>';
		$output .= '<span class="lang-fullname">' . $lanText . '</span>';
		$output .= '<span class="mobile-arrow"></span>';
		$output .= '</a>';
		$output .= '<ul>';



		foreach ($langs as $langtype => $langname)
		{

			if ($langtype !== $currentlang)
			{

				$flagFile1 = $CFG->dirroot . theme_mb2nl_theme_dir() . '/mb2nl/pix/flags/custom/' . strtoupper($langtype) . '.png';
				$flagFile2 = $CFG->dirroot . theme_mb2nl_theme_dir() . '/mb2nl/pix/flags/48x32/' . strtoupper($langtype) . '.png';
				$isFlag1 = file_exists($flagFile1) ? true : false;
				$isFlag2 = file_exists($flagFile2) ? true : false;


				if ($isFlag1)
				{
					$flagUrl = $CFG->version >= $moodle33 ? $OUTPUT->image_url('flags/custom/' . strtoupper($langtype),'theme') : $OUTPUT->pix_url('flags/custom/' . strtoupper($langtype),'theme');
				}
				elseif ($isFlag2)
				{
					$flagUrl = $CFG->version >= $moodle33 ? $OUTPUT->image_url('flags/48x32/' . strtoupper($langtype),'theme') : $OUTPUT->pix_url('flags/48x32/' . strtoupper($langtype),'theme');
				}
				else
				{
					$flagUrl = $CFG->version >= $moodle33 ? $OUTPUT->image_url('flags/48x32/noflag','theme') : $OUTPUT->pix_url('flags/48x32/noflag','theme');
				}


				$flafImg = '<span class="lang-flag" style="background-image:url(\'' . $flagUrl . '\');"></span> ';


				$output .= '<li>';
				$output .= '<a href="' . new moodle_url($PAGE->url, array('lang' => $langtype)) . '" title="' . $langname . '">';
				$output .= $flafImg;
				$output .= '<span class="lang-shortname">' . str_replace('_',' ', $langtype) . '</span>';
				$output .= '<span class="lang-fullname">' . $langname . '</span>';
				$output .= '</a>';
				$output .= '</li>';

			}

		}


		$output .= '</ul>';
		$output .= '</li>';

	}


	return $output;

}





/*
 *
 * Method to get langauge list
 *
 */
function theme_mb2nl_mycourses_list ()
{

	global $PAGE;
	$output = '';
	$courses = theme_mb2nl_get_mycourses();
	$limit = theme_mb2nl_theme_setting($PAGE, 'myclimit', 6);

	if (!count($courses))
	{
		return;
	}

	$output .= '<li class="mycourses dropdown">';

	$output .= '<a href="#" title="' . get_string('mycourses') . '">';
	$output .= get_string('mycourses') . ' <span class="mycourses-num">(' . count($courses) . ')</span>';
	$output .= '<span class="mobile-arrow"></span>';
	$output .= '</a>';

	$output .= '<ul>';

	foreach ($courses as $c)
	{
		$course_url = new moodle_url('/course/view.php?id=' . $c['id']);
		$coursename = strip_tags(format_text($c['fullname']));

		$output .= '<li class="visible' . $c['visible'] . '">';
		$output .= '<a href="' . $course_url . '" title="' . theme_mb2nl_wordlimit($coursename, $limit) . '">';
		$output .= theme_mb2nl_wordlimit($coursename, $limit);
		$output .= '</a>';
		$output .= '</li>';
	}

	$output .= '</ul>';
	$output .= '</li>';

	return $output;


}




/*
 *
 * Method to check if is my course list
 *
 */
function theme_mb2nl_get_mycourses ()
{
	$my_courses = enrol_get_my_courses();
	$courses = array();

	foreach ($my_courses as $c)
	{
		$course_access = theme_mb2nl_site_access( $c->id );

		if ( !$c->visible && !in_array( $course_access, array('admin', 'manager', 'editingteacher') ) )
		{
			continue;
		}

		$courses[] = array('id'=> $c->id, 'fullname' => $c->fullname, 'visible' => $c->visible);
	}

	return $courses;

}






/*
 *
 * Method to get icon navigation
 *
 */
function theme_mb2nl_iconnav($page)
{

    $iconnavs = theme_mb2nl_theme_setting($page, 'navicons');

    if ($iconnavs !='')
    {
        return theme_mb2nl_static_content($iconnavs, true, array('listcls'=>'theme-iconnav'));
    }

}
