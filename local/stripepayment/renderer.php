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
 * Adaptive quiz renderer class
 *
 * This module was created as a collaborative effort between Middlebury College
 * and Remote Learner.
 *
 * @package    mod_adaptivequiz
 * @copyright  2013 onwards Remote-Learner {@link http://www.remote-learner.ca/}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class local_stripepayment_renderer extends plugin_renderer_base {
   
    /**
     * This function prints paging information
     * @param int $totalrecords the total number of records returned
     * @param int $page the current page the user is on
     * @param int $perpage the number of records displayed on one page
     * @return string HTML markup
     */
    public function print_paging_bar($totalrecords, $page, $perpage,$search) {
        global $OUTPUT;

        $baseurl = new moodle_url('/local/stripepayment/listjobs.php');
        
        $baseurl->params(array('search' => $search));

        $output = '';
        $output .= $OUTPUT->paging_bar($totalrecords, $page, $perpage, $baseurl);
        return $output;
    }

   public function print_pricing_plan() {

    global $CFG;
    $output = '';

    $output .= '<div class="myclass">
    <div class="container">
      <div class="panel pricing-table">
        
        <div class="pricing-plan">
          <img src="https://i.postimg.cc/QNFsCWLL/envelop.png" alt="" class="pricing-img">
          <h2 class="pricing-header">Essential</h2>
            <div class="pricewrapper">
              <div class="fone">
                  <span class="credit">180 <br/>credits</span>
              </div>
              <div class="ftwo">
                $180
              </div>
            </div>
          <ul class="pricing-features">
            <li class="pricing-features-item">Video Tutorial</li>
            <li class="pricing-features-item">Small Group Tuition</li>
          </ul>
          <a href="'.$CFG->wwwroot.'/local/stripepayment/payment.php?p=1" class="is-featured  pricing-button">Buy Now</a>
        </div>
        
        <div class="pricing-plan">
          <img src="https://i.postimg.cc/gk5W3cWw/plane1.png" alt="" class="pricing-img">
          <h2 class="pricing-header">Premium</h2>
          <div class="pricewrapper">
              <div class="fone">
                  <span class="credit">320 <br/>credits</span>
              </div>
              <div class="ftwo">
                $320
              </div>
            </div>
          <ul class="pricing-features">
            <li class="pricing-features-item">Video Tutorial</li>
            <li class="pricing-features-item">Small Group Tuition</li>
            <li class="pricing-features-item">Individual Coaching</li>
          </ul>
          
          <a href="'.$CFG->wwwroot.'/local/stripepayment/payment.php?p=2" class="is-featured  pricing-button">Buy Now</a>
        </div>
        
        <div class="pricing-plan">
          <img src="https://i.postimg.cc/QMxT2qFK/rocket2.png" alt="" class="pricing-img">
          <h2 class="pricing-header">Ultimate</h2>
          <div class="pricewrapper">
              <div class="fone">
                  <span class="credit">500 <br/>credits</span>
              </div>
              <div class="ftwo">
                $500
              </div>
            </div>
          <ul class="pricing-features">
            <li class="pricing-features-item">Video Tutorial</li>
            <li class="pricing-features-item">Small Group Tuition</li>
            <li class="pricing-features-item">Individual Coaching</li>
          </ul>
          
          <a href="'.$CFG->wwwroot.'/local/stripepayment/payment.php?p=3" class="is-featured  pricing-button">Buy Now</a>
        </div>
       
      </div>
    </div>
  </div>';

      return $output;
   }

   public function print_checkout_form($formparams) {

    global $USER, $CFG;
    $output = '';
    $output .= '<h2>Please enter your card details</h2>';
    $output .= '
    <div class="panel panel-default">
    <div class="panel-body">
    <div class="row">
    <div class="col-md-8">
    <form action="" class="form-horizontal" method="POST" id="payment-form">
        <fieldset>
          <input type="hidden" id="publickey" name="publickey" value="'.$formparams['public_key'].'" />

            <div class="form-group">
                  <label class="col-sm-3 control-label" for="accountNumber">Payment Amount</label>
                  <div class="col-sm-9">
                      <input type="text" class="form-control" id="price" name="price" value="'.$formparams['price'].'.00" disabled>
                  </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="accountNumber">Card Number</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" size="20" data-stripe="number" placeholder="0000000000000000" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="expirationMonth">Expiration Date</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-xs-6">
                            <select class="form-control" data-stripe="exp_month" required>
                                <option>Month</option>
                                <option value="01">Jan (01)</option>
                                <option value="02">Feb (02)</option>
                                <option value="03">Mar (03)</option>
                                <option value="04">Apr (04)</option>
                                <option value="05">May (05)</option>
                                <option value="09">June (06)</option>
                                <option value="07">July (07)</option>
                                <option value="08">Aug (08)</option>
                                <option value="09">Sep (09)</option>
                                <option value="10">Oct (10)</option>
                                <option value="11">Nov (11)</option>
                                <option value="12" selected="">Dec (12)</option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <select class="form-control" data-stripe="exp_year">
                                <option varlue="17">2017</option>
                                <option value="18">2018</option>
                                <option value="19">2019</option>
                                <option value="20" selected="">2020</option>
                                <option value="21">2021</option>
                                <option value="22">2022</option>
                                <option value="23">2023</option>
                                <option value="21">2024</option>
                                <option value="22">2025</option>
                                <option value="23">2026</option>
                                <option value="21">2027</option>
                                <option value="22">2028</option>
                                <option value="23">2029</option>
                                <option value="21">2030</option>
                                <option value="22">2031</option>
                                <option value="23">2032</option>
                                <option value="21">2033</option>
                                <option value="22">2034</option>
                                <option value="23">2035</option>
                                <option value="21">2036</option>
                                <option value="22">2037</option>
                                <option value="23">2038</option>
                                <option value="21">2039</option>
                                <option value="22">2040</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="cvNumber">Card CVV</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" data-stripe="cvc" placeholder="000">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" name="pay" id="pay" class="btn btn-success">Pay Now</button>
                </div>
                
            </div>
        </fieldset>
    </form>
    </div>
    <div class="col-md-4">
    <img src="'.$CFG->wwwroot.'/local/stripepayment/stripe-payment-icon-png-transparent-png.png"  />
    <img src="'.$CFG->wwwroot.'/local/stripepayment/powered_by_stripe.png"  />
    </div>
    </div>
    
    </div>
    ';

    return $output;
   }
}
