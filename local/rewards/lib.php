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
 * local rewards
 *
 * @package     local_rewards
 * @author      Kevin Dibble
 * @copyright   2017 LearningWorks Ltd
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

//echo dirname(__FILE__).'/classes/image_processor.php';die();
require_once(dirname(__FILE__).'/classes/image_processor.php');
/**
 *
 * Extend local_rewards navigation
 *
 * @param global_navigation $nav
 */
function local_rewards_extends_navigation(global_navigation $nav) {
    return local_rewards_extend_navigation($nav);
}

/**
 *
 * Extend navigation to show the local_rewards in the navigation block
 *
 * @param global_navigation $nav
 */
function local_rewards_extend_navigation(global_navigation $nav) {
    global $CFG, $DB;
    $context = context_system::instance();
    $pluginname = get_string('pluginname', 'local_rewards');
    if (has_capability('local/rewards:manageprize', $context)) {
        $mainnode = $nav->add(
            get_string('pluginname', 'local_rewards'),
            new moodle_url($CFG->wwwroot . "/local/rewards/manage.php"),
            navigation_node::TYPE_CONTAINER,
            'local_rewards',
            'local_rewards',
            new pix_icon('newspaper', $pluginname, 'local_rewards')
        );
        $mainnode->nodetype = 0;
        $mainnode->showinflatnavigation = true;
    }
    
}

function send_acknowledement_mail_to_user($fromuser, $touseremail, $message, $subject) {

        global $DB;

        $fromuser = $DB->get_record('user', array('email'=>$fromuser));
        $touser = new stdClass();
        $touser->id = 1;
        $touser->mailformat = 1;
        $fromuser->mailformat = 1;
        $touser->email = $touseremail;
        $touser->deleted = 0;
        $touser->auth = 'manual';
        $messagehtml = text_to_html($message);
        email_to_user($touser, $fromuser,
        $subject, $message, $messagehtml);
}

function get_single_record($id) {

    global $DB;

    $record = $DB->get_record('local_rewards', array('id'=>$id));
    return $record;

}

/**
 * Options to pass to the filepicker when adding items to a gallery.
 *
 * @param \mod_mediagallery\gallery $gallery
 * @return array
 */
function rewards_filepicker_options() {
    $pickeroptions = array(
        'maxbytes' => 1234456,
        'maxfiles' => 1,
        'subdirs' => false,
        'accepted_types' => '*'
    );
    return $pickeroptions;
}

/**
 * Serves any files associated with the plugin (e.g. tile photos).
 * For explanation see https://docs.moodle.org/dev/File_API
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function local_rewards_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    $context = context_system::instance();
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
   
    if (!($filearea == 'prize')) {
        debugging('Invalid file area ' . $filearea);
        send_file_not_found();
    }
    
    // Make sure the user is logged in and has access to the course.
    require_login();
    if($filearea == 'prize') {
        $fileapiparams = file_api_params();
    }

    $prizeid = (int)$args[0];
    $filepath = $args[1];
    $filename = $args[2];

    $fs = get_file_storage();
    // $prizeid = 17;
    $filepath = '/prize/';
    // $filename = 'default_course.jpg';
    // echo $context->id;
    // echo $fileapiparams['component'];
    // echo $filearea;
    // echo $prizeid;
    // echo $filepath;
    // echo $filename;
    $file = $fs->get_file($context->id, $fileapiparams['component'], $filearea, $prizeid, $filepath, $filename);
    send_stored_file($file, 86400, 0, $forcedownload, $options);
}

function file_api_params() {
        return array(
            'component' => 'local_rewards',
            'filearea' => 'prize',
            'filepath' => '/prize/',
            'tempfilearea' => 'tempprize'
        );
}

 function set_file_from_stored_file($sourcefile, $newfilename, $prizeid) {

        $context = context_system::instance();
        if ($sourcefile) {
            // if ($sourcefile->get_itemid() == $this->sectionid
            //     && $sourcefile->get_contextid() == $this->context->id
            //     && $sourcefile->get_filename() == $this->filename
            //     && $sourcefile->get_filepath() == self::file_api_params()['filepath']) {
            //     debugging("File is already set for this section");
            //     return false;
            // }
            $sourceimageinfo = $sourcefile->get_imageinfo();
            $newwidth = 1500;//self::get_max_image_width();

            // In case the new file has the same name as the old one, delete it early.
            // Otherwise we do it in a few lines' time when we know we have the new one.
            // if ($this->filename == $sourcefile->get_filename()) {
            //     $this->delete_stored_file();
            // }
            $newfile = image_processor::adjust_and_copy_file(
                $sourcefile,
                $newfilename,
                $context,
                $prizeid,
                $newwidth,
                $sourceimageinfo['height'] * $newwidth / $sourceimageinfo['width']
            );
            
            if ($newfile) {
                // // if ($this->filename != $sourcefile->get_filename()) {
                // //     // We didn't delete the file a few lines ago so do it now.
                // //     $this->delete_stored_file();
                // // }
                // $this->set_file($newfile);
                return $newfile;
            } else {
                debugging('Failed to set file from details - filename ' . $newfilename);

                // Restore the original file name of the original file.
                debugging("New file could not be created");
                debugging($newfile);
                // $this->get_file()->rename(self::file_api_params()['filepath'], $this->filename);
                return false;
            }
        } else {
            debugging('Failed to set file from details - filename ' . $newfilename);
            return false;
        }
    }