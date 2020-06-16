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
 * The JWPlayer media_playback_stopped event.
 *
 * @package    media_jwplayer
 * @copyright  2017 Owen Barritt, Wine & Spirit Education Trust
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace media_jwplayer\event;
defined('MOODLE_INTERNAL') || die();

/**
 * Playback stop event handler.
 *
 * @package    media_jwplayer
 * @copyright  2017 Owen Barritt, Wine & Spirit Education Trust
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class media_playback_stopped extends \core\event\base {
    protected function init() {
        $this->data['crud'] = 'c'; // c(reate), r(ead), u(pdate), d(elete)
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    public static function get_name() {
        return get_string('eventmedia_playback_stopped', 'media_jwplayer');
    }

    public function get_description() {
        $logstring = "The user with id {$this->userid} has stopped playback of the video {$this->other['file']}";

        if (isset($this->other['position']) && $this->other['position'] != 'undefined') {
            $logstring .= " at {$this->other['position']}s";
        }
        if (isset($this->other['bitrate']) && $this->other['bitrate'] != 'undefined') {
            $logstring .= " at a bitrate of {$this->other['bitrate']}";
        }
        if ($this->other['reason'] == 'buffer') {
            $logstring .= " due to buffering";
        } else if ($this->other['reason'] == 'pause') {
            $logstring .= " due to user clicking pause";
        }

        return $logstring;
    }
}