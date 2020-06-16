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
 * Method to get Google webfonts
 *
 */
function theme_mb2nl_google_fonts ($page, $attribs = array())
{

	$output = '';

	$gfontsubset = theme_mb2nl_theme_setting($page, 'gfontsubset');

	for ($i = 1; $i <=3; $i++)
	{

		$gfontname = theme_mb2nl_theme_setting($page, 'gfont' . $i);
		$gfontstyle = theme_mb2nl_theme_setting($page, 'gfontstyle' . $i);
		$isStyle = $gfontstyle !='' ? ':' . $gfontstyle : '';

		$isSubset = $gfontsubset !='' ? '&amp;subset=' . $gfontsubset : '';

		if ($gfontname !='')
		{
			$output .= '<link href="//fonts.googleapis.com/css?family=' . str_replace(' ', '+', $gfontname) . $isStyle . $isSubset . '" rel="stylesheet">';
		}

	}

	return $output;

}






/*
 *
 * Method to get custom fonts
 *
 */
function theme_mb2nl_custom_fonts ()
{

	global $PAGE;
    $output = '';

    for ($i = 1; $i <= 3; $i++)
	{
        $fonts = theme_mb2nl_filearea( 'cfontfiles' . $i, false );
        $fontname = theme_mb2nl_theme_setting( $PAGE, 'cfont' . $i );
        $x = 0;

        if ( count( $fonts ) && $fontname )
        {
            $output .= '@font-face {';
            $output .= 'font-family:\'' .$fontname . '\';';
            $output .= 'src: ';

            foreach ( $fonts as $f )
            {
                $x++;
                $finfo = pathinfo( $f );
                $sep = $x == count( $fonts ) ? ';' : ',';
                $format = $finfo['extension'];

                if ( $finfo['extension'] === 'ttf' )
                {
                    $format = 'truetype';
                }

                $output .= 'url(\'' . $finfo['dirname'] . '/' . $finfo['basename'] . '\') format(\'' . $format . '\')' . $sep;
            }

            $output .= '}';
        }
    }

    return $output;

}




/*
 *
 * Method to typography custom styles
 *
 */
function theme_mb2nl_custom_typography ()
{

	global $PAGE;
	$output = '';

	// Custom stypography elements
	for ($i = 1; $i <= 3; $i++)
	{

		$el = theme_mb2nl_theme_setting($PAGE, 'celsel' . $i);
		$ff = theme_mb2nl_theme_setting($PAGE, 'ffcel' . $i);
		$fw = theme_mb2nl_theme_setting($PAGE, 'fwcel' . $i);


		if ($el !='')
		{
			$output .= $el;
			$output .= '{';
			$output .= $ff !== '0' ? 'font-family:' . theme_mb2nl_get_fonf_family($PAGE, $ff) . ';' : '';
			$output .= 'font-weight:' . $fw . ';';
			$output .= '}';
		}
	}

	return $output;

}







/*
 *
 * Method to get font family setting
 *
 */
function theme_mb2nl_get_fonf_family ($page, $font)
{

	$output = '\'' . theme_mb2nl_theme_setting($page, $font) . '\'';

	return $output;

}
