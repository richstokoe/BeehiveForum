<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: folder.inc.php,v 1.120 2007-04-17 23:36:51 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function folder_draw_dropdown($default_fid, $field_name="t_fid", $suffix="", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $custom_html = "", $class="bhselect")
{
    $db_folder_draw_dropdown = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return "";

    $forum_fid = $table_data['FID'];

    if (!is_numeric($allowed_types)) return "";

    $available_folders = array();

    $access_allowed = USER_PERM_THREAD_CREATE;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "WHERE FOLDER.ALLOWED_TYPES & $allowed_types > 0 ";
    $sql.= "OR FOLDER.ALLOWED_TYPES IS NULL ";
    $sql.= "ORDER BY FOLDER.FID ";

    $result = db_query($sql, $db_folder_draw_dropdown);

    if (db_num_rows($result) > 0) {

        while($folder_order = db_fetch_array($result)) {

            if (user_is_guest()) {

                if (bh_session_check_perm(USER_PERM_GUEST_ACCESS, $folder_order['FID'])) {

                    $available_folders[$folder_order['FID']] = $folder_order['TITLE'];
                }

            }else {
            
                if (bh_session_check_perm($access_allowed, $folder_order['FID'])) {

                    $available_folders[$folder_order['FID']] = $folder_order['TITLE'];
                }
            }
        }

        if (sizeof($available_folders) > 0) {

            return form_dropdown_array($field_name.$suffix, $available_folders, $default_fid, $custom_html, $class);
        }
    }

    return false;
}

function folder_draw_dropdown_all($default_fid, $field_name="t_fid", $suffix="", $custom_html = "", $class="bhselect")
{
    $db_folder_draw_dropdown = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$table_data = get_table_prefix()) return "";

    $forum_fid = $table_data['FID'];

    $available_folders = array();

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";

    $result = db_query($sql, $db_folder_draw_dropdown);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            $available_folders[$row['FID']] = $row['TITLE'];
        }

        if (sizeof($available_folders) > 0) {

            return form_dropdown_array($field_name.$suffix, $available_folders, $default_fid, $custom_html, $class);
        }
    }

    return false;
}

function folder_get_title($fid)
{
    $db_folder_get_title = db_connect();

    if (!is_numeric($fid)) return "The Unknown Folder";

    if (!$table_data = get_table_prefix()) return "The Unknown Folder";

    $sql = "SELECT TITLE FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_get_title);

    if (db_num_rows($result) > 0) {

        list($folder_title) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder_title;
    }

    return "The Unknown Folder";
}

function folder_get_prefix($fid)
{
    $db_folder_get_title = db_connect();

    if (!is_numeric($fid)) return "";

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT PREFIX FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_get_title);

    if (db_num_rows($result) > 0) {

        list($folder_prefix) = db_fetch_array($result, DB_RESULT_NUM);
        return $folder_prefix;
    }

    return "";
}

function folder_create($title, $description = "", $prefix = "", $allowed_types = FOLDER_ALLOW_ALL_THREAD, $permissions = 0)
{
    $db_folder_create = db_connect();

    $title = addslashes(_htmlentities($title));
    $description = addslashes(_htmlentities($description));
    $prefix = addslashes(_htmlentities($prefix));

    $new_pos = 0;

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;
    if (!is_numeric($permissions)) $permissions = 0;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT MAX(POSITION) + 1 AS NEW_POS FROM {$table_data['PREFIX']}FOLDER";
    $result = db_query($sql, $db_folder_create);

    if ($row = db_fetch_array($result)) {
        $new_pos = $row['NEW_POS'];
    }

    $sql = "INSERT INTO {$table_data['PREFIX']}FOLDER (TITLE, DESCRIPTION, PREFIX, ALLOWED_TYPES, POSITION) ";
    $sql.= "VALUES ('$title', '$description', '$prefix', '$allowed_types', '$new_pos')";

    $result = db_query($sql, $db_folder_create);

    $new_fid = db_insert_id($db_folder_create);

    $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
    $sql.= "VALUES ('0', '$forum_fid', '$new_fid', '$permissions')";

    return db_query($sql, $db_folder_create);
}

function folder_delete($fid)
{
    $db_folder_delete = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_delete);

    return $result;
}

function folder_update($fid, $folder_order)
{
    $db_folder_update = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_array($folder_order)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $folder_order = array_merge(folder_get($fid), $folder_order);

    foreach($folder_order as $key => $value) {

        if (!is_numeric($value)) {

            $folder_order[$key] = addslashes(_htmlentities($value));
        }
    }

    if (!isset($folder_order['TITLE'])) return false;
    if (!isset($folder_order['DESCRIPTION'])) $folder_order['DESCRIPTION'] = '';
    if (!isset($folder_order['PREFIX'])) $folder_order['PREFIX'] = '';

    if (!isset($folder_order['POSITION']) || !is_numeric($folder_order['POSITION'])) $folder_order['POSITION'] = 0;
    if (!isset($folder_order['ALLOWED_TYPES']) || !is_numeric($folder_order['ALLOWED_TYPES'])) $folder_order['ALLOWED_TYPES'] = 3;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}FOLDER SET TITLE = '{$folder_order['TITLE']}', ";
    $sql.= "DESCRIPTION = '{$folder_order['DESCRIPTION']}', ALLOWED_TYPES = '{$folder_order['ALLOWED_TYPES']}', ";
    $sql.= "POSITION = '{$folder_order['POSITION']}', PREFIX = '{$folder_order['PREFIX']}' WHERE FID = $fid";

    $result = db_query($sql, $db_folder_update);

    $sql = "DELETE FROM GROUP_PERMS WHERE FID = '$fid' ";
    $sql.= "AND FORUM = '$forum_fid' AND GID = '0'";

    $result = db_query($sql, $db_folder_update);

    $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
    $sql.= "VALUES ('0', '$forum_fid', '$fid', '{$folder_order['PERM']}')";

    $result = db_query($sql, $db_folder_update);

    return true;
}

function folder_move_threads($from, $to)
{
    $db_folder_move_threads = db_connect();

    if (!is_numeric($from)) return false;
    if (!is_numeric($to)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}THREAD SET FID = '$to' WHERE FID = '$from'";
    $result = db_query($sql, $db_folder_move_threads);

    return $result;
}

function folder_get_available()
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS)) {
            return implode(',', $folder_list);
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ)) {
            return implode(',', $folder_list);
        }
    }

    return '0';
}

function folder_get_available_by_forum($forum_fid)
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid)) {
            return implode(',', $folder_list);
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ, $forum_fid)) {
            return implode(',', $folder_list);
        }
    }

    return '0';
}

function folder_get_available_array()
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS)) {
            return $folder_list;
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ)) {
            return $folder_list;
        }
    }

    return '0';
}

function folder_get_available_array_by_forum($forum_fid)
{
    if (user_is_guest()) {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_GUEST_ACCESS, $forum_fid)) {
            return $folder_list;
        }

    }else {

        if ($folder_list = bh_session_get_folders_by_perm(USER_PERM_POST_READ, $forum_fid)) {
            return $folder_list;
        }
    }

    return '0';
}

function folder_get_all()
{
    $db_folder_get_all = db_connect();

    if (!$table_data = get_table_prefix()) return array();

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, FOLDER.PREFIX, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.POSITION";

    $result = db_query($sql, $db_folder_get_all);

    if (db_num_rows($result) > 0) {

        $folder_list = array();

        while ($row = db_fetch_array($result)) {
            $folder_list[$row['FID']] = $row;
        }

        return $folder_list;
    }

    return false;
}

function folder_get_all_by_page($offset)
{
    $db_folder_get_all_by_page = db_connect();

    if (!is_numeric($offset)) return false;

    if (!$table_data = get_table_prefix()) return array();

    $forum_fid = $table_data['FID'];

    $folder_array = array();

    $sql = "SELECT COUNT(FID) FROM {$table_data['PREFIX']}FOLDER ";
    $result = db_query($sql, $db_folder_get_all_by_page);

    list($folder_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, ";
    $sql.= "FOLDER.ALLOWED_TYPES, FOLDER.POSITION, FOLDER.PREFIX, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.POSITION ";
    $sql.= "LIMIT $offset, 10";

    $result = db_query($sql, $db_folder_get_all_by_page);

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {

            $folder_array[$row['FID']] = $row;
        }
    
    }else if ($folder_count > 0) {

        $offset = ceil($folder_count / 10);
        return folder_get_all_by_page($offset);
    }

    return array('folder_array' => $folder_array,
                 'folder_count' => $folder_count);
}

function folder_get_thread_count($fid)
{
    $db_folder_get_thread_count = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE FID = $fid";

    $result = db_query($sql, $db_folder_get_thread_count);
    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $thread_count;
}

function folder_get($fid)
{
    $db_folder_get = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, FOLDER.DESCRIPTION, FOLDER.POSITION, ";
    $sql.= "FOLDER.PREFIX, FOLDER.ALLOWED_TYPES, GROUP_PERMS.PERM, ";
    $sql.= "COUNT(THREAD.FID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = 0 AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID, FOLDER.TITLE";

    $result = db_query($sql, $db_folder_get);

    if (db_num_rows($result) > 0) {
        return db_fetch_array($result);
    }else {
        return false;
    }
}

// Checks that a $fid is a valid folder (i.e. it actually exists)

function folder_is_valid($fid)
{
    $db_folder_get_available = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($fid)) return false;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid' LIMIT 0, 1";
    $result = db_query($sql, $db_folder_get_available);

    return (db_num_rows($result) > 0);
}

function folder_is_accessible($fid)
{
    if (!is_numeric($fid)) return false;

    $access_allowed = USER_PERM_POST_READ;
    return bh_session_check_perm($access_allowed, $fid);
}

function user_set_folder_interest($fid, $interest)
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $db_user_set_folder_interest = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($interest)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_FOLDER ";
    $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    $result = db_query($sql, $db_user_set_folder_interest);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE {$table_data['PREFIX']}USER_FOLDER SET INTEREST = '$interest' ";
        $sql.= "WHERE UID = '$uid' AND FID = '$fid'";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_FOLDER (UID, FID, INTEREST) ";
        $sql.= "VALUES ('$uid', '$fid', '$interest')";
    }

    return db_query($sql, $db_user_set_folder_interest);
}

function folder_thread_type_allowed($fid, $type) // for types see constants.inc.php
{
    $db_folder_thread_type_allowed = db_connect();

    if (!is_numeric($fid)) return false;
    if (!is_numeric($type)) $type = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ALLOWED_TYPES FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_folder_thread_type_allowed);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (!isset($row['ALLOWED_TYPES']) || is_null($row['ALLOWED_TYPES'])) return true;

        return $row['ALLOWED_TYPES'] ? ($row['ALLOWED_TYPES'] & $type) : true;
    }

    return false;
}

// Similar to folder_draw_dropdown() but simply returns
// a list of folders or false on none, rather than draw
// the drop down.

function folder_get_by_type_allowed($allowed_types = FOLDER_ALLOW_ALL_THREAD)
{
    $db_folder_get_by_type_allowed = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!is_numeric($allowed_types)) $allowed_types = FOLDER_ALLOW_ALL_THREAD;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT DISTINCT FOLDER.FID FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "WHERE (FOLDER.ALLOWED_TYPES & $allowed_types > 0 OR FOLDER.ALLOWED_TYPES IS NULL)";

    $result = db_query($sql, $db_folder_get_by_type_allowed);

    if (db_num_rows($result) > 0) {

        $allowed_folders = array();

        while($row = db_fetch_array($result)) {
            $allowed_folders[] = $row['FID'];
        }

        return $allowed_folders;

    }else {

        return false;
    }
}

function folder_move_up($fid)
{
    $db_folder_move_up = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    folder_positions_update();

    $sql = "SELECT FID, POSITION FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_folder_move_up);

    while ($row = db_fetch_array($result)) {

        $folder_order[] = $row['FID'];
        $folder_position[$row['FID']] = $row['POSITION'];
    }

    // Search for our folder in the list of know folders.

    if (($folder_order_key = array_search($fid, $folder_order)) !== false) {

        // Move the folder above to the same location as our selected folder.
        
        $folder_order_key--;
        if ($folder_order_key < 0) $folder_order_key = 0;

        $new_position = $folder_position[$fid];

        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '{$folder_order[$folder_order_key]}'";

        if (!$result = db_query($sql, $db_folder_move_up)) return false;

        // Move the selected folder to the old location of the other folder.

        $new_position = $folder_position[$folder_order[$folder_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '$fid'";

        if (!$result = db_query($sql, $db_folder_move_up)) return false;

        return true;
    }

    return false;
}

function folder_move_down($fid)
{
    $db_folder_move_down = db_connect();

    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    folder_positions_update();

    $sql = "SELECT FID, POSITION FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_folder_move_down);

    while ($row = db_fetch_array($result)) {

        $folder_order[] = $row['FID'];
        $folder_position[$row['FID']] = $row['POSITION'];
    }

    if (($folder_order_key = array_search($fid, $folder_order)) !== false) {

        $folder_order_key++;

        if ($folder_order_key > sizeof($folder_order)) {
            $folder_order_key = sizeof($folder_order);
        }        

        $new_position = $folder_position[$fid];
        
        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '{$folder_order[$folder_order_key]}'";

        if (!$result = db_query($sql, $db_folder_move_down)) return false;

        $new_position = $folder_position[$folder_order[$folder_order_key]];

        $sql = "UPDATE {$table_data['PREFIX']}FOLDER SET POSITION = '$new_position' ";
        $sql.= "WHERE FID = '$fid'";

        if (!$result = db_query($sql, $db_folder_move_down)) return false;

        return true;
    }

    return false;
}

function folder_positions_update()
{
    $new_position = 0;

    $db_folder_positions_update = db_connect();

    if (!$table_data = get_table_prefix()) return;

    $sql = "SELECT FID FROM {$table_data['PREFIX']}FOLDER ";
    $sql.= "ORDER BY POSITION";

    $result = db_query($sql, $db_folder_positions_update);

    while (list($fid) = db_fetch_array($result, DB_RESULT_NUM)) {

        if (isset($fid) && is_numeric($fid)) {

            $new_position++;
        
            $sql = "UPDATE {$table_data['PREFIX']}FOLDER ";
            $sql.= "SET POSITION = '$new_position' WHERE FID = '$fid'";

            $result_update = db_query($sql, $db_folder_positions_update);
        }
    }
}    

?>