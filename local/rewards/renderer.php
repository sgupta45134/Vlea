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
 * Rewards plugin
 *
 * @package   local_assessments
 * @category  Local Plugins
 * @copyright 2018 
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class local_rewards_renderer extends \plugin_renderer_base
{
    //use renderable;
    public $data;
    /**
     * Renders the add dops page
     *
     * @return bool|string
     * @throws \moodle_exception
     */
    public function render_prize_listing($data)
    {
        // TODO: check for the capability
        
        $this->data['prizes'] = $data;
        //print_object($this->data);die();
        return $this->render_from_template('local_rewards/redeem-prize', $this->data);
    }

}
