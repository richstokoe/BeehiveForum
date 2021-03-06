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

require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'ip.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'profile.inc.php';
require_once BH_INCLUDE_PATH. 'search.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'sphinx.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'user_profile.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

function post_create($fid, $tid, $reply_pid, $fuid, $tuid, $content, $hide_ipaddress = false)
{
    if (!$db = db::get()) return -1;

    $post_content = $db->escape($content);

    $ipaddress = ($hide_ipaddress == false) ? get_ip_address() : '';

    if (!is_numeric($tid)) return -1;
    if (!is_numeric($reply_pid)) return -1;
    if (!is_numeric($fuid)) return -1;
    if (!is_numeric($tuid)) return -1;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!($table_prefix = get_table_prefix())) return -1;

    // Check that the post needs approval. If the user is a moderator their posts are self-approved.
    if (perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $fuid) && !perm_is_moderator($fuid, $fid)) {

        $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, FROM_UID, ";
        $sql.= "TO_UID, CREATED, APPROVED, IPADDRESS) VALUES ($tid, $reply_pid, $fuid, ";
        $sql.= "$tuid, CAST('$current_datetime' AS DATETIME), NULL, '$ipaddress')";

    } else {

        $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, FROM_UID, ";
        $sql.= "TO_UID, CREATED, APPROVED, APPROVED_BY, IPADDRESS) VALUES ($tid, $reply_pid, ";
        $sql.= "$fuid, $tuid, CAST('$current_datetime' AS DATETIME), ";
        $sql.= "CAST('$current_datetime' AS DATETIME), $fuid, '$ipaddress')";
    }

    if (!$db->query($sql)) return -1;

    $new_pid = $db->insert_id;

    $sql = "INSERT INTO `{$table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql.= "VALUES ('$tid', '$new_pid', '$post_content')";

    if (!$db->query($sql)) return -1;

    $sql = "INSERT INTO `{$table_prefix}POST_SEARCH_ID` (TID, PID) ";
    $sql.= "VALUES('$tid', '$new_pid')";

    if (!$db->query($sql)) return -1;

    post_update_thread_length($tid, $new_pid);

    user_increment_post_count($fuid);

    if (perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $fuid) && !perm_is_moderator($fuid, $fid)) {
        admin_send_post_approval_notification($fid);
    }

    return $new_pid;
}

function post_approve($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    $approve_uid = session::get_value('UID');

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` ";
    $sql.= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "APPROVED_BY = '$approve_uid' WHERE TID = '$tid' ";
    $sql.= "AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    return true;
}

function post_save_attachment_id($tid, $pid, $aid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_md5($aid)) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "INSERT INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql.= "VALUES ($forum_fid, $tid, $pid, '$aid') ON DUPLICATE KEY ";
    $sql.= "UPDATE AID = VALUES(AID)";

    if (!$db->query($sql)) return false;

    return true;
}

function post_create_thread($fid, $uid, $title, $poll = 'N', $sticky = 'N', $closed = false, $deleted = false)
{
    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $title = $db->escape($title);

    $poll = ($poll == 'Y') ? 'Y' : 'N';

    $sticky = ($sticky == 'Y') ? 'Y' : 'N';

    $closed = ($closed === true) ? sprintf("'%s'", date(MYSQL_DATETIME, time())) : 'NULL';

    $deleted = ($deleted === true) ? 'Y' : 'N';

    // Current datetime
    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "INSERT INTO `{$table_prefix}THREAD` (FID, BY_UID, TITLE, LENGTH, POLL_FLAG, ";
    $sql.= "STICKY, CREATED, MODIFIED, CLOSED, DELETED) VALUES ('$fid', '$uid', '$title', 0, '$poll', ";
    $sql.= "'$sticky', CAST('$current_datetime' AS DATETIME), CAST('$current_datetime' AS DATETIME), ";
    $sql.= "$closed, '$deleted')";

    if (!$db->query($sql)) return false;

    return $db->insert_id;
}

function post_update_thread_length($tid, $length)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($length)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET LENGTH = '$length', ";
    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid'";

    if (!$db->query($sql)) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) !== false) {

        $sql = "INSERT INTO `{$table_prefix}THREAD` (TID, UNREAD_PID) ";
        $sql.= "SELECT THREAD.TID, MAX(POST.PID) AS UNREAD_PID FROM `{$table_prefix}THREAD` THREAD ";
        $sql.= "LEFT JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
        $sql.= "WHERE POST.CREATED < CAST('$unread_cutoff_datetime' AS DATETIME) ";
        $sql.= "AND THREAD.TID = '$tid' GROUP BY THREAD.TID ";
        $sql.= "ON DUPLICATE KEY UPDATE UNREAD_PID = VALUES(UNREAD_PID)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function post_draw_to_dropdown($default_uid, $show_all = true)
{
    $class = defined('BEEHIVEMODE_LIGHT') ? 'select' : 'bhselect';

    $html = "<select name=\"t_to_uid\" class=\"$class\">";

    if (!$db = db::get()) return false;

    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $uid = session::get_value('UID');

    if (isset($default_uid) && $default_uid > 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql.= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "WHERE USER.UID = '$default_uid' ";

        if (!$result = $db->query($sql)) return false;

        if ($result->num_rows > 0) {

            if (($top_user = $result->fetch_assoc())) {

                if (isset($top_user['PEER_NICKNAME'])) {
                    if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                        $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                    }
                }

                $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']), true);
                $html.= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>";
            }
        }
    }

    if ($show_all) {
        $html .= "<option value=\"0\">". gettext("ALL"). "</option>";
    }

    $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID <> '$default_uid' ";
    $sql.= "AND VISITOR_LOG.UID > 0 ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    if (!$result = $db->query($sql)) return false;

    while (($user_data = $result->fetch_assoc())) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
            $html .= "<option value=\"{$user_data['UID']}\">$fmt_username</option>";
        }
    }

    $html.= "</select>";
    return $html;
}

function post_draw_to_dropdown_recent($default_uid)
{
    $class = defined('BEEHIVEMODE_LIGHT') ? 'select' : 'recent_user_dropdown';

    $html = "<select name=\"t_to_uid_recent\" class=\"$class\">";

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!($forum_fid = get_forum_fid())) return false;

    $uid = session::get_value('UID');

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql.= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "WHERE USER.UID = '$default_uid' ";

        if (!$result = $db->query($sql)) return false;

        if ($result->num_rows > 0) {

            if (($top_user = $result->fetch_assoc())) {

                if (isset($top_user['PEER_NICKNAME'])) {
                    if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                        $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                    }
                }

                $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']), true);
                $html.= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>";
            }
        }
    }

    $html .= "<option value=\"0\">". gettext("ALL"). "</option>";

    $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID <> '$default_uid' ";
    $sql.= "AND VISITOR_LOG.UID > 0 ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    if (!$result = $db->query($sql)) return false;

    while (($user_data = $result->fetch_assoc())) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
            $html .= "<option value=\"{$user_data['UID']}\">$fmt_username</option>";
        }
    }

    $html.= "</select>";
    return $html;
}

function post_draw_to_dropdown_in_thread($tid, $default_uid, $show_all = true, $inc_blank = false, $class = 'user_in_thread_dropdown', $custom_html = "")
{
    $html = "<select name=\"t_to_uid_in_thread\" class=\"$class\" $custom_html>";

    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!($table_prefix = get_table_prefix())) return "";

    $uid = session::get_value('UID');

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql.= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
        $sql.= "WHERE USER.UID = '$default_uid' ";

        if (!$result = $db->query($sql)) return false;

        if ($result->num_rows > 0) {

            if (($top_user = $result->fetch_assoc())) {

                if (isset($top_user['PEER_NICKNAME'])) {
                    if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                        $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                    }
                }

                $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']), true);
                $html.= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>";
            }
        }
    }

    if ($show_all) {

        $html.= "<option value=\"0\">". gettext("ALL"). "</option>";

    } else if ($inc_blank) {

        if (isset($default_uid) && $default_uid != 0) {
            $html.= "<option value=\"0\">&nbsp;</option>";
        } else {
            $html.= "<option value=\"0\" selected=\"selected\">&nbsp;</option>";
        }
    }

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME FROM `{$table_prefix}POST` POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = POST.FROM_UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE POST.TID = '$tid' AND POST.FROM_UID <> '$default_uid' ";
    $sql.= "GROUP BY POST.FROM_UID LIMIT 0, 20";

    if (!$result = $db->query($sql)) return false;

    while (($user_data = $result->fetch_assoc())) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
            $html .= "<option value=\"{$user_data['UID']}\">$fmt_username</option>";
        }
    }

    $html .= "</select>";
    return $html;
}

function post_check_ddkey($ddkey)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ddkey)) return false;

    $ddkey_datetime = date(MYSQL_DATETIME, $ddkey);

    if (($uid = session::get_value('UID')) === false) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT DDKEY FROM `{$table_prefix}USER_TRACK` ";
    $sql.= "WHERE UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows) {

        list($ddkey_datetime_check) = $result->fetch_row();

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
        $sql.= "SET DDKEY = CAST('$ddkey_datetime' AS DATETIME) WHERE UID = '$uid'";

        if (!$result = $db->query($sql)) return false;

    } else{

        $ddkey_datetime_check = '';

        $sql = "INSERT INTO `{$table_prefix}USER_TRACK` (UID, DDKEY) ";
        $sql.= "VALUES ('$uid', CAST('$ddkey_datetime' AS DATETIME))";

        if (!$result = $db->query($sql)) return false;
    }

    return !($ddkey_datetime == $ddkey_datetime_check);
}

function post_check_frequency()
{
    if (!$db = db::get()) return false;

    if (($uid = session::get_value('UID')) === false) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $minimum_post_frequency = intval(forum_get_setting('minimum_post_frequency', null, 0));

    if ($minimum_post_frequency == 0) return true;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "SELECT UNIX_TIMESTAMP(LAST_POST) + $minimum_post_frequency, ";
    $sql.= "UNIX_TIMESTAMP('$current_datetime') FROM `{$table_prefix}USER_TRACK` ";
    $sql.= "WHERE UID = '$uid'";

    if (!$result = $db->query($sql)) return false;

    if ($result->num_rows > 0) {

        list($last_post_stamp, $current_timestamp) = $result->fetch_row();

        if (!is_numeric($last_post_stamp) || $last_post_stamp < $current_timestamp) {

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
            $sql.= "SET LAST_POST = CAST('$current_datetime' AS DATETIME) ";
            $sql.= "WHERE UID = '$uid'";

            if (!$result = $db->query($sql)) return false;

            return true;
        }

    } else{

        $sql = "INSERT INTO `{$table_prefix}USER_TRACK` (UID, LAST_POST) ";
        $sql.= "VALUES ('$uid', CAST('$current_datetime' AS DATETIME))";

        if (!$result = $db->query($sql)) return false;

        return true;
    }

    return false;
}

function post_update($fid, $tid, $pid, $content)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    $content = $db->escape($content);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_CONTENT` SET CONTENT = '$content' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

    if (!$db->query($sql)) return false;

    if (session::check_perm(USER_PERM_POST_APPROVAL, $fid) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` SET APPROVED = 0, APPROVED_BY = 0 ";
        $sql.= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function post_add_edit_text($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    if (($edit_uid = session::get_value('UID')) === false) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` ";
    $sql.= "SET EDITED = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "EDITED_BY = '$edit_uid' WHERE TID = '$tid' AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    return true;
}

function post_delete($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    if (($approve_uid = session::get_value('UID')) === false) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    if (thread_is_poll($tid) && $pid == 1) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET POLL_FLAG = 'N', ";
        $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;
    }

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET DELETED = 'Y', ";
    $sql.= "MODIFIED = CAST('$current_datetime' AS DATETIME) WHERE TID = '$tid' AND LENGTH = 1";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_CONTENT` SET CONTENT = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` ";
    $sql.= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "APPROVED_BY = '$approve_uid' WHERE TID = '$tid' ";
    $sql.= "AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    return true;
}

function post_edit_refuse($tid, $pid)
{
    html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => "$tid.$pid"));
}

class MessageTextParse
{
    protected $message;

    protected $sig;

    protected $original;

    public function __construct($message)
    {
        $this->original = $message;

        $message_parts = preg_split('/(<[^<>]+>)/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

        $signature_parts = array();

        if (($signature_offset = array_search("<div class=\"sig\">", $message_parts)) !== false) {

            while (sizeof($message_parts) > 0) {

                $signature_parts = array_merge($signature_parts, array_splice($message_parts, $signature_offset, 1));
                if (count(explode('<div', implode('', $signature_parts))) == count(explode('</div>', implode('', $signature_parts)))) break;
            }
        }

        $signature = preg_replace('/^<div class="sig">(.*)<\/div>$/Dsu', '$1', implode('', $signature_parts));

        $message = implode('', $message_parts);

        $this->message = fix_html($message);

        $this->sig = fix_html($signature);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getSig()
    {
        return $this->sig;
    }

    public function getOriginal()
    {
        return $this->original;
    }
}

?>