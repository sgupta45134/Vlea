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

$url    = new moodle_url('/local/rewards/manage.php');

$PAGE->set_title(get_string('pluginname', 'local_rewards'));
$PAGE->set_url($url);

// Proceed with the deletion.
if ($delete && $confirm && confirm_sesskey()) {
    $DB->delete_records('local_rewards', ['id' => $delete]);
    redirect($url, get_string('reward_deleted', 'local_rewards'), null, \core\output\notification::NOTIFY_SUCCESS);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('existing_rewards', 'local_rewards'));

// Are we trying to delete something?
if ($delete && ! $confirm) {
    echo $OUTPUT->confirm(
        get_string('really_delete', 'local_rewards'),
        new moodle_url($url, ['delete' => $delete, 'confirm' => 1, 'sesskey' => sesskey()]), $url
    );
    echo $OUTPUT->footer();
    die();
}


$addurl = '/local/rewards/add.php';
echo html_writer::tag('p', $OUTPUT->action_link($addurl, get_string('add_entry', 'local_rewards'), null, ['class' => 'btn btn-secondary'],
    new pix_icon('t/add', '', null, ['class' => 'iconsmall'])));

$table = new rewards_table($url);
$table->out(5, false);

echo html_writer::empty_tag('br');
echo html_writer::tag('p', $OUTPUT->action_link($addurl, get_string('add_entry', 'local_rewards'), null, ['class' => 'btn btn-secondary'],
    new pix_icon('t/add', '', null, ['class' => 'iconsmall'])));

$config = file_api_params();
echo $OUTPUT->footer();
