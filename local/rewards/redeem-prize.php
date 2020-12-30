<?php


use local_rewards\rewards_table;

require_once(dirname(__FILE__) . "/../../config.php");
require_once($CFG->libdir . '/adminlib.php');
require_once(dirname(__FILE__) . "/lib.php");

$action     = optional_param('action', '', PARAM_TEXT);
$delete     = optional_param('delete', 0, PARAM_INT);
$id         = optional_param('id', 0, PARAM_INT);
$confirm    = optional_param('confirm', 0, PARAM_INT);
$activate   = optional_param('activate', 0, PARAM_INT);
$deactivate = optional_param('deactivate', 0, PARAM_INT);


$context = context_system::instance();
$PAGE->set_context($context);

require_login();

$url    = new moodle_url('/local/rewards/redeem-prize.php');

$PAGE->set_title(get_string('pluginname', 'local_rewards'));
$PAGE->set_url($url);

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('existing_rewards', 'local_rewards'));

$renderer = $PAGE->get_renderer('local_rewards');
$data = get_all_prizes();
$returndata = array();
if(!empty($data)) {
    foreach ($data as  $value) {
        # code...
        $value->prizeimage = get_image_url($value);
        $returndata[] = (array) $value; 
    }
}
echo $renderer->render_prize_listing($returndata);

?>


<?php
$PAGE->requires->js_call_amd('local_rewards/custom','init');
echo $OUTPUT->footer();
?>