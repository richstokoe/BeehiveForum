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

/* $Id: user.inc.php,v 1.114 2004-02-02 20:47:06 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/config.inc.php");
require_once("./include/format.inc.php");
require_once("./include/ip.inc.php");

function user_count()
{
   $db_user_count = db_connect();

   $sql = "SELECT COUNT(UID) AS COUNT FROM ". forum_table("USER"). " ";
   $sql.= "WHERE USER.LOGON <> 'GUEST' AND USER.PASSWD <> MD5('GUEST')";

   $result = db_query($sql, $db_user_count);

   $user_count = db_fetch_array($result);
   return $user_count['COUNT'];
}

function user_exists($logon)
{
    $db_user_exists = db_connect();

    $logon = addslashes($logon);

    $sql = "SELECT uid FROM " . forum_table("USER") . " WHERE logon = '$logon'";
    $result = db_query($sql, $db_user_exists);

    return (db_num_rows($result) > 0);
}

function user_create($logon, $password, $nickname, $email)
{
    global $HTTP_SERVER_VARS;

    $logon = addslashes($logon);
    $nickname = addslashes($nickname);
    $email = addslashes($email);
    $md5pass = md5($password);

    if (!$ipaddress = get_ip_address()) {
        $ipaddress = "";
    }

    $sql = "INSERT INTO " . forum_table("USER") . " (LOGON, PASSWD, NICKNAME, EMAIL, LAST_LOGON, LOGON_FROM) ";
    $sql .= "VALUES ('$logon', '$md5pass', '$nickname', '$email', NOW(), '$ipaddress')";

    $db_user_create = db_connect();
    $result = db_query($sql, $db_user_create);

    if ($result) {
        $new_uid = db_insert_id($db_user_create);
    }else {
        $new_uid = -1;
    }

    return $new_uid;
}

function user_update($uid, $nickname, $email)
{
    $db_user_update = db_connect();

    $nickname = addslashes(_htmlentities($nickname));
    $email = addslashes(_htmlentities($email));

    $sql = "UPDATE ". forum_table("USER"). " SET NICKNAME = '$nickname', ";
    $sql.= "EMAIL = '$email' WHERE UID = $uid";

    return db_query($sql, $db_user_update);
}

function user_change_pw($uid, $password, $hash = false)
{
    $db_user_change_pw = db_connect();
    $password = md5($password);

    $sql = "UPDATE ". forum_table("USER"). " SET PASSWD = '$password' WHERE UID = $uid ";

    if ($hash) {
        $hash = addslashes($hash);
        $sql.= "AND PASSWD = '$hash'";
    }

    $result = db_query($sql, $db_user_change_pw);
    return (db_affected_rows($db_user_change_pw) > 0);
}


function user_get_status($uid)
{
    if (!is_numeric($uid)) return 0;

    $sql = "SELECT STATUS FROM ". forum_table("USER") . " WHERE UID = $uid";
    $db_user_get_status = db_connect();

    $result = db_query($sql, $db_user_get_status);
    list($status) = db_fetch_array($result);

    return $status;

}

function user_update_status($uid, $status)
{
    $db_user_update_status = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "UPDATE " . forum_table("USER") . " SET STATUS = $status ";
    $sql.= "WHERE UID = $uid";

    $result = db_query($sql, $db_user_update_status);

    return $result;
}

function user_update_folders($uid, $folders)
{
    $db_user_update_folders = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_array($folders)) return false;

    $sql = "UPDATE ". forum_table("USER_FOLDER"). " SET ALLOWED = 0 ";
    $sql.= "WHERE UID = '$uid'";

    $result = db_query($sql, $db_user_update_folders);

    for ($i = 0; $i < sizeof($folders); $i++) {

        $sql = "SELECT ALLOWED FROM ". forum_table("USER_FOLDER"). " ";
        $sql.= "WHERE UID = $uid AND FID = {$folders[$i]['fid']}";

        $result = db_query($sql, $db_user_update_folders);

        if (db_num_rows($result)) {

            $sql = "UPDATE ". forum_table("USER_FOLDER"). " SET ALLOWED = {$folders[$i]['allowed']} ";
            $sql.= "WHERE UID = $uid AND FID = {$folders[$i]['fid']}";

        }else {

            $sql = "INSERT INTO ". forum_table("USER_FOLDER"). " (UID, FID, ALLOWED) ";
            $sql.= "VALUES ($uid, {$folders[$i]['fid']}, {$folders[$i]['allowed']})";
        }

        $result = db_query($sql, $db_user_update_folders);
    }
}

function user_logon($logon, $password, $md5hash = false)
{

    global $HTTP_SERVER_VARS;

    if ($md5hash) {
      $md5pass = addslashes($password);
    }else {
      $md5pass = md5($password);
    }

    $logon = addslashes($logon);

    $sql = "SELECT UID, STATUS FROM ". forum_table("USER"). " WHERE LOGON = '$logon' AND PASSWD = '$md5pass'";

    $db_user_logon = db_connect();
    $result = db_query($sql, $db_user_logon);

    if (!db_num_rows($result)) {
        $uid = -1;
    }else {

        $fa = db_fetch_array($result);
        $uid = $fa['UID'];

        if (isset($fa['STATUS']) && $fa['STATUS'] & USER_PERM_SPLAT) { // User is banned
            $uid = -2;
        }

        if (!$ipaddress = get_ip_address()) {
            $ipaddress = "";
        }

	$sql = "UPDATE ". forum_table("USER"). " SET LAST_LOGON = NOW(), ";
	$sql.= "LOGON_FROM = '$ipaddress' WHERE UID = '$uid'";

        db_query($sql, $db_user_logon);
    }

    return $uid;
}

function user_check_logon($uid, $logon, $md5pass)
{
    if (!is_numeric($uid)) return false;

    if ($uid > 0) {

        $logon = addslashes($logon);
        
        $db_user_check_logon = db_connect();

        $sql = "SELECT STATUS FROM ". forum_table("USER"). " WHERE UID = '$uid' AND LOGON = '$logon' AND PASSWD = '$md5pass'";
        $result = db_query($sql, $db_user_check_logon);

        if (db_num_rows($result)) {
            $user_status = db_fetch_array($result);
	    if (isset($user_status['STATUS']) && $user_status['STATUS'] & USER_PERM_SPLAT) {
                if (!strstr(php_sapi_name(), 'cgi')) {
                    header("HTTP/1.0 500 Internal Server Error");
                }else {
                    echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
                }
                exit;
	    }
	}else {
	    return false;
	}
     }

     return true;
}

function user_get($uid, $hash = false)
{
    $db_user_get = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "SELECT * FROM " . forum_table("USER") . " WHERE UID = $uid ";

    if ($hash) {
        $hash = addslashes($hash);
        $sql.= "AND PASSWD = '$hash'";
    }

    $result = db_query($sql, $db_user_get);

    if (db_num_rows($result)) {
        $user_get = db_fetch_array($result);
        return $user_get;
    }

    return false;
}

function user_get_logon($uid)
{
    $db_user_get_logon = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "select LOGON from " . forum_table("USER") . " where uid = $uid";

    $result = db_query($sql, $db_user_get_logon);

    if(!db_num_rows($result)){
        $logon = "UNKNOWN";
    } else {
        $fa = db_fetch_array($result);
        $logon = $fa['LOGON'];
    }

    return $logon;
}

function user_get_uid($logon)
{
    $db_user_get_uid = db_connect();

    $logon = addslashes($logon);

    $sql = "SELECT UID, LOGON, NICKNAME FROM ". forum_table("USER"). " WHERE LOGON = '$logon'";
    $result = db_query($sql, $db_user_get_uid);

    if (!db_num_rows($result)) {
        return false;
    }else{
        return db_fetch_array($result);
    }

}

function user_get_sig($uid, &$content, &$html)
{
    $db_user_get_sig = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "SELECT CONTENT, HTML FROM " . forum_table("USER_SIG") . " WHERE UID = $uid";
    $result = db_query($sql, $db_user_get_sig);

    if(!db_num_rows($result)){
        $ret = false;
    } else {
        $fa = db_fetch_array($result);
        $content = $fa['CONTENT'];
        $html = $fa['HTML'];
        $ret = true;
    }

    return $ret;
}

function user_get_prefs($uid)
{
    $db_user_get_prefs = db_connect();

    if (!is_numeric($uid)) return false;

    $sql = "SELECT * FROM ". forum_table("USER_PREFS"). " WHERE UID = $uid";
    $result = db_query($sql, $db_user_get_prefs);

    if (!db_num_rows($result)) {
        $fa = array('UID' => '', 'FIRSTNAME' => '', 'LASTNAME' => '', 'DOB' => '', 'HOMEPAGE_URL' => '',
                    'PIC_URL' => '', 'EMAIL_NOTIFY' => '', 'TIMEZONE' => '', 'DL_SAVING' => '',
                    'MARK_AS_OF_INT' => '', 'POSTS_PER_PAGE' => '', 'FONT_SIZE' => '',
                    'STYLE' => '', 'VIEW_SIGS' => '', 'START_PAGE' => '', 'LANGUAGE' => '',
                    'PM_NOTIFY' => '', 'PM_NOTIFY_EMAIL' => '', 'DOB_DISPLAY' => '', 'ANON_LOGON' => '',
                    'SHOW_STATS' => '');
    }else {
        $fa = db_fetch_array($result);
    }

    return $fa;
}

function user_update_prefs($uid, $prefs_array)
{
    global $default_style;

    if (!is_numeric($uid)) return false;
    if (!is_array($prefs_array)) return false;

    $db_user_update_prefs = db_connect();
    
    // Get the current prefs and merge them with the new ones.   

    $prefs_array = array_merge(user_get_prefs($uid), $prefs_array);    
    
    // Now delete the old preferences
    
    $sql = "DELETE FROM ". forum_table("USER_PREFS"). " WHERE UID = $uid";
    $result = db_query($sql, $db_user_update_prefs);
    
    if (empty($prefs_array['TIMEZONE']))       $prefs_array['TIMEZONE']       = 0;   
    if (empty($prefs_array['POSTS_PER_PAGE'])) $prefs_array['POSTS_PER_PAGE'] = 5;
    if (empty($prefs_array['FONT_SIZE']))      $prefs_array['FONT_SIZE']      = 10;
    
    if (!ereg("([[:alnum:]]+)", $prefs_array['STYLE'])) $prefs_array['STYLE'] = $default_style;

    $sql = "INSERT INTO " . forum_table("USER_PREFS") . " (UID, FIRSTNAME, LASTNAME, DOB, HOMEPAGE_URL, ";
    $sql.= "PIC_URL, EMAIL_NOTIFY, TIMEZONE, DL_SAVING, MARK_AS_OF_INT, POSTS_PER_PAGE, FONT_SIZE, STYLE, ";
    $sql.= "VIEW_SIGS, START_PAGE, LANGUAGE, PM_NOTIFY, PM_NOTIFY_EMAIL, DOB_DISPLAY, ANON_LOGON, SHOW_STATS) ";
    $sql.= "VALUES ($uid, '{$prefs_array['FIRSTNAME']}', '{$prefs_array['LASTNAME']}', '{$prefs_array['DOB']}', ";
    $sql.= "'{$prefs_array['HOMEPAGE_URL']}', '{$prefs_array['PIC_URL']}', '{$prefs_array['EMAIL_NOTIFY']}', ";
    $sql.= "'{$prefs_array['TIMEZONE']}', '{$prefs_array['DL_SAVING']}', '{$prefs_array['MARK_AS_OF_INT']}', ";
    $sql.= "'{$prefs_array['POSTS_PER_PAGE']}', '{$prefs_array['FONT_SIZE']}', '{$prefs_array['STYLE']}', ";
    $sql.= "'{$prefs_array['VIEW_SIGS']}', '{$prefs_array['START_PAGE']}', '{$prefs_array['LANGUAGE']}', ";
    $sql.= "'{$prefs_array['PM_NOTIFY']}', '{$prefs_array['PM_NOTIFY_EMAIL']}', '{$prefs_array['DOB_DISPLAY']}', ";
    $sql.= "'{$prefs_array['ANON_LOGON']}', '{$prefs_array['SHOW_STATS']}')";
    
    $result = db_query($sql, $db_user_update_prefs);

    return $result;
}

function user_update_sig($uid, $content, $html)
{
    if (!is_numeric($uid)) return false;

    $content = addslashes($content);
    $db_user_update_sig = db_connect();

    $sql = "delete from ". forum_table("USER_SIG"). " where UID = $uid";
    $result = db_query($sql, $db_user_update_sig);

    $sql = "insert into " . forum_table("USER_SIG") . " (UID, CONTENT, HTML)";
    $sql .= " values ($uid, '$content', '$html')";

    $result = db_query($sql, $db_user_update_sig);

    return $result;
}

function user_update_global_sig($uid, $value)
{
    if (!is_numeric($uid)) return false;

    $db_user_update_global_sig = db_connect();

    $sql = "update " . forum_table("USER_PREFS") . " set ";
    $sql .= "VIEW_SIGS = '$value' where UID = $uid";

    $result = db_query($sql, $db_user_update_global_sig);

    return $result;
}

function user_get_global_sig($uid)
{
    if (!is_numeric($uid)) return false;

    $db_user_update_global_sig = db_connect();

    $sql = "select VIEW_SIGS from " . forum_table("USER_PREFS") . " where uid = $uid";

    $result = db_query($sql, $db_user_update_global_sig);

    if (db_num_rows($result)) {
        $fa = db_fetch_array($result);
        return $fa['VIEW_SIGS'];
    }

    return "";
}

function user_get_post_count($uid)
{
    if (!is_numeric($uid)) return 0;

    $db_user_get_count = db_connect();

    $sql = "select COUNT(FROM_UID) AS COUNT FROM " . forum_table("POST") . " where FROM_UID = $uid";
    $result = db_query($sql, $db_user_get_count);

    $post_count = db_fetch_array($result);

    return $post_count['COUNT'];
}

function user_get_last_logon_time($uid, $verbose = true)
{
    global $lang;
    
    if (!is_numeric($uid)) return false;

    $db_user_get_last_logon_time = db_connect();

    $sql = "SELECT USER_PREFS.ANON_LOGON, UNIX_TIMESTAMP(USER.LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM ". forum_table("USER"). " USER ";
    $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "WHERE USER.UID = $uid";    
    
    $result = db_query($sql, $db_user_get_last_logon_time);

    $last_logon = db_fetch_array($result);
    
    if (isset($last_logon['ANON_LOGON']) && $last_logon['ANON_LOGON'] <> 0) {
    
        return $lang['unknown'];

    }else {

        return format_time($last_logon['LAST_LOGON'], $verbose);
    }
}

function user_guest_enabled()
{
    $db_user_guest_account = db_connect();

    $sql = "SELECT UID, STATUS FROM ". forum_table("USER"). " WHERE LOGON = 'GUEST' AND PASSWD = MD5('guest')";
    $result = db_query($sql, $db_user_guest_account);

    if (db_num_rows($result)) {
        $fa = db_fetch_array($result);
        if ($fa['STATUS'] & USER_PERM_SPLAT) {
            return false;
        }else {
            return true;
        }
    }

    return false;
}

function user_get_dob($uid)
{
    if (!is_numeric($uid)) return false;

    $prefs = user_get_prefs($uid);

    if (isset($prefs['DOB_DISPLAY']) && $prefs['DOB_DISPLAY'] == 2 && !empty($prefs['DOB']) && $prefs['DOB'] != "0000-00-00") {
        return format_birthday($prefs['DOB']);
    } else {
        return false;
    }
}

function user_get_age($uid)
{
    if (!is_numeric($uid)) return false;

    $prefs = user_get_prefs($uid);

    if (isset($prefs['DOB_DISPLAY']) && $prefs['DOB_DISPLAY'] > 0 && !empty($prefs['DOB']) && $prefs['DOB'] != "0000-00-00") {
        return format_age($prefs['DOB']);
    }else {
        return false;
    }
}

function user_get_forthcoming_birthdays()
{
    $db_user_get_forthcoming_birthdays = db_connect();

    $sql  = "SELECT U.UID, U.LOGON, U.NICKNAME, UP.DOB, MOD(DAYOFYEAR(UP.DOB) - DAYOFYEAR(NOW()) ";
    $sql .= "+ 365, 365) AS DAYS_TO_BIRTHDAY ";
    $sql .= "FROM " . forum_table("USER"). " U, ". forum_table("USER_PREFS") . " UP ";
    $sql .= "WHERE U.UID = UP.UID AND UP.DOB > 0 AND UP.DOB_DISPLAY = 2 ";
    $sql .= "AND MOD(DAYOFYEAR(UP.DOB) - DAYOFYEAR(NOW())+ 365, 365) > 0 "; 
    $sql .= "ORDER BY DAYS_TO_BIRTHDAY ASC ";
    $sql .= "LIMIT 0, 5";

    $result = db_query($sql, $db_user_get_forthcoming_birthdays);

    if (db_num_rows($result)) {
        $birthdays = array();
        while ($row = db_fetch_array($result)) {
            $birthdays[] = $row;
        }
	return $birthdays;
    }else {
        return false;
    }
}

function user_search($usersearch, $sort_by = "LAST_LOGON", $sort_dir = "DESC", $offset = 0)
{
    $db_user_search = db_connect();

    $sort_array = array('UID', 'LOGON', 'STATUS', 'LAST_LOGON', 'LOGON_FROM');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'ADMIN_LOG.LOG_TIME';

    $usersearch = addslashes($usersearch);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(USER.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER.LOGON_FROM, USER.STATUS FROM " . forum_table("USER") . " USER ";
    $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "WHERE (LOGON LIKE '$usersearch%' OR NICKNAME LIKE '$usersearch%') ";
    $sql.= "AND NOT (USER_PREFS.ANON_LOGON <=> 1) ";
    $sql.= "ORDER BY USER.$sort_by $sort_dir ";
    $sql.= "LIMIT $offset, 20";

    $result = db_query($sql, $db_user_search);

    if (db_num_rows($result)) {
        $user_search_array = array();
	while ($row = db_fetch_array($result)) {
	    $user_search_array[] = $row;
	}
	return $user_search_array;
    }else {
        return false;
    }
}

function user_get_all($sort_by = "LAST_LOGON", $sort_dir = "ASC", $offset = 0)
{
    $db_user_get_all = db_connect();
    $user_get_all_array = array();

    $sort_array = array('UID', 'LOGON', 'STATUS', 'LAST_LOGON', 'LOGON_FROM');

    if (!is_numeric($offset)) $offset = 0;
    if ((trim($sort_dir) != 'DESC') && (trim($sort_dir) != 'ASC')) $sort_dir = 'DESC';
    if (!in_array($sort_by, $sort_array)) $sort_by = 'ADMIN_LOG.LOG_TIME';

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(USER.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "USER.LOGON_FROM, USER.STATUS FROM ". forum_table("USER"). " USER ";
    $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "WHERE NOT (USER_PREFS.ANON_LOGON <=> 1) ";
    $sql.= "ORDER BY USER.$sort_by $sort_dir LIMIT $offset, 20";

    $result = db_query($sql, $db_user_get_all);

    while($row = db_fetch_array($result)) {
       $user_get_all_array[] = $row;
    }

    return $user_get_all_array;
}

function user_get_aliases($uid)
{
    $db_user_get_aliases = db_connect();

    if (!is_numeric($uid)) return false;
    
    // Get the user's last known logon IP
    
    $sql = "SELECT LOGON_FROM FROM ". forum_table("USER"). " WHERE UID = '$uid'";
    $result = db_query($sql, $db_user_get_aliases);
    
    $user_get_aliases_row = db_fetch_array($result);
    
    if (isset($user_get_aliases_row['LOGON_FROM']) && strlen($user_get_aliases_row['LOGON_FROM']) > 0) {
       $user_ip_address_array = array();
       $user_ip_address_array[] = $user_get_aliases_row['LOGON_FROM'];
    }    

    $sql = "SELECT IPADDRESS  FROM ". forum_table("POST"). " WHERE FROM_UID = '$uid'";
    $result = db_query($sql, $db_user_get_aliases);
    
    if (db_num_rows($result)) {
        if (!is_array($user_ip_address_array)) $user_ip_address_array = array();
        while($user_get_aliases_row = db_fetch_array($result)) {
            if (!in_array($user_get_aliases_row['IPADDRESS'], $user_ip_address_array)) {
                $user_ip_address_array[] = $user_get_aliases_row['IPADDRESS'];
            }
        }
    }
    
    $user_ip_address_list = implode("', '", $user_ip_address_array);
    
    if (substr($user_ip_address_list, -4) == "', '") {
        $user_ip_address_list = substr($user_ip_address_list, 0, -4);
    }
    
    // Search the post table for any matches
    
    $sql = "SELECT DISTINCT USER.UID, USER.LOGON, POST.IPADDRESS FROM ". forum_table("USER"). " ";
    $sql.= "LEFT JOIN ". forum_table("POST"). " POST ON (POST.FROM_UID = USER.UID) ";
    $sql.= "WHERE (POST.IPADDRESS IN ('$user_ip_address_list') AND POST.FROM_UID <> '$uid') ";
    $sql.= "OR (USER.LAST_LOGON IN ('$user_ip_address_list') AND USER.UID <> '$uid')";

    $result = db_query($sql, $db_user_get_aliases);
    
    if (db_num_rows($result)) {
        $user_get_aliases_array = array();
        while($user_get_aliases_row = db_fetch_array($result)) {
            $user_get_aliases_array[] = $user_get_aliases_row;
        }
        return $user_get_aliases_array;
    }
    
    return false;
}

function users_get_recent()
{
    $db_users_get_recent = db_connect();

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, UNIX_TIMESTAMP(USER.LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM ". forum_table("USER"). " USER ";
    $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
    $sql.= "WHERE NOT (USER_PREFS.ANON_LOGON <=> 1)";
    $sql.= "ORDER BY USER.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 10";

    $result = db_query($sql, $db_users_get_recent);

    if (db_num_rows($result)) {
        $users_get_recent_array = array();
	while ($row = db_fetch_array($result)) {
	    $users_get_recent_array[] = $row;
	}
	return $users_get_recent_array;
    }else {
        return false;
    }
}

?>