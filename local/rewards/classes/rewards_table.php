<?php
/**
 * User: Surendra Prasad
 * Date: 5/09/18
 * Time: 2:13 PM
 */

namespace local_rewards;

use html_writer;
use moodle_url;

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/tablelib.php');

class rewards_table extends \table_sql {

    protected $count = 0;

    protected $max = null;

    /**
     * Constructor.
     *
     * @param int        $courseid Id of the course that the local is installed on
     * @param moodle_url $url      The base URL.
     *
     * @throws \coding_exception
     */
    public function __construct(moodle_url $url) {
        parent::__construct('local_rewards_table');

        $fields = "r.id,prizename, r.description, points, concat(u.firstname, ' ',u.lastname) as creator, createdby, r.timecreated";
        $from   = "  {local_rewards} r join {user} u  on u.id= r.createdby ";
        $where  = "1 ";
        $params = [];

        $this->define_baseurl($url);
        $this->define_columns([
            'prizename',            
            'description',
            'points',
            'creator',
            'timecreated',
            'actions',
        ]);
        $this->define_headers([
            get_string('prizename', 'local_rewards'),            
            get_string('description', 'local_rewards'), 
            get_string('points', 'local_rewards'), 
            get_string('createdby', 'local_rewards'), 
            get_string('timecreated', 'local_rewards'), 
            get_string('actions'), 
        ]);

        $this->sortable(false);
        $this->collapsible(false);
        $this->set_sql($fields, $from, $where, $params);
    }

    /**
     * Actions.
     *
     * @param stdClass $row The record.
     *
     * @return string
     * @throws \coding_exception
     * @throws \moodle_exception
     */
    public function col_actions($row) {
        global $OUTPUT, $DB;

        if ($this->is_downloading()) {
            return '';
        }

        $delete_url     = new moodle_url('/local/rewards/manage.php', array('delete'=>$row->id));
        $edit_url       = new moodle_url('/local/rewards/edit.php', array('id'=>$row->id));
        $activate_url   = new moodle_url('/local/rewards');
        $deactivate_url = new moodle_url('/local/rewards');

        if (is_null($this->max)) {
            $this->max = $DB->count_records_sql($this->countsql, $this->countparams);
        }

        $buttons = [];       


        $buttons[] = $OUTPUT->action_icon($edit_url, new \pix_icon('t/edit', get_string('edit')));
        // if ( ! $row->active) {
        //     $buttons[] = $OUTPUT->action_icon($activate_url, new \pix_icon('t/show', get_string('activate', 'block_vslate_quicklinks')));
        // } else {
        //     $buttons[] = $OUTPUT->action_icon($deactivate_url, new \pix_icon('t/hide', get_string('deactivate', 'block_vslate_quicklinks')));
        // }
        $buttons[] = $OUTPUT->action_icon($delete_url, new \pix_icon('t/delete', get_string('delete')));

        return implode(" ", $buttons);
    }

    /**
     * Will display this message if there are no records
     *
     * @throws \coding_exception
     */
    public function print_nothing_to_display() {
        echo html_writer::tag('p', markdown_to_html(get_string('no_records_yet', 'local_rewards')));
    }
    
    public function col_timecreated($row) {

        return userdate($row->timecreated);
    }
    
}