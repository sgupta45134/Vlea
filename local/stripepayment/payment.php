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

$paymentplan = required_param('p', PARAM_INT);
$price = optional_param('price',0, PARAM_FLOAT);
$stripeToken = optional_param('stripeToken','',PARAM_RAW);
$PAGE->set_context(context_system::instance());
require_login();


$params = array(
        "testmode"   => get_config('local_stripepayment', 'testmode'),
        "private_live_key" => get_config('local_stripepayment', 'live_secret_key'),
        "public_live_key"  => get_config('local_stripepayment', 'live_public_key'),
        "private_test_key" => get_config('local_stripepayment', 'test_secret_key'),
        "public_test_key"  => get_config('local_stripepayment', 'test_public_key'),
        "paymentplan"  => $paymentplan,
        "price"  => $price
);

if(!empty($stripeToken)) {
    $response = local_stripepayment_process_payment ($params, $stripeToken);
}

$PAGE->set_url('/local/stripepayment/payment.php');
$PAGE->set_title('Payment details');
$PAGE->set_heading('Payment details');
$PAGE->set_pagelayout('standard');


echo $OUTPUT->header();
$renderer = $PAGE->get_renderer('local_stripepayment');

if(isset($response)){
    echo $response;
}
if($paymentplan == 1) {
    $price =180;
} elseif($paymentplan == 2) {
    $price = 320;
}elseif($paymentplan == 3) {
    $price = 500;
}
$publickey = $params['testmode']?$params['public_test_key']:$params['public_live_key'];
$formparams = array('price'=>$price, 'public_key'=>$publickey);
echo $renderer->print_checkout_form($formparams);

echo '<script type="text/javascript" src="https://js.stripe.com/v2/"></script>';
$PAGE->requires->js('/local/stripepayment/module.js');
echo $OUTPUT->footer();

?>