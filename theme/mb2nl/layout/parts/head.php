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

echo $OUTPUT->doctype();

$themeFaicon = theme_mb2nl_theme_setting($PAGE,'favicon','', true);
$vafIcon = $themeFaicon !='' ? $themeFaicon : $OUTPUT->favicon();

// Get boost theme amd files
$inline_js = 'require([\'theme_boost/loader\']);';
$inline_js .= 'require([\'jquery\',\'theme_boost/tooltip\'], function($){$(\'[data-toggle="tooltip"]\').tooltip()});';
$PAGE->requires->js_amd_inline( $inline_js );

?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
   	<link rel="shortcut icon" href="<?php echo $vafIcon; ?>" />
    <?php echo theme_mb2nl_favicon($PAGE); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo theme_mb2nl_google_fonts($PAGE); ?>
    <?php theme_mb2nl_font_icon($PAGE); ?>
	<?php theme_mb2nl_theme_scripts($PAGE); ?>
    <?php echo $OUTPUT->standard_head_html(); ?>
	<?php echo theme_mb2nl_ganalytics($PAGE); ?>
</head>
