<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'profile.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'timezone.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'user_rel.inc.php';

function user_profile_update($uid, $piid, $entry, $privacy)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($piid)) return false;
    if (!is_numeric($privacy)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (strlen(trim($entry)) > 0) {

        $entry = $db->escape($entry);

        $sql = "INSERT INTO `{$table_prefix}USER_PROFILE` (UID, PIID, ENTRY, PRIVACY) ";
        $sql.= "VALUES ('$uid', '$piid', '$entry', '$privacy') ON DUPLICATE KEY UPDATE ";
        $sql.= "ENTRY = VALUES(ENTRY), PRIVACY = VALUES(PRIVACY)";

        if (!$db->query($sql)) return false;

    } else {

        $sql = "DELETE FROM `{$table_prefix}USER_PROFILE` ";
        $sql.= "WHERE UID = '$uid' AND PIID = '$piid'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function user_get_profile($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $peer_uid = session::get_value('UID');

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_groups_array = array();

    $user_prefs = user_get_prefs($uid);
    
    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT, ";
    $sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $sql.= "USER_PEER.RELATIONSHIP, SESSIONS.ID FROM USER USER ";
    $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ";
    $sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$peer_uid') ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_TRACK` USER_TRACK ";
    $sql.= "ON (USER_TRACK.UID = USER.UID) ";
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID ";
    $sql.= "AND SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME)) ";
    $sql.= "WHERE USER.UID = '$uid' ";
    $sql.= "GROUP BY USER.UID";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $user_profile = $result->fetch_assoc();

    if (isset($user_prefs['ANON_LOGON']) && ($user_prefs['ANON_LOGON'] > USER_ANON_DISABLED)) {
        $anon_logon = $user_prefs['ANON_LOGON'];
    } else {
        $anon_logon = USER_ANON_DISABLED;
    }

    if ($anon_logon == USER_ANON_DISABLED && isset($user_profile['LAST_VISIT']) && $user_profile['LAST_VISIT'] > 0) {
        $user_profile['LAST_LOGON'] = format_time($user_profile['LAST_VISIT']);
    } else {
        $user_profile['LAST_LOGON'] = gettext("Unknown");
    }

    if (isset($user_profile['REGISTERED']) && $user_profile['REGISTERED'] > 0) {
        $user_profile['REGISTERED'] = format_date($user_profile['REGISTERED']);
    } else {
        $user_profile['REGISTERED'] = gettext("Unknown");
    }

    if (isset($user_profile['USER_TIME_BEST']) && $user_profile['USER_TIME_BEST'] > 0) {
        $user_profile['USER_TIME_BEST'] = format_time_display($user_profile['USER_TIME_BEST']);
    } else {
        $user_profile['USER_TIME_BEST'] = gettext("Unknown");
    }

    if (isset($user_profile['USER_TIME_TOTAL']) && $user_profile['USER_TIME_TOTAL'] > 0) {
        $user_profile['USER_TIME_TOTAL'] = format_time_display($user_profile['USER_TIME_TOTAL']);
    } else {
        $user_profile['USER_TIME_TOTAL'] = gettext("Unknown");
    }

    if (isset($user_prefs['DOB_DISPLAY']) && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {

        if ($user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_BOTH) {

            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
            $user_profile['AGE'] = format_age($user_prefs['DOB']);

        } else if ($user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_DATE) {

            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);

        } else if ($user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_AGE) {

            $user_profile['AGE'] = format_age($user_prefs['DOB']);
        }
    }

    if (isset($user_prefs['PIC_URL']) && strlen($user_prefs['PIC_URL']) > 0) {
        $user_profile['PIC_URL'] = $user_prefs['PIC_URL'];
    }

    if (isset($user_prefs['PIC_AID']) && is_md5($user_prefs['PIC_AID'])) {
        $user_profile['PIC_AID'] = $user_prefs['PIC_AID'];
    }

    if (isset($user_prefs['AVATAR_URL']) && strlen($user_prefs['AVATAR_URL']) > 0) {
        $user_profile['AVATAR_URL'] = $user_prefs['AVATAR_URL'];
    }

    if (isset($user_prefs['AVATAR_AID']) && is_md5($user_prefs['AVATAR_AID'])) {
        $user_profile['AVATAR_AID'] = $user_prefs['AVATAR_AID'];
    }

    if (isset($user_prefs['HOMEPAGE_URL']) && strlen($user_prefs['HOMEPAGE_URL']) > 0) {
        $user_profile['HOMEPAGE_URL'] = $user_prefs['HOMEPAGE_URL'];
    }

    if (!isset($user_profile['RELATIONSHIP'])) {
        $user_profile['RELATIONSHIP'] = 0;
    }

    if (isset($user_profile['PEER_NICKNAME'])) {

        if (!is_null($user_profile['PEER_NICKNAME']) && strlen($user_profile['PEER_NICKNAME']) > 0) {

            $user_profile['NICKNAME'] = $user_profile['PEER_NICKNAME'];
        }
    }

    if ($anon_logon == USER_ANON_DISABLED) {

        if (isset($user_profile['ID'])) {

            $user_profile['STATUS'] = gettext("Online");

        } else {

            $user_profile['STATUS'] = gettext("Inactive / Offline");

        }

    } else {

        $user_profile['STATUS'] = gettext("Unknown");
    }

    if (($user_post_count = user_get_post_count($uid))) {
        $user_profile['POST_COUNT'] = $user_post_count;
    } else {
        $user_profile['POST_COUNT'] = 0;
    }

    if (($user_local_time = user_format_local_time($user_prefs))) {
        $user_profile['LOCAL_TIME'] = $user_local_time;
    }

    if (user_is_banned($uid)) {

        $user_profile['USER_GROUPS'] = gettext("Banned");

    } else {

        perm_user_get_group_names($uid, $user_groups_array);

        if (sizeof($user_groups_array) > 0) {
            $user_profile['USER_GROUPS'] = implode(', ', $user_groups_array);
        } else {
            $user_profile['USER_GROUPS'] = gettext("Registered");
        }
    }

    return $user_profile;
}

function user_format_local_time(&$user_prefs_array)
{
    if (isset($user_prefs_array['TIMEZONE']) && is_numeric($user_prefs_array['TIMEZONE'])) {
        $timezone_id = $user_prefs_array['TIMEZONE'];
    } else {
        $timezone_id = forum_get_setting('forum_timezone', null, 27);
    }

    if (isset($user_prefs_array['GMT_OFFSET']) && is_numeric($user_prefs_array['GMT_OFFSET'])) {
        $gmt_offset = $user_prefs_array['GMT_OFFSET'];
    } else {
        $gmt_offset = forum_get_setting('forum_gmt_offset', null, 0);
    }

    if (isset($user_prefs_array['DST_OFFSET']) && is_numeric($user_prefs_array['DST_OFFSET'])) {
        $dst_offset = $user_prefs_array['DST_OFFSET'];
    } else {
        $dst_offset = forum_get_setting('forum_dst_offset', null, 0);
    }

    if (isset($user_prefs_array['DL_SAVING']) && user_check_pref('DL_SAVING', $user_prefs_array['DL_SAVING'])) {
        $dl_saving = $user_prefs_array['DL_SAVING'];
    } else {
        $dl_saving = forum_get_setting('forum_dl_saving', null, 'N');
    }

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS) + ($dst_offset * HOUR_IN_SECONDS);
    } else {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS);
    }

    $date_string = gmdate("i G j M Y", $local_time);

    list($min, $hour, $day, $month, $year) = explode(" ", $date_string);

    return sprintf(gettext("%s %s %s %s:%s"), $day, $month, $year, $hour, $min); // j M Y H:i
}

function user_get_profile_entries($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $user_profile_array = array();

    $session_uid = session::get_value('UID');

    $peer_relationship = user_get_relationship($uid, $session_uid);

    $user_friend = USER_FRIEND;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_ITEM.PIID, PROFILE_ITEM.NAME, ";
    $sql.= "PROFILE_ITEM.TYPE, PROFILE_ITEM.OPTIONS, USER_PROFILE.ENTRY, USER_PROFILE.PRIVACY ";
    $sql.= "FROM `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql.= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PROFILE` USER_PROFILE ";
    $sql.= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = '$uid' ";
    $sql.= "AND (USER_PROFILE.PRIVACY = 0 OR USER_PROFILE.UID = '$session_uid' ";
    $sql.= "OR (USER_PROFILE.PRIVACY = 1 AND ($peer_relationship & $user_friend > 0)))) ";
    $sql.= "WHERE USER_PROFILE.ENTRY IS NOT NULL ORDER BY PROFILE_SECTION.POSITION, ";
    $sql.= "PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    while (($user_profile_data = $result->fetch_assoc())) {

        if (strlen(trim($user_profile_data['ENTRY'])) > 0) {

            if (($user_profile_data['TYPE'] == PROFILE_ITEM_RADIO) || ($user_profile_data['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

                $profile_item_options_array = explode("\n", $user_profile_data['OPTIONS']);

                if (isset($profile_item_options_array[$user_profile_data['ENTRY']])) {
                    $user_profile_array[$user_profile_data['PSID']][$user_profile_data['PIID']] = $user_profile_data;
                }

            } else {

                $user_profile_array[$user_profile_data['PSID']][$user_profile_data['PIID']] = $user_profile_data;
            }
        }
    }

    return sizeof($user_profile_array) > 0 ? $user_profile_array : false;
}

function user_get_profile_image($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COALESCE(USER_PREFS_FORUM.PIC_URL, USER_PREFS_GLOBAL.PIC_URL) AS PIC_URL ";
    $sql.= "FROM USER LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ";
    $sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) WHERE USER.UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows == 0) return false;

    $user_profile_data = $result->fetch_assoc();

    if (!isset($user_profile_data['PIC_URL']) || strlen($user_profile_data['PIC_URL']) == 0) return false;
    
    return $user_profile_data['PIC_URL'];
}

function user_get_post_count($uid)
{
    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT POST_COUNT FROM `{$table_prefix}USER_TRACK` ";
    $sql.= "WHERE UID = '$uid' AND POST_COUNT IS NOT NULL";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows > 0) {

        list($post_count) = $result->fetch_row();
        return $post_count;
    }

    $sql = "INSERT IGNORE INTO `{$table_prefix}USER_TRACK` (UID, POST_COUNT) ";
    $sql.= "SELECT '$uid', COUNT(POST.PID) AS POST_COUNT FROM `{$table_prefix}POST` POST ";
    $sql.= "WHERE FROM_UID = '$uid' ON DUPLICATE KEY UPDATE POST_COUNT = VALUES(POST_COUNT)";

    if (!$result = $db->query($sql)) return false;

    return user_get_post_count($uid);
}

function user_profile_popup_callback($logon)
{
    $webtag = get_webtag();

    return "<a href=\"user_profile.php?webtag=$webtag&amp;logon=$logon\" class=\"popup 650x500\" target=\"_blank\">$logon</a>";
}

?>