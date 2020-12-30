<?php


use local_rewards\prize_redemption_table;

require_once(dirname(__FILE__) . "/../../config.php");
require_once($CFG->libdir . '/adminlib.php');


$context = context_system::instance();
$PAGE->set_context($context);

require_login();

$url    = new moodle_url('/local/rewards/prize-redemption-logs.php');

$PAGE->set_title(get_string('pluginname', 'local_rewards'));
$PAGE->set_url($url);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('prize-redemption-logs', 'local_rewards'));

$table = new prize_redemption_table($url);
$table->out(5, false);

echo $OUTPUT->footer();