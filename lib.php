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
 * Piwik Analytics
 *
 * This module provides extensive analytics, without the privacy concerns
 * of using Google Analytics, see install_piwik.txt for installing Piwik
 *
 * @package    local_analytics
 * @copyright  2013 David Bezemer, www.davidbezemer.nl
 * @author     David Bezemer
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function get_config() {
    $enabled = get_config('local_analytics', 'enabled');
    $imagetrack = get_config('local_analytics', 'imagetrack');
    $siteurl = get_config('local_analytics', 'siteurl');
    $siteid = get_config('local_analytics', 'siteid');
}
 
function analytics_trackurl() {
    global $CFG, $DB, $PAGE, $COURSE, $OUTPUT;

    $pageinfo = get_context_info_array($PAGE->context->id);

    $trackurl = array();

    if ($COURSE->id == 1) {
        return '';
    }

    // Adds course category name.
    if (isset($pageinfo[1]->category)) {
        if ($category = $DB->get_record('course_categories', array('id'=>$pageinfo[1]->category))) {
            $trackurl[] = urlencode($category->name);
        }
    }

    // Adds course full name.
    if (isset($pageinfo[1]->fullname)) {
        $trackurl[] = urlencode($pageinfo[1]->fullname);
    }

    // Adds activity name.
    if (isset($pageinfo[2]->name)) {
        $trackurl[] = urlencode($pageinfo[2]->name);
    }

    return implode('/', $trackurl);
}

function insert_tracking() {

    if ($enabled) {
        $CFG->additionalhtmlfooter .= "";
    }

    if (debugging()) {
        $CFG->additionalhtmlfooter .= "<span class='badge badge-success'>/".$trackurl."</span>";
    }
}

insert_tracking();