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
 * @copyright  Albert Gasset <albert.gasset@gmail.com>
 * @copyright  Marc Català <reskit@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function local_stripepayment_extend_navigation($root) {
    global $CFG,$PAGE,$USER;
    
    
}

function local_stripepayment_process_payment ($params, $stripeToken) {

    global $CFG, $USER, $DB;

    require_once($CFG->dirroot.'/local/stripepayment/stripe/Stripe.php');
    if ($params['testmode'] == 1) {
        Stripe::setApiKey($params['private_test_key']);
        $pubkey = $params['public_test_key'];
    } else {
        Stripe::setApiKey($params['private_live_key']);
        $pubkey = $params['public_live_key'];
    }

    if(!empty($stripeToken))
    {
        // Check if the price has been modified by some mischievious user
        $original_price = '';
        if($params['paymentplan'] == 1) {
            $original_price = 180;
        } elseif($params['paymentplan'] == 2) {
             $original_price = 320;
        }elseif($params['paymentplan'] == 3) {
             $original_price = 500;
        }
        
        if($params['price'] < $original_price) {
            $result = 'Illegal activity detected. Please try again';
        } else {
            $amount_cents = $params['price']*100;
            $insertid = insert_payment_info($USER->id, $params['paymentplan']);
            if(!empty($insertid)) {                             // Invoice ID
                $description = "Invoice #" . $insertid . " - " . $insertid. '-- '.$USER->email;
    
                try {
    
                    $charge = Stripe_Charge::create(array(
                                    
                                    "amount" => $amount_cents,
                                    "currency" => "sgd",
                                    "source" => $stripeToken,
                                    "description" => $description,
                                    "metadata" => ["order_id" => $insertid,
                                        "name" => $USER->firstname,
                                        "email" => $USER->email,
                                        "userid" => $USER->id,
                                    ])
                    );
    
                    
                    // Payment has succeeded, no exceptions were thrown or otherwise caught
                    $paymentResponse = $charge->__toArray(TRUE);
                    if($paymentResponse['status']== 'succeeded') {
                        $result = "success";
                        // Update the status in the databsae
                        $update = new stdClass();
                        $update->id = $paymentResponse['metadata']['order_id'];
                        $update->status = 1;
                        
                        update_user_credit($update);
                    }
                        $result = "success";
        
                    } catch(Stripe_CardError $e) {
        
                        $error = $e->getMessage();
                        $result = "";
    
                } catch (Stripe_InvalidRequestError $e) {
                    $result = "Invalid request";
                } catch (Stripe_AuthenticationError $e) {
                    $result = "Authentication error";
                } catch (Stripe_ApiConnectionError $e) {
                    $result = "Stripe_ApiConnectionError";
                } catch (Stripe_Error $e) {
                    $result = "Stripe_Error";
                } catch (Exception $e) {
    
                    if ($e->getMessage() == "zip_check_invalid") {
                        $result = "Invalid Zip";
                    } else if ($e->getMessage() == "address_check_invalid") {
                        $result = "Invalid Address";
                    } else if ($e->getMessage() == "cvc_check_invalid") {
                        $result = "Invalid CVC";
                    } else {
                        $result = "Declined";   
                    }
                }
            } else {
                $result = 'Some problem occurred. Please try again';
            }
        
        }

        if($result=="success") {

            $response = "<div class='alert alert-success fade in alert-dismissible col-sm-offset-3 col-sm-9 text-success'>Your Payment has been processed successfully.</div>";

        } else{
            $result = 'Some problem occurred. Please try later';
            $response = "<div class='alert alert-danger fade in alert-dismissible text-danger'>Stripe Payment Status - $result.</div>";
        }
    }
    return $response;
}

function insert_payment_info($userid, $creditplan) {

    global $DB;

    if($creditplan == 1) {
        $total_credit = 180;
    } elseif($creditplan == 2) {
        $total_credit = 320;
    } elseif($creditplan == 3) {
        $total_credit = 500;
    }
    
    $payment = new stdClass();
    $payment->userid = $userid;
    $payment->total_credit = $total_credit;
    $payment->total_credit_left = $total_credit;
    $payment->expire = 0;
    $payment->total_credit_consumed =0;
    $payment->status = 0;
    $payment->timemodified = time();
    $data->payment_type = 'credit_card';
    $insertid = $DB->insert_record('user_credits', $payment);
    return $insertid;
}

function update_user_credit($update) {

  global $DB, $USER;
  $new_credit = $DB->get_field('user_credits', 'total_credit', array('id' => $update->id));
  $fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
  if ($record =  $DB->get_record('user_info_data', array('fieldid' => $fieldid, 'userid' => $USER->id))) {
    $balance = $record->data;
    $balance += $new_credit;
    $sql = "update {user_info_data} set data = $balance where id=$record->id";
    $DB->execute($sql);
  }
  else {
    $data = new stdClass();
    $payment->userid = $USER->id;
    $payment->fieldid = $fieldid;
    $payment->data = $new_credit;
    $payment->dataformat = 0;
    $insertid = $DB->insert_record('user_info_data', $payment);
  }
  $sql = "update {user_credits} set status = 1 where id=$update->id";
  $DB->execute($sql);
  return true;
}

function current_active_plan($userid) {
  global $DB;
  $plan = array(180 => 'Essential', 320 => 'Premium', 500 => 'Ultimate');
  $sql = "SELECT total_credit FROM {user_credits} where userid = $userid and status = 1 and expire = 0 and deleted = 0 ORDER BY id DESC LIMIT 0, 1";
  $record = $DB->get_record_sql($sql);
  $current_plan = isset($record->total_credit) ? $plan[$record->total_credit] : 'No Active Plan';
  return $current_plan;
}
