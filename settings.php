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

defined('MOODLE_INTERNAL') || die;

$settings = new admin_settingpage('local_analytics', get_string('pluginname', 'local_analytics'));
$ADMIN->add('localplugins', $settings);

$name = 'local_analytics/enabled';
$title = get_string('enabled', 'local_analytics');
$description = get_string('enabled_desc', 'local_analytics');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);

$name = 'local_analytics/imagetrack';
$title = get_string('imagetrack', 'local_analytics');
$description = get_string('imagetrack_desc', 'local_analytics');
$default = true;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);

$name = 'local_analytics/siteurl';
$title = get_string('siteurl', 'local_analytics');
$description = get_string('siteurl_desc', 'local_analytics');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

$name = 'local_analytics/siteid';
$title = get_string('siteid', 'local_analytics');
$description = get_string('siteid_desc', 'local_analytics');
$default = '1';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

$name = 'local_analytics/trackadmin';
$title = get_string('trackadmin', 'local_analytics');
$description = get_string('trackadmin_desc', 'local_analytics');
$default = false;
$setting = new admin_setting_configcheckbox($name, $title, $description, $default, true, false);
$settings->add($setting);