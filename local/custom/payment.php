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
 * user trainer_record page.
 *
 * @package    core
 * @subpackage auth
 * @copyright  sudhanshu gupta<sudhanshug5@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
require_once('renderer.php');
require_login();
global $USER;
$paymentid = optional_param('p', 0, PARAM_INT);
$notify =  optional_param('notify', 0, PARAM_INT);

require_once($CFG->dirroot . '/user/editlib.php');

$PAGE->set_url("/local/custom/payment.php?p=$paymentid");
$PAGE->set_context(context_system::instance());
if($notify == 1){
  $user = $DB->get_record('user', array('id' => $USER->id));
  $config = get_config('local_custom');
  $emailuser = new stdClass();
  $emailuser->email = $config->email;
  $emailuser->firstname = 'Admin';
  $emailuser->lastname = '';
  $emailuser->maildisplay = true;
  $emailuser->mailformat = 1; // 0 (zero) text-only emails, 1 (one) for HTML/Text emails.
  $emailuser->id = -99;
  $emailuser->firstnamephonetic = '';
  $emailuser->lastnamephonetic = '';
  $emailuser->middlename = '';
  $emailuser->alternatename = '';
  $from = \core_user::get_noreply_user();
  $subject = get_string('payment_received', 'local_custom');
  $credits = array(1=>180, 2=>320, 3 =>500);
  $a = new stdClass();
  $a->parent_name = $user->parent;
  require_once('../stripepayment/lib.php');
  $a->plan_name = subscribed_plan_name($credits[$paymentid]);
  $a->credits = $credits[$paymentid];
  $a->date = date("d-m-Y, H:i:s", time());
  $message = get_string('message', 'local_custom', $a);
  email_to_user($emailuser, $from, $subject, $message);
  redirect("$CFG->wwwroot/local/custom/payment.php?p=$paymentid", get_string('notify_done', 'local_custom'));
}

//$PAGE->navbar->add($call_back_request);
$renderer = $PAGE->get_renderer('local_custom');
$value = new stdClass();
$value->prizeimage = $CFG->wwwroot.'/local/custom/pix/paynow_qrcode.jpg';
$value->paymentid = $paymentid;
$returndata = $value; 
//print_r($returndata);die;
//echo $renderer->render_paynow($returndata);

//$mform_payment = new payment_form(null, $userid);

$PAGE->set_heading($SITE->fullname);
echo $OUTPUT->header();
echo $renderer->render_paynow($returndata);
echo $OUTPUT->footer();

