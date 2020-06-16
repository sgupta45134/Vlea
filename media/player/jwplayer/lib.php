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
 *  JW Player media player library.
 *
 * @package    media_jwplayer
 * @copyright  2017 Ruslan Kabalin, Lancaster University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Current version of cloud-hosted JW Player.
if (!defined('MEDIA_JWPLAYER_CLOUD_VERSION')) {
    // This is the only place where version needs to be changed in case of new
    // release avialability.
    define('MEDIA_JWPLAYER_CLOUD_VERSION', '7.12.13');
}

if (!defined('MEDIA_JWPLAYER_VIDEO_WIDTH_RESPONSIVE')) {
    // Default video width if no width is specified.
    // May be defined in config.php if required.
    define('MEDIA_JWPLAYER_VIDEO_WIDTH_RESPONSIVE', '100%');
}
if (!defined('MEDIA_JWPLAYER_VIDEO_ASPECTRATIO_W')) {
    // Default video aspect ratio for responsive mode if no height is specified.
    // May be defined in config.php if required.
    define('MEDIA_JWPLAYER_VIDEO_ASPECTRATIO_W', 16);
}
if (!defined('MEDIA_JWPLAYER_VIDEO_ASPECTRATIO_H')) {
    // Default video aspect ratio for responsive mode if no height is specified.
    // May be defined in config.php if required.
    define('MEDIA_JWPLAYER_VIDEO_ASPECTRATIO_H', 9);
}
if (!defined('MEDIA_JWPLAYER_AUDIO_WIDTH')) {
    // Default audio width if no width is specified.
    // May be defined in config.php if required.
    define('MEDIA_JWPLAYER_AUDIO_WIDTH', 400);
}
if (!defined('MEDIA_JWPLAYER_AUDIO_HEIGHT')) {
    // Default audio heigth if no height is specified.
    // May be defined in config.php if required.
    define('MEDIA_JWPLAYER_AUDIO_HEIGHT', 30);
}

/**
 * File serving.
 *
 * @param stdClass $course The course object.
 * @param stdClass $cm The cm object.
 * @param context $context The context object.
 * @param string $filearea The file area.
 * @param array $args List of arguments.
 * @param bool $forcedownload Whether or not to force the download of the file.
 * @param array $options Array of options.
 * @return void|false
 */
function media_jwplayer_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {

    if ($context->contextlevel != CONTEXT_SYSTEM) {
        send_file_not_found();
    }
    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'defaultposter') {
        send_file_not_found();
    }
    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    require_login($course, true);

    // All good. Serve the exported data.
    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = "/$context->id/media_jwplayer/$filearea/$relativepath";
    if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
        return false;
    }
    send_stored_file($file, 0, 0, $forcedownload, $options);
}
