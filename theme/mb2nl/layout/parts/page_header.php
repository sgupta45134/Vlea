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

$imagesFolder = $CFG->dirroot . theme_mb2nl_theme_dir() . '/mb2nl/pix/header/';
$img = theme_mb2nl_random_image($imagesFolder,'header');

$coursemenu = $OUTPUT->context_header_settings_menu();
$modmenu = $OUTPUT->region_main_settings_menu();
$courseeditingbtn = $coursemenu ? ! theme_mb2nl_theme_setting( $PAGE, 'showsitemnu' ) : 1;
$showheadingbuttons = ( $courseeditingbtn && $OUTPUT->page_heading_button() );
$cls = $showheadingbuttons ? 'isbutton' : 'nobutton';

?>
<div id="page-header" class="<?php echo $cls; ?>">
	<div class="inner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                    <?php

						if ( ! theme_mb2nl_theme_setting( $PAGE, 'coursepanel' ) )
						{
							if ( $coursemenu || $modmenu )
							{
								echo $coursemenu . $modmenu;
							}
						}

						if ( $showheadingbuttons )
						{
							echo $OUTPUT->page_heading_button();
						}

					?>
                </div>
            </div>
        </div>
    </div>
</div>
