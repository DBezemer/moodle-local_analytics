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
	$trackadmin = get_config('local_analytics', 'trackadmin');	
}
 
function alternative_trackurl() {
    
    // Retrieve globals
	global $DB, $PAGE, $COURSE, $SITE;
	// Pre-load search parameter for later use
    $search = optional_param('search', '', PARAM_RAW);
	// Get NavBar items
	$this->page->navbar->get_items();

	// Check if we are at site level, or at the login page
    if ($COURSE->id == 1 && empty($search)) {
        if (strpos($PAGE->url, "login")) {
            return "login";
        } else {
            return $SITE->shortname;
        }
	// Check if we got to this page searching
    } else if (!empty($search)) {
        return "search.php?keyword=".$search;
    } else {
	// No alternative trackurl necessary
		return false;
	}
}

function initiate_trackurl() {
	
	global $OUTPUT;
	// Initiate clean URL.
	if (!alternative_trackurl()) {
		$fullpath = explode(" /",strip_tags($OUTPUT->navbar()));
		$trackurl = str_replace(" ","+",implode("/",$fullpath));
	} else {
		$trackurl = alternative_trackurl();
	}
	
	return $trackurl;
}

function insert_tracking() {
	global $CFG;

    if ($enabled) {
        $CFG->additionalhtmlfooter .= "";
    }

    if (debugging()) {
        $CFG->additionalhtmlfooter .= "<span class='badge badge-success'>/".$trackurl."</span>";
    }
}

insert_tracking();