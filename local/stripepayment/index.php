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
require_once('lib.php');
global $DB;

$search = optional_param('search','',PARAM_RAW);
$page = optional_param('page', 0, PARAM_INT);
$perpage = optional_param('perpage', 2, PARAM_INT);

$PAGE->set_context(context_system::instance());
require_login();
$PAGE->set_url('/local/stripepayment/index.php');
$PAGE->set_title('Choose Plans');
$PAGE->set_heading('Choose Plans');
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();
$renderer = $PAGE->get_renderer('local_stripepayment');


echo $renderer->print_pricing_plan();



echo $OUTPUT->footer();
?>
<style>
	#page-local-stripepayment-index #region-main, #page-local-stripepayment-index .card, #page-local-stripepayment-index .card-body {background-color:#add8e6;
	}
	.pricing-plan{background-color:#fff;border-radius: 10px;}
	.pricewrapper .fone, .pricewrapper .ftwo{display: inline-block;}
	.pricewrapper .fone{margin-right: 10px;border-right: solid 1px #ccc;padding-right: 5px;}
	#bottom-abcd{
	    display: none;
	}
	#bottom {
display: none;
}
#footer{
   display: none; 
}
@media (min-width: 768px).col-md-3{
    display: none;
}
</style>
