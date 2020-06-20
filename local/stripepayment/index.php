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
echo  '<button type="button" class="collapsible">Terms and Conditions:</button>
<div class="content">
<p><br></p>
<p>A one-time registration fee of $10 is applicable from 01st August 2020.This fee is waived for all sign-ups during our promotional period from today to 31st July 2020</p>
<p>And it will be applicable for subscriptions that has lapsed for 30 days or more.</p>
<p>There are two packages to choose from&nbsp;</p>
<p>a) $180 and/or</p>
<p>b) $320&nbsp;</p>
<p><span style="font-size: 1rem; font-weight: inherit;">Modes of payments - PayNow / direct bank transfer / Stripe (for&nbsp;</span><br></p>
<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; (First payment)&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Credit/Debit card payment)</p>
<p><span style="font-size: 1rem;"><b>$180 package (valid for 30 days from day of subscription)</b></span><br></p>
<p>- subscription fees are non-refundable</p>
<p>- fees will be deducted every 30 days from date of purchase via Stripe.</p>
<p>- SMS reminders for renewal payments when credits runs low, will be sent out 7, 3 &amp; 1day prior to expiry&nbsp;</p>
<p>- accessible to tutorial videos and small group tuition.&nbsp;</p>
<p>- students may access to tutorial videos for any subjects at any levels</p>
<p>-&nbsp; unused credits may be used to buy the assessments available at our partner online bookstore before expiry.</p>
<p><span style="font-size: 1rem;"><b>$320 package (valid for 30 days from day of subscription)</b></span><br></p>
<p>- subscription fees are non-refundable</p>
<p>- fees will be deducted every 30 days from date of purchase via Stripe.</p>
<p>- SMS reminders for renewal payments when credits runs low, will be sent out 7, 3 &amp; 1day prior to expiry</p>
<p>- accessible to video tutorials, small group tuition and individual coaching.</p>
<p>- students may access to tutorial videos for any subjects at any levels</p>
<p>- unused credits may be used to buy the assessments available at our partner online bookstore before expiry.</p>
<p><span style="font-size: 1rem; font-weight: inherit;"><br></span></p>
<p><span style="font-size: 1rem; font-weight: inherit;">No private tutorial arrangements between students and tutors is allowed at any time. VLEACADEMY reserves the right to pursue and claim back any losses incurred as a result of the act of poaching.</span><br></p>
<p><span style="font-size: 1rem;"><b>Charges for Tutorials :-</b></span><br></p>
<p>a) each tutorial video is $10.</p>
<p>b) each small group tutorial is $20 per tutorial&nbsp; with a minimum of&nbsp; 3 to a maximum of 10 students (group tutorial will not commence should the group size falls below 3 students)</p>
<p>c) cut-off time to sign up for tutorial is 24 hours prior to start of lesson</p>
<p>d) duration for each tutorial is 1 hour.</p>
<p>e) individual coaching is $40 an hour for full time tutor and $60 an hour for ex/current school teacher.</p></br></br></br>
</div>';


echo $OUTPUT->footer();
?>
<style>
	.pricing-plan{background-color:#fff;border-radius: 10px;}
	.pricewrapper .fone, .pricewrapper .ftwo{display: inline-block;}
	.pricewrapper .fone{margin-right: 10px;border-right: solid 1px #ccc;padding-right: 5px;}
.collapsible {
  background-color: #fff;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #13b8dd;
}

.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #FFFFFF;
}
#bottom-abcd{
  display: none;
}
</style>
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>
