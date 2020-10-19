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
 * This plugin serves as a database and plan for all learning activities in the organization,
 * where such activities are organized for a more structured learning program.
 * @package    block_systemreports
 * @copyright  3i Logic<lms@3ilogic.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL
 * @author     Azmat Ullah <azmat@3ilogic.com>
 */
ob_start(); // put this at the top of all the code
require_once('../../config.php');
$setting = null;
$row = array();
require_once('systemreports_form.php');
require_once('lib.php');
require_once("{$CFG->libdir}/formslib.php");
global $DB, $USER, $OUTPUT, $PAGE, $CFG;

$viewpage = required_param('viewpage', PARAM_INT);
$rem = optional_param('rem', null, PARAM_RAW);
$edit = optional_param('edit', null, PARAM_RAW);
$delete = optional_param('delete', null, PARAM_RAW);
$id = optional_param('id', null, PARAM_INT);
$u_id = optional_param('id', null, PARAM_INT);
$lp = optional_param('lp', null, PARAM_INT);
$pageurl = new moodle_url('/blocks/systemreports/view.php', array('viewpage' => $viewpage));
$learningplan_url = new moodle_url('/blocks/systemreports/view.php?viewpage=1');
$nav_title = nav_title($viewpage);

require_login();
$context = context_system::instance();
if($viewpage != 3){
if (!has_capability('block/systemreports:managepages', $context)) {
    redirect($CFG->wwwroot);
}}
$PAGE->set_context($context);
$PAGE->set_url($pageurl);
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('systemreports', 'block_systemreports'));
$PAGE->set_title(get_string('systemreports', 'block_systemreports'));
$PAGE->navbar->ignore_active();
$PAGE->navbar->add(get_string("pluginname", 'block_systemreports'), new moodle_url($learningplan_url));
$PAGE->navbar->add($nav_title);
echo $OUTPUT->header();
if ($viewpage == 3) {
$userid = $USER->id;
$user = $DB->get_record('user', array('id' => $userid));
$userfullname = fullname($user, true);
echo $OUTPUT->heading($userfullname);
$fieldid = $DB->get_field('user_info_field', 'id', array('shortname' => 'user_credits'));
$balance = $DB->get_field('user_info_data', 'data', array('fieldid' => $fieldid, 'userid' => $userid));
$credits = ($balance > 0) ? $balance : 0;
$total_credits = get_string('total_credits', 'local_stripepayment') . $credits;
echo $OUTPUT->heading($total_credits);
}
echo html_writer::start_tag('div class="report_table_design"');
$table = new html_table();
    
$table->size = array();
$table->align = array('center', 'center', 'center', 'center', 'center', 'center');
$table->width = '100%';
$table->data[] = $row;
echo html_writer::table($table);
if ($viewpage == 2) { // quater wise learning
    $form = new learningplan_form();
}else if ($viewpage == 1) { // Enrollment vs certificaton
    $form = new assigntraining_learningplan__form();
}else if ($viewpage == 3) { // Enrollment vs certificaton
    $form = new my_credit_history_form();
    $form1 = new my_purchase_history_form();
}
// Set viewpage with form.
if ($viewpage != 8) {
    $toform['viewpage'] = $viewpage;
    $form->set_data($toform);

// Display List.
    if ($table = $form->display_list()) {
        echo html_writer::table($table);
    }
    if(isset($form1)){
    if ($table = $form1->display_list()) {
        echo "<br><br>";
        echo html_writer::table($table);
    }
    }
}
echo html_writer::end_tag('div');
?>
    <!-- DataTables code starts-->
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot ?>/blocks/systemreports/public/datatable/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot ?>/blocks/systemreports/public/datatable/dataTables.tableTools.css">
<script type="text/javascript" language="javascript" src="<?php echo $CFG->wwwroot ?>/blocks/systemreports/public/datatable/jquery.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $CFG->wwwroot ?>/blocks/systemreports/public/datatable/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $CFG->wwwroot ?>/blocks/systemreports/public/datatable/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function () {
// fn for automatically adjusting table coulmns
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
        });

        $('.display').DataTable({
            dom: 'T<"clear">lfrtip',
             "order": [[ 0, "desc" ]],
            tableTools: {
                "aButtons": [
                    "copy",
                    "print",
                    {
                        "sExtends": "collection",
                        "sButtonText": "Save",
                        "aButtons": ["xls", "pdf"]
                    }
                ],
                "sSwfPath": "<?php echo $CFG->wwwroot ?>/blocks/systemreports/public/datatable/copy_csv_xls_pdf.swf"
            }
        });

        $(function(){
            var current = window.location.href;
            $('.report_table_design table thead a').each(function(){
                // if the current path is like this link, make it active
                if($(this).attr('href').indexOf(current) !== -1){
                    $(this).parent().addClass('active');
                }
            })
        })
    });
</script>

<?php

$PAGE->requires->js_init_call('M.block_systemreports.init', array($viewpage, $setting));
echo $OUTPUT->footer();

// End Form Display.