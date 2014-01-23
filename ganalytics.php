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
 
function analytics_trackurl() {
    global $DB, $PAGE, $COURSE;
    $pageinfo = get_context_info_array($PAGE->context->id);
    $trackurl = "'/";

    // Adds course category name.
    if (isset($pageinfo[1]->category)) {
        if ($category = $DB->get_record('course_categories', array('id'=>$pageinfo[1]->category))) {
            $cats=explode("/",$category->path);
            foreach ($cats as $cat) {
                if ($categorydepth = $DB->get_record("course_categories", array("id" => $cat))) {;
                    $trackurl .= urlencode($categorydepth->name).'/';
                }
            }
        }
    }

    // Adds course full name.
    if (isset($pageinfo[1]->fullname)) {
        if (isset($pageinfo[2]->name)) {
            $trackurl .= urlencode($pageinfo[1]->fullname).'/';
        } else if ($PAGE->user_is_editing()) {
            $trackurl .= urlencode($pageinfo[1]->fullname).'/'.get_string('edit', 'local_analytics');
        } else {
            $trackurl .= urlencode($pageinfo[1]->fullname).'/'.get_string('view', 'local_analytics');
        }
    }

    // Adds activity name.
    if (isset($pageinfo[2]->name)) {
        $trackurl .= urlencode($pageinfo[2]->modname).'/'.urlencode($pageinfo[2]->name);
    }
    
    $trackurl .= "'";
    return $trackurl;
}
 
function insert_analytics_tracking() {
    global $CFG;
    $enabled = get_config('local_analytics', 'enabled');
    $siteid = get_config('local_analytics', 'siteid');
    $trackadmin = get_config('local_analytics', 'trackadmin');
    $cleanurl = get_config('local_analytics', 'cleanurl');
    
    if ($enabled && (!is_siteadmin() || $trackadmin)) {
        $CFG->additionalhtmlhead .= "
            <script type='text/javascript' name='localga'>
              var _gaq = _gaq || [];
              _gaq.push(['_setAccount', '".$siteid."']);
              _gaq.push(['_trackPageview',".($cleanurl ? analytics_trackurl() : '')."]);
              _gaq.push(['_setSiteSpeedSampleRate', 50]);

              (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; 
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
              })();
            </script>
			";
    }
    
}

insert_analytics_tracking();