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

/* $Id: perm.inc.php,v 1.57 2005-03-06 23:36:41 decoyduck Exp $ */

function perm_is_moderator($fid = 0)
{
    static $user_status = false;
    static $folder_fid = false;

    if (!$folder_fid || !$user_status || $folder_fid != $fid) {

        $db_perm_is_moderator = db_connect();

        if (!$table_data = get_table_prefix()) return 0;

        $forum_fid = $table_data['FID'];

        $uid = bh_session_get_value('UID');

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = $uid AND GROUP_PERMS.FID = '$fid' ";
        $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "ORDER BY GROUP_PERMS.PERM DESC";

        $result = db_query($sql, $db_perm_is_moderator);

        $row = db_fetch_array($result);

        $folder_fid = $fid;
        $user_status = $row['STATUS'];
    }

    if (($user_status & USER_PERM_FOLDER_MODERATE) > 0) return true;
    if (($user_status & USER_PERM_ADMIN_TOOLS) > 0)     return true;
    if (($user_status & USER_PERM_FORUM_TOOLS) > 0)     return true;

    return false;
}

function perm_has_admin_access($uid = false)
{
    static $user_uid = false;
    static $user_status = false;

    if ($uid === false) $uid = bh_session_get_value('UID');

    if (!$user_uid || !$user_status || $user_uid != $uid) {

        $db_perm_has_admin_access = db_connect();

        if (!$table_data = get_table_prefix()) return 0;

        $forum_fid = $table_data['FID'];

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
        $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "ORDER BY GROUP_PERMS.GID DESC";

        $result = db_query($sql, $db_perm_has_admin_access);

        $row = db_fetch_array($result);

        $user_uid = $uid;
        $user_status = $row['STATUS'];
    }

    return ($user_status & USER_PERM_ADMIN_TOOLS) > 0;
}

function perm_has_forumtools_access($uid = false)
{
    static $user_uid = false;
    static $user_status = false;

    if ($uid === false) $uid = bh_session_get_value('UID');

    if (!$user_uid || !$user_status || $user_uid != $uid) {

        $db_perm_has_forumtools_access = db_connect();

        if (!$table_data = get_table_prefix()) return 0;

        $forum_fid = $table_data['FID'];

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
        $sql.= "AND GROUP_PERMS.FORUM IN (0) ";
        $sql.= "ORDER BY GROUP_PERMS.GID DESC";

        $result = db_query($sql, $db_perm_has_forumtools_access);

        $row = db_fetch_array($result);

        $user_uid = $uid;
        $user_status = $row['STATUS'];
    }

    return ($user_status & USER_PERM_FORUM_TOOLS) > 0;
}

function perm_is_links_moderator($uid = false)
{
    static $user_uid = false;
    static $user_status = false;

    if ($uid === false) $uid = bh_session_get_value('UID');

    if (!$user_uid || !$user_status || $user_uid != $uid) {

        $db_perm_has_forumtools_access = db_connect();

        if (!$table_data = get_table_prefix()) return 0;

        $forum_fid = $table_data['FID'];

        $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID IN (0) ";
        $sql.= "AND GROUP_PERMS.FORUM IN (0) ";
        $sql.= "ORDER BY GROUP_PERMS.GID DESC";

        $result = db_query($sql, $db_perm_has_forumtools_access);

        $row = db_fetch_array($result);

        $user_uid = $uid;
        $user_status = $row['STATUS'];
    }

    return ($user_status & USER_PERM_LINKS_MODERATE) > 0;
}

function perm_check_folder_permissions($fid, $access_level)
{
    static $user_status = false;
    static $folder_fid = false;

    if (!$folder_fid || !$user_status || $folder_fid != $fid) {

        $db_perm_check_folder_permissions = db_connect();

        if (!is_numeric($fid)) return false;
        if (!is_numeric($access_level)) return false;

        if (!$table_data = get_table_prefix()) return false;

        $forum_fid = $table_data['FID'];

        $uid = bh_session_get_value('UID');

        $sql = "SELECT FOLDER.FID, BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
        $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
        $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
        $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
        $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = '$uid') ";
        $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
        $sql.= "AND GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
        $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
        $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
        $sql.= "WHERE FOLDER.FID = '$fid' GROUP BY FOLDER.FID ";

        $result = db_query($sql, $db_perm_check_folder_permissions);

        $row = db_fetch_array($result);

        if ($row['USER_PERM_COUNT'] > 0) {

            $folder_fid = $fid;
            $user_status = $row['USER_STATUS'];

        }elseif ($row['FOLDER_PERM_COUNT'] > 0) {

            $folder_fid = $fid;
            $user_status = $row['FOLDER_PERMS'];
        }
    }

    return ($user_status & $access_level) == $access_level;
}

function perm_get_user_groups()
{
    $db_perm_get_user_groups = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT GROUPS.*, COUNT(GROUP_USERS.UID) AS USER_COUNT ";
    $sql.= "FROM GROUPS GROUPS LEFT JOIN GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 AND GROUPS.FORUM = '$forum_fid' ";
    $sql.= "GROUP BY GROUPS.GID";

    $result = db_query($sql, $db_perm_get_user_groups);

    if (db_num_rows($result) > 0) {

        $user_groups_array = array();

        while ($row = db_fetch_array($result)) {

            $user_groups_array[] = $row;
        }

        return $user_groups_array;
    }

    return false;
}

function perm_user_get_groups($uid)
{
    $db_perm_user_get_groups = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT GROUPS.*, COUNT(GROUP_USER_COUNT.UID) AS USER_COUNT FROM GROUPS GROUPS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USER_COUNT ON (GROUP_USER_COUNT.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 0 AND GROUPS.FORUM = $forum_fid AND GROUP_USERS.UID = '$uid'";
    $sql.= "GROUP BY GROUPS.GID";

    $result = db_query($sql, $db_perm_user_get_groups);

    if (db_num_rows($result) > 0) {

        $user_groups_array = array();

        while ($row = db_fetch_array($result)) {

            $user_groups_array[] = $row;
        }

        return $user_groups_array;
    }

    return false;
}

function perm_add_group($group_name, $group_desc, $perm)
{
    $db_perm_add_group = db_connect();

    if (!is_numeric($perm)) return false;

    $group_name = addslashes(_htmlentities($group_name));
    $group_desc = addslashes(_htmlentities($group_desc));

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO GROUPS (FID, GROUP_NAME, GROUP_DESC, AUTO_GROUP) ";
    $sql.= "VALUES ($fid, '$group_name', '$group_desc', 0)";

    if ($result = db_query($sql, $db_perm_add_group)) {

        $new_gid = db_insert_id($db_perm_add_group);

        if ($perm > 0) {

            $sql = "INSERT INTO GROUP_PERMS (GID, FID, PERM) ";
            $sql.= "VALUES ('$new_gid', '0', '$perm')";

            $result = db_query($sql, $db_perm_add_group);
        }

        return $new_gid;
    }

    return false;
}

function perm_update_group($gid, $group_name, $group_desc, $perm)
{
    $db_perm_update_group = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    $group_name = addslashes(_htmlentities($group_name));
    $group_desc = addslashes(_htmlentities($group_desc));

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "UPDATE GROUPS SET GROUP_NAME = '$group_name', ";
        $sql.= "GROUP_DESC = '$group_desc' WHERE GID = '$gid'";

        $result = db_query($sql, $db_perm_update_group);

        $sql = "UPDATE GROUP_PERMS SET PERM = '$perm' ";
        $sql.= "WHERE GID = '$gid' AND FID = '0'";

        return db_query($sql, $db_perm_update_group);
    }

    return false;
}

function perm_remove_group($gid)
{
    $db_perm_remove_group = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM GROUP_USERS WHERE GID = '$gid'";
    $result = db_query($sql, $db_perm_remove_group);

    if (db_num_rows($result) < 1) {

        $sql = "DELETE FROM GROUPS WHERE GID = $gid";
        return db_query($sql, $db_perm_remove_group);
    }

    return false;
}

function perm_get_group($gid)
{
    $db_perm_get_group = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM GROUPS WHERE GID = '$gid' AND AUTO_GROUP = 0";
    $result = db_query($sql, $db_perm_get_group);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return $row;
    }

    return false;
}

function perm_is_group($gid)
{
    $db_perm_is_group = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM GROUPS WHERE GID = '$gid' AND AUTO_GROUP = 0";
    $result = db_query($sql, $db_perm_is_group);

    return (db_num_rows($result) > 0);
}

function perm_user_in_group($uid, $gid)
{
    $db_perm_user_in_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT * FROM GROUP_USERS ";
    $sql.= "WHERE UID = '$uid' AND GID = '$gid'";

    $result = db_query($sql, $db_perm_user_in_group);

    return (db_num_rows($result) > 0);
}

function perm_get_global_permissions()
{
    $db_perm_get_global_permissions = db_connect();

    $user_search_array = array();
    $user_search_count = 0;

    if (!$table_data = get_table_prefix()) return array('user_count' => 0,
                                                        'user_array' => array());

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "GROUPS.GID, GROUP_PERMS.PERM FROM GROUPS ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "LEFT JOIN USER ON (USER.UID = GROUP_USERS.UID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM = 0 AND (GROUP_PERMS.PERM & 1024 > 0 ";
    $sql.= "OR GROUP_PERMS.PERM & 512 > 0) ";

    $result = db_query($sql, $db_perm_get_global_permissions);

    while($row = db_fetch_array($result)) {

        if (!isset($user_search_array[$row['UID']])) {

            $user_search_array[$row['UID']] = $row;
        }
    }

    return array('user_count' => sizeof($user_search_array),
                 'user_array' => $user_search_array);
}

function perm_update_global_perms($uid, $perm)
{
    $db_perm_update_global_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if ($gid = perm_get_user_gid($uid)) {

        $sql = "UPDATE GROUP_PERMS SET PERM = '$perm' WHERE GID = '$gid'";
        $result = db_query($sql, $db_perm_update_global_perms);
    }
}

function perm_remove_global_perms($uid)
{
    $db_perm_remove_global_perms = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if ($gid = perm_get_user_gid($uid)) {

        $sql = "DELETE FROM GROUP_PERMS WHERE GID = '$gid'";
        $result = db_query($sql, $db_perm_remove_global_perms);
    }
}

function perm_add_global_perms($uid, $perm)
{
    $db_perm_add_global_perms = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if ($gid = perm_get_user_gid($uid)) {

        $sql = "SELECT PERM FROM GROUP_PERMS WHERE GID = '$gid'";
        $result = db_query($sql, $db_perm_add_global_perms);

        list($old_perm) = db_fetch_array($result, DB_RESULT_NUM);
        $perm = ((double) $old_perm | (double) $perm);

        $sql = "UPDATE GROUP_PERMS SET PERM = '$perm' WHERE GID = '$gid'";
        $result = db_query($sql, $db_perm_add_global_perms);

    }else {

        $sql = "INSERT INTO GROUPS (FORUM, AUTO_GROUP) VALUES (0, 1)";

        if ($result = db_query($sql, $db_perm_add_global_perms)) {

            $new_gid = db_insert_id($db_perm_add_global_perms);

            $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
            $sql.= "VALUES ('$new_gid', '0', '0', '$perm')";

            $result = db_query($sql, $db_perm_add_global_perms);

            $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
            $sql.= "VALUES ('$new_gid', '$uid')";

            $result = db_query($sql, $db_perm_add_global_perms);

            return $new_gid;
        }
    }
}

function perm_get_group_permissions($gid)
{
    $db_perm_get_group_permissions = db_connect();

    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "SELECT PERM FROM GROUP_PERMS WHERE GID = '$gid' AND FID = 0 ";
        $sql.= "AND FORUM = '$forum_fid'";

        $result = db_query($sql, $db_perm_get_group_permissions);

        if (db_num_rows($result) > 0) {

            $row = db_fetch_array($result);
            return $row['PERM'];
        }

        return 0;
    }

    return false;
}

function perm_get_group_folder_perms($gid, $fid)
{
    $db_perm_get_group_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "SELECT GROUP_PERMS.GID, BIT_OR(GROUP_PERMS.PERM) AS GROUP_PERMS, ";
        $sql.= "COUNT(GROUP_PERMS.PERM) AS GROUP_PERM_COUNT, ";
        $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
        $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
        $sql.= "FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS  ON (FOLDER_PERMS.GID = '$gid' ";
        $sql.= "AND FOLDER_PERMS.FID = '$fid' AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
        $sql.= "WHERE GROUP_PERMS.GID = '$gid' AND GROUP_PERMS.FID = '$fid' ";
        $sql.= "GROUP BY GROUP_PERMS.GID ";

        $result = db_query($sql, $db_perm_get_group_folder_perms);

        $row = db_fetch_array($result);

        if ($row['GROUP_PERM_COUNT'] > 0) {

            return array('STATUS' => $row['GROUP_PERMS']);

        }elseif ($row['FOLDER_PERM_COUNT'] > 0) {

            return array('STATUS' => $row['FOLDER_PERMS']);
        }
    }

    return false;
}

function perm_add_user_to_group($uid, $gid)
{
    $db_perm_add_user_to_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (perm_is_group($gid)) {

        $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$gid', '$uid')";

        return db_query($sql, $db_perm_add_user_to_group);
    }

    return false;
}

function perm_remove_user_from_group($uid, $gid)
{
    $db_perm_remove_user_from_group = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;

    if (!$table_data = get_table_prefix()) return false;

     if (perm_is_group($gid)) {

        $sql = "DELETE FROM GROUP_USERS ";
        $sql.= "WHERE GID = '$gid' AND UID = '$uid'";

        return db_query($sql, $db_perm_remove_user_from_group);
    }

    return false;
}

function perm_get_user_permissions($uid)
{
    $db_perm_get_user_permissions = db_connect();

    if (!is_numeric($uid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT BIT_OR(GROUP_PERMS.PERM) AS STATUS ";
    $sql.= "FROM GROUP_PERMS GROUP_PERMS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ";
    $sql.= "ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FID = 0 ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid)";

    $result = db_query($sql, $db_perm_get_user_permissions);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return $row['STATUS'];
    }

    return 0;
}

function perm_get_user_gid($uid)
{
    $db_perm_get_user_gid = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT GROUPS.GID FROM GROUPS GROUPS ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) ";
    $sql.= "WHERE GROUPS.AUTO_GROUP = 1 AND GROUPS.FORUM = $forum_fid ";
    $sql.= "AND GROUP_USERS.UID = '$uid'";

    $result = db_query($sql, $db_perm_get_user_gid);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);
        return $row['GID'];
    }

    return false;
}

function perm_get_user_folder_perms($uid, $fid)
{
    $db_perm_get_user_folder_perms = db_connect();

    if (!is_numeric($uid)) return 0;
    if (!is_numeric($fid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FOLDER.FID, BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = '$uid') ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "WHERE FOLDER.FID = '$fid' ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.FID";

    $result = db_query($sql, $db_perm_get_user_folder_perms);

    $row = db_fetch_array($result);

    if ($row['USER_PERM_COUNT'] > 0) {

        return array('STATUS' => $row['USER_STATUS']);

    }elseif ($row['FOLDER_PERM_COUNT'] > 0) {

        return array('STATUS' => $row['FOLDER_PERMS']);
    }

    return false;
}

function perm_add_user_folder_perms($uid, $gid, $fid, $perm)
{
    $db_perm_add_user_folder_perms = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!perm_is_group($gid) && perm_user_in_group($uid, $gid)) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '$fid', '$perm')";

        return db_query($sql, $db_perm_add_user_folder_perms);
    }

    return false;
}

function perm_update_user_folder_perms($uid, $gid, $fid, $perm)
{
    $db_perm_update_user_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!perm_is_group($gid) && perm_user_in_group($uid, $gid)) {

        $sql = "DELETE FROM GROUP_PERMS WHERE GID = '$gid' ";
        $sql.= "AND FID = '$fid' AND FORUM = '$forum_fid'";

        $result = db_query($sql, $db_perm_update_user_folder_perms);

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '$fid', '$perm')";

        return db_query($sql, $db_perm_update_user_folder_perms);
    }

    return false;
}

function perm_add_group_folder_perms($gid, $fid, $perm)
{
    $db_perm_add_group_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "INSERT INTO GROUP_PERMS (GID, FORUM_FID, FID, PERM) ";
        $sql.= "VALUES ('$gid', '$forum_fid', '$fid', '$perm')";

        return db_query($sql, $db_perm_add_group_folder_perms);
    }

    return false;
}

function perm_update_group_folder_perms($gid, $fid, $perm)
{
    $db_perm_update_group_folder_perms = db_connect();

    if (!is_numeric($gid)) return false;
    if (!is_numeric($fid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (perm_is_group($gid)) {

        $sql = "UPDATE GROUP_PERMS SET PERM = '$perm' ";
        $sql.= "WHERE GID = '$gid' AND FID = '$fid' ";
        $sql.= "AND FORUM = '$forum_fid'";

        return db_query($sql, $db_perm_update_group_folder_perms);
    }

    return false;
}

function perm_add_user_permissions($uid, $perm)
{
    $db_perm_add_user_permissions = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "INSERT INTO GROUPS (FORUM, AUTO_GROUP) VALUES ($forum_fid, 1)";

    if ($result = db_query($sql, $db_perm_add_user_permissions)) {

        $new_gid = db_insert_id($db_perm_add_user_permissions);

        $sql = "INSERT INTO GROUP_PERMS (GID, FID, PERM) ";
        $sql.= "VALUES ('$new_gid', '0', '$perm')";

        $result = db_query($sql, $db_perm_add_user_permissions);

        $sql = "INSERT INTO GROUP_USERS (GID, UID) ";
        $sql.= "VALUES ('$new_gid', '$uid')";

        $result = db_query($sql, $db_perm_add_user_permissions);

        return $new_gid;
    }

    return false;
}

function perm_update_user_permissions($uid, $gid, $perm)
{
    $db_perm_update_user_permissions = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($gid)) return false;
    if (!is_numeric($perm)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!perm_is_group($gid) && perm_user_in_group($uid, $gid)) {

        $sql = "UPDATE GROUP_PERMS SET PERM = '$perm' ";
        $sql.= "WHERE GID = '$gid' AND FID = '0' ";
        $sql.= "AND FORUM = '$forum_fid'";

        return db_query($sql, $db_perm_update_user_permissions);
    }

    return false;
}

function perm_folder_get_permissions($fid)
{
    $db_perm_folder_get_permissions = db_connect();

    if (!is_numeric($fid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT PERM AS STATUS FROM {$table_data['PREFIX']}FOLDER WHERE FID = '$fid'";
    $result = db_query($sql, $db_perm_folder_get_permissions);

    if (db_num_rows($result) > 0) {

        $row = db_fetch_array($result);

        if (!is_null($row['STATUS'])) return $row['STATUS'];
    }

    return false;
}

function perm_group_get_users($gid, $offset = 0)
{
    $db_perm_group_get_users = db_connect();

    if (!is_numeric($gid)) return 0;
    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return array('user_count' => 0,
                                                        'user_array' => array());;

    if (perm_is_group($gid)) {

        $group_user_array = array();
        $group_user_count = 0;

        $sql = "SELECT COUNT(UID) AS USER_COUNT ";
        $sql.= "FROM GROUP_USERS WHERE GID = '$gid'";

        $result = db_query($sql, $db_perm_group_get_users);
        list($group_user_count) = db_fetch_array($result, DB_RESULT_NUM);

        $sql = "SELECT GROUP_USERS.UID, USER.LOGON, USER.NICKNAME ";
        $sql.= "FROM GROUP_USERS GROUP_USERS ";
        $sql.= "LEFT JOIN USER USER ON (USER.UID = GROUP_USERS.UID) ";
        $sql.= "WHERE GROUP_USERS.GID = '$gid' ";
        $sql.= "LIMIT $offset, 20";

        $result = db_query($sql, $db_perm_group_get_users);

        if (db_num_rows($result) > 0) {
            while ($row = db_fetch_array($result)) {
                $group_user_array[] = $row;
            }
        }

        return array('user_count' => $group_user_count,
                     'user_array' => $group_user_array);
    }

    return false;
}

function perm_display_list($perms)
{
    $perms_array = array();

    if ($perms & USER_PERM_BANNED)           $perms_array[] = "B";
    if ($perms & USER_PERM_WORMED)           $perms_array[] = "W";
    if ($perms & USER_PERM_POST_READ)        $perms_array[] = "R";
    if ($perms & USER_PERM_POST_CREATE)      $perms_array[] = "W";
    if ($perms & USER_PERM_THREAD_CREATE)    $perms_array[] = "T";
    if ($perms & USER_PERM_POST_EDIT)        $perms_array[] = "E";
    if ($perms & USER_PERM_POST_DELETE)      $perms_array[] = "D";
    if ($perms & USER_PERM_POST_ATTACHMENTS) $perms_array[] = "A";
    if ($perms & USER_PERM_FOLDER_MODERATE)  $perms_array[] = "M";
    if ($perms & USER_PERM_ADMIN_TOOLS)      $perms_array[] = "A";
    if ($perms & USER_PERM_FORUM_TOOLS)      $perms_array[] = "F";
    if ($perms & USER_PERM_HTML_POSTING)     $perms_array[] = "H";
    if ($perms & USER_PERM_SIGNATURE)        $perms_array[] = "S";
    if ($perms & USER_PERM_GUEST_ACCESS)     $perms_array[] = "G";

    if (sizeof($perms_array) > 0) {

        echo implode("", $perms_array);

    }else {

        echo "[none]";
    }
}

?>