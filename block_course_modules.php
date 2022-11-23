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
// This is a custom moodle plugin file.

/**
 * This file contains the Activity modules block.
 *
 * @package    block_course_modules
 * @copyright  2022 Agam Verma
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/filelib.php');

class block_course_modules extends block_list {
    public function init() {
        $this->title = get_string('pluginname', 'block_course_modules');
    }

    public function get_content() {
        global $CFG, $DB, $USER, $OUTPUT;

        $status = '';

        require_once($CFG->dirroot.'/course/lib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        $course = $this->page->course;

        $this->content = new stdClass;
        $this->content->items = array();

        $modinfo = get_fast_modinfo($course);

        foreach ($modinfo->cms as $cm) {
            $completiondetails = \core_completion\cm_completion_details::get_instance($cm, $USER->id);
            // Show the completion only when user completion is being tracked and completion is enabled.
            if ($completiondetails->is_tracked_user() && $completiondetails->has_completion()) {
                // Get completion state.
                if ($completiondetails->get_overall_completion()) {
                    $status = ' - '.get_string('complete');
                }
            }
            $added = userdate($cm->added, get_string('strftimedatemonthabbr', 'block_course_modules'));
            $content = $cm->id.' - '.$cm->name.' - '.$added.$status;
            $this->content->items[] = '<a href="'.$CFG->wwwroot.'/mod/'.$cm->modname.'/view.php?id='.$cm->id.'">'.$content.'</a>';
        }
        return $this->content;
    }

    /**
     * Returns the role that best describes this blocks contents.
     *
     * This returns 'navigation' as the blocks contents is a list of links to activities and resources.
     *
     * @return string 'navigation'
     */
    public function get_aria_role() {
        return 'navigation';
    }

    public function applicable_formats() {
        return array('all' => false, 'course-view' => true);
    }
}
