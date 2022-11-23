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
 * Privacy implementation block_course_modules
 *
 * @package    block_course_modules
 * @copyright  2022 Agam Verma
 */

namespace block_course_modules;

class block_course_modules_test extends \advanced_testcase {

    public function test_after_install() {
        global $DB, $CFG;

        $this->resetAfterTest(true);

        $this->assertTrue($DB->record_exists('block', array('name' => 'course_modules', 'visible' => 1)));
    }
}
