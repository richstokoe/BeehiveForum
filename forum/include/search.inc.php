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

/* $Id: search.inc.php,v 1.114 2005-03-24 18:55:33 decoyduck Exp $ */

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function search_execute($argarray, &$urlquery, &$error)
{
    // Check the last time the user performed a search

    if (!check_search_frequency()) {

        $error = SEARCH_FREQUENCY_TOO_GREAT;
        return false;
    }

    // MySQL has a list of stop words for fulltext searches.
    // We'll save ourselves some server time by checking
    // them first.

    include("./include/search_stopwords.inc.php");

    if (!$table_data = get_table_prefix()) return false;

    // Ensure the bare minimum of variables are set

    if (!isset($argarray['method']) || !is_numeric($argarray['method'])) $argarray['method'] = 1;
    if (!isset($argarray['date_from']) || !is_numeric($argarray['date_from'])) $argarray['date_from'] = 7;
    if (!isset($argarray['date_to']) || !is_numeric($argarray['date_to'])) $argarray['date_to'] = 2;
    if (!isset($argarray['order_by']) || !is_numeric($argarray['order_by'])) $argarray['order_by'] = 1;
    if (!isset($argarray['group_by_thread']) || !is_numeric($argarray['group_by_thread'])) $argarray['group_by_thread'] = "N";
    if (!isset($argarray['sstart']) || !is_numeric($argarray['sstart'])) $argarray['sstart'] = 0;
    if (!isset($argarray['fid']) || !is_numeric($argarray['fid'])) $argarray['fid'] = 0;
    if (!isset($argarray['include']) || !is_numeric($argarray['include'])) $argarray['include'] = 2;
    if (!isset($argarray['username']) || strlen(trim($argarray['username'])) < 1) $argarray['username'] = "";
    if (!isset($argarray['user_include']) || !is_numeric($argarray['user_include'])) $argarray['user_include'] = 1;
    if (!isset($argarray['forums']) || !is_numeric($argarray['forums'])) $argarray['forums'] = $table_data['FID'];

    $search_min_word_length = intval(forum_get_setting('search_min_word_length', false, 3));

    $db_search_execute = db_connect();

    $uid = bh_session_get_value('UID');

    $forum_settings = forum_get_settings();

    if ($argarray['forums'] == 0 && $forum_fids = forum_get_all_fids()) {
        $argarray['forums'] = implode(",", $forum_fids);
    }

    // Base query - the same for all seraches

    $select_sql = "SELECT SEARCH_POSTS.FID, SEARCH_POSTS.TID, SEARCH_POSTS.PID, ";
    $select_sql.= "SEARCH_POSTS.BY_UID, SEARCH_POSTS.FROM_UID, SEARCH_POSTS.TO_UID, ";
    $select_sql.= "UNIX_TIMESTAMP(SEARCH_POSTS.CREATED) AS CREATED ";
    $select_sql.= "FROM SEARCH_POSTS SEARCH_POSTS ";

    // Joins that we need for the search. Only join the keywords table
    // if we're doing a keyword search. Searching by user can be done
    // with just the SEARCH_POSTS table.

    $join_sql = "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $join_sql.= "ON (USER_PEER.PEER_UID = SEARCH_POSTS.BY_UID AND USER_PEER.UID = '$uid') ";

    // Where query base - used for all searches.
    // Modified depending on the joins by the code
    // below.

    $where_sql = "WHERE SEARCH_POSTS.FORUM IN ({$argarray['forums']}) ";
    $where_sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED_COMPLETELY. ") = 0 ";
    $where_sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";
    $where_sql.= "AND ((USER_PEER.RELATIONSHIP & ". USER_IGNORED. ") = 0 ";
    $where_sql.= "OR USER_PEER.RELATIONSHIP IS NULL) ";

    $folders = folder_get_available();

    if (isset($argarray['fid']) && in_array($argarray['fid'], explode(",", $folders))) {
        $where_sql.= "AND SEARCH_POSTS.FID = {$argarray['fid']} ";
    }else{
        $where_sql.= "AND SEARCH_POSTS.FID IN ($folders) ";
    }

    $where_sql.= search_date_range($argarray['date_from'], $argarray['date_to']);

    if (isset($argarray['username']) && strlen(trim($argarray['username'])) > 0) {

        if ($user_uid = user_get_uid($argarray['username'])) {

            if ($argarray['user_include'] == 1) {

                $where_sql.= "AND SEARCH_POSTS.FROM_UID = '{$user_uid['UID']}' ";

            }elseif ($argarray['user_include'] == 2) {

                $where_sql.= "AND SEARCH_POSTS.TO_UID = '{$user_uid['UID']}' ";

            }else {

                $where_sql.= "AND (SEARCH_POSTS.FROM_UID = '{$user_uid['UID']}' ";
                $where_sql.= "OR SEARCH_POSTS.TO_UID = '{$user_uid['UID']}') ";
            }

        }else {

            $error = SEARCH_USER_NOT_FOUND;
            return false;
        }
    }

    if (strlen(trim($argarray['search_string'])) > 0) {

        // Filter the input so the user can't do anything dangerous with it

        $argarray['search_string'] = str_replace("%", "", $argarray['search_string']);
        $argarray['search_string'] = _htmlentities($argarray['search_string']);

        // Remove any keywords which are under the minimum length.

        $keywords_array = explode(' ', trim($argarray['search_string']));

        foreach ($keywords_array as $key => $value) {

            if (strlen($value) < $search_min_word_length || strlen($value) > 64 || _in_array($value, $mysql_fulltext_stopwords)) {
                unset($keywords_array[$key]);
            }else {
                $keywords_array[$key] = strtolower($value);
            }
        }

        if (sizeof($keywords_array) > 0) {

            $join_sql.= "LEFT JOIN SEARCH_MATCH SEARCH_MATCH ";
            $join_sql.= "ON (SEARCH_MATCH.TID = SEARCH_POSTS.TID AND SEARCH_MATCH.PID = SEARCH_POSTS.PID) ";
            $join_sql.= "LEFT JOIN SEARCH_KEYWORDS SEARCH_KEYWORDS ";
            $join_sql.= "ON (SEARCH_KEYWORDS.WID = SEARCH_MATCH.WID) ";

            if ($argarray['method'] == 1) { // AND

                $where_sql.= "AND SEARCH_KEYWORDS.WORD = '";
                $where_sql.= implode("' AND SEARCH_KEYWORDS.WORD = '", $keywords_array);
                $where_sql.= "' ";

            }elseif ($argarray['method'] == 2) { // OR

                $where_sql.= "AND SEARCH_KEYWORDS.WORD = '";
                $where_sql.= implode("' OR SEARCH_KEYWORDS.WORD = '", $keywords_array);
                $where_sql.= "' ";
            }

        }elseif (!isset($argarray['username']) || strlen(trim($argarray['username'])) < 1) {

            $error = SEARCH_NO_KEYWORDS;
            return false;
        }

    }else {

        if (!isset($argarray['username']) || strlen(trim($argarray['username'])) < 1) {

            $error = SEARCH_NO_KEYWORDS;
            return false;
        }
    }

    if (isset($argarray['group_by_thread']) && $argarray['group_by_thread'] == 'Y') {
        $group_sql = "GROUP BY SEARCH_POSTS.TID ";
    }else {
        $group_sql = "";
    }

    if ($argarray['order_by'] == 1) {
        $order_sql = "ORDER BY SEARCH_POSTS.CREATED DESC ";
    }elseif($argarray['order_by'] == 2) {
        $order_sql = "ORDER BY SEARCH_POSTS.CREATED ";
    }

    $limit_sql = "LIMIT {$argarray['sstart']}, 20";

    $sql = preg_replace("/ +/", " ", "$select_sql $join_sql $where_sql $group_sql $order_sql");
    $result = db_query($sql, $db_search_execute);

    $uriquery = "";

    foreach($argarray as $key => $value) {
        $uriquery.= "&amp;$key=$value";
    }

    if (db_num_rows($result) > 0) {

        $search_results_array = array();

        while ($row = db_fetch_array($result)) {

            $search_results_array[] = $row;
        }

        return $search_results_array;

    }else {

        $error = SEARCH_NO_MATCHES;
        return false;
    }
}

function search_date_range($from, $to)
{
    $year  = date('Y', gmmktime());
    $month = date('n', gmmktime());
    $day   = date('j', gmmktime());

    $range = "";

    switch($from) {

      case 1:  // Today

        $from_timestamp = gmmktime(0, 0, 0, $month, $day, $year);
        break;

      case 2:  // Yesterday

        $from_timestamp = gmmktime(0, 0, 0, $month, $day - 1, $year);
        break;

      case 3:  // Day before yesterday

        $from_timestamp = gmmktime(0, 0, 0, $month, $day - 2, $year);
        break;

      case 4:  // 1 week ago

        $from_timestamp = gmmktime(0, 0, 0, $month, $day - 7, $year);
        break;

      case 5:  // 2 weeks ago

        $from_timestamp = gmmktime(0, 0, 0, $month, $day - 14, $year);
        break;

      case 6:  // 3 weeks ago

        $from_timestamp = gmmktime(0, 0, 0, $month, $day - 21, $year);
        break;

      case 7:  // 1 month ago

        $from_timestamp = gmmktime(0, 0, 0, $month - 1, $day, $year);
        break;

      case 8:  // 2 months ago

        $from_timestamp = gmmktime(0, 0, 0, $month - 2, $day, $year);
        break;

      case 9:  // 3 months ago

        $from_timestamp = gmmktime(0, 0, 0, $month - 3, $day, $year);
        break;

      case 10: // 6 months ago

        $from_timestamp = gmmktime(0, 0, 0, $month - 6, $day, $year);
        break;

      case 11: // 1 year ago

        $from_timestamp = gmmktime(0, 0, 0, $month, $day, $year - 1);
        break;

    }

    switch($to) {

      case 1:  // Now

        $to_timestamp = gmmktime();
        break;

      case 2:  // Today

        $to_timestamp = gmmktime(23, 59, 59, $month, $day, $year);
        break;

      case 3:  // Yesterday

        $to_timestamp = gmmktime(23, 59, 59, $month, $day - 1, $year);
        break;

      case 4:  // Day before yesterday

        $to_timestamp = gmmktime(23, 59, 59, $month, $day - 2, $year);
        break;

      case 5:  // 1 week ago

        $to_timestamp = gmmktime(23, 59, 59, $month, $day - 7, $year);
        break;

      case 6:  // 2 weeks ago

        $to_timestamp = gmmktime(23, 59, 59, $month, $day - 14, $year);
        break;

      case 7:  // 3 weeks ago

        $to_timestamp = gmmktime(23, 59, 59, $month, $day - 21, $year);
        break;

      case 8:  // 1 month ago

        $to_timestamp = gmmktime(23, 59, 59, $month - 1, $day, $year);
        break;

      case 9:  // 2 months ago

        $to_timestamp = gmmktime(23, 59, 59, $month - 2, $day, $year);
        break;

      case 10: // 3 months ago

        $to_timestamp = gmmktime(23, 59, 59, $month - 3, $day, $year);
        break;

      case 11: // 6 months ago

        $to_timestamp = gmmktime(23, 59, 59, $month - 6, $day, $year);
        break;

      case 12: // 1 year ago

        $to_timestamp = gmmktime(23, 59, 59, $month, $day, $year - 1);
        break;

    }

    if (isset($from_timestamp)) $range = "AND SEARCH_POSTS.CREATED >= FROM_UNIXTIME($from_timestamp) ";
    if (isset($to_timestamp)) $range.= "AND SEARCH_POSTS.CREATED <= FROM_UNIXTIME($to_timestamp) ";

    return $range;
}

function forum_search_dropdown()
{
    $lang = load_language_file();

    $db_forum_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT FORUMS.FID, FORUM_SETTINGS.SVALUE FROM FORUMS FORUMS ";
    $sql.= "LEFT JOIN FORUM_SETTINGS FORUM_SETTINGS ON (FORUM_SETTINGS.FID = FORUMS.FID ";
    $sql.= "AND FORUM_SETTINGS.SNAME = 'forum_name') ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.FID = FORUMS.FID) ";
    $sql.= "WHERE FORUMS.ACCESS_LEVEL = 0 OR FORUMS.ACCESS_LEVEL = 2 ";
    $sql.= "OR (FORUMS.ACCESS_LEVEL = 1 AND USER_FORUM.ALLOWED = 1) ";

    $result = db_query($sql, $db_forum_search_dropdown);

    if (db_num_rows($result) > 0) {

        $forums_array[0] = $lang['all_caps'];

        while($row = db_fetch_array($result)) {

            $forums_array[$row['FID']] = $row['SVALUE'];
        }

        return form_dropdown_array("forums", array_keys($forums_array), array_values($forums_array), $forum_fid, false, "search_dropdown");
    }

    return false;
}

function folder_search_dropdown()
{
    $lang = load_language_file();

    $db_folder_search_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $folders['FIDS'] = array();
    $folders['TITLES'] = array();

    $access_allowed = USER_PERM_POST_READ;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS USER_STATUS, ";
    $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
    $sql.= "BIT_OR(FOLDER_PERMS.PERM) AS FOLDER_PERMS, ";
    $sql.= "COUNT(FOLDER_PERMS.PERM) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = '$uid') ";
    $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.FID = FOLDER.FID ";
    $sql.= "AND GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "LEFT JOIN GROUP_PERMS FOLDER_PERMS ON (FOLDER_PERMS.FID = FOLDER.FID ";
    $sql.= "AND FOLDER_PERMS.GID = 0 AND FOLDER_PERMS.FORUM IN (0, $forum_fid)) ";
    $sql.= "GROUP BY FOLDER.FID ";
    $sql.= "ORDER BY FOLDER.FID";

    $result = db_query($sql, $db_folder_search_dropdown);

    if (db_num_rows($result) > 0) {

        while($row = db_fetch_array($result)) {

            if (($row['FOLDER_PERMS'] & USER_PERM_GUEST_ACCESS) > 0 || !user_is_guest()) {

                if ($row['USER_PERM_COUNT'] > 0 && ($row['USER_STATUS'] & $access_allowed) > 0) {

                    $folders['FIDS'][] = $row['FID'];
                    $folders['TITLES'][] = $row['TITLE'];

                }elseif ($row['FOLDER_PERM_COUNT'] > 0 && ($row['FOLDER_PERMS'] & $access_allowed) > 0) {

                    $folders['FIDS'][] = $row['FID'];
                    $folders['TITLES'][] = $row['TITLE'];

                }elseif ($row['FOLDER_PERM_COUNT'] == 0 && $row['USER_PERM_COUNT'] == 0) {

                    $folders['FIDS'][] = $row['FID'];
                    $folders['TITLES'][] = $row['TITLE'];
                }
            }
        }

        if (sizeof($folders['FIDS']) > 0 && sizeof($folders['TITLES']) > 0) {

            array_unshift($folders['FIDS'], 0);
            array_unshift($folders['TITLES'], $lang['all_caps']);

            return form_dropdown_array("fid", $folders['FIDS'], $folders['TITLES'], 0, false, "search_dropdown");
        }
    }

    return false;
}

function search_draw_user_dropdown($name)
{
    $lang = load_language_file();

    $db_search_draw_user_dropdown = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return "";

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}VISITOR_LOG VISITOR_LOG ON ";
    $sql.= "(USER.UID = VISITOR_LOG.UID) WHERE USER.UID <> '$uid' ";
    $sql.= "ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql.= "LIMIT 0, 20";

    $result = db_query($sql, $db_search_draw_user_dropdown);

    $uids[]  = 0;
    $names[] = $lang['all_caps'];

    if ($uid > 0) {

        $uids[]  = $uid;
        $names[] = $lang['me_caps'];
    }

    while($row = db_fetch_array($result)) {

      $uids[]  = $row['UID'];
      $names[] = format_user_name($row['LOGON'], $row['NICKNAME']);

    }

    return form_dropdown_array($name, $uids, $names, 0, false, "search_dropdown");
}

function check_search_frequency()
{
    $db_check_search_frequency = db_connect();

    $uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $search_stamp = time() - intval(forum_get_setting('search_min_frequency', false, 30));

    $sql = "SELECT UNIX_TIMESTAMP(LAST_SEARCH) FROM USER_TRACK WHERE UID = '$uid'";
    $result = db_query($sql, $db_check_search_frequency);

    if (db_num_rows($result) > 0) {

        list($last_search_check) = db_fetch_array($result);

        if ($last_search_check < $search_stamp) {

            $sql = "UPDATE USER_TRACK SET LAST_SEARCH = NOW() WHERE UID = '$uid'";
            $result = db_query($sql, $db_check_search_frequency);

            return true;
        }

    }else{

        $sql = "INSERT INTO USER_TRACK (UID, LAST_SEARCH) ";
        $sql.= "VALUES ('$uid', NOW())";

        $result = db_query($sql, $db_check_search_frequency);

        return true;
    }

    return false;
}

function search_index_old_post()
{
    $db_search_index_old_post = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT THREAD.FID, POST.TID, POST.PID, THREAD.BY_UID, POST.FROM_UID, ";
    $sql.= "POST.TO_UID, POST_CONTENT.CONTENT, UNIX_TIMESTAMP(POST.CREATED) AS CREATED ";
    $sql.= "FROM {$table_data['PREFIX']}POST_CONTENT POST_CONTENT ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ";
    $sql.= "ON (POST.TID = POST_CONTENT.TID AND POST.PID = POST_CONTENT.PID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.TID = POST_CONTENT.TID) ";
    $sql.= "LEFT JOIN SEARCH_POSTS SEARCH_POSTS ";
    $sql.= "ON (SEARCH_POSTS.TID = POST.TID AND SEARCH_POSTS.PID = POST.PID ";
    $sql.= "AND SEARCH_POSTS.FORUM = $forum_fid) ";
    $sql.= "WHERE SEARCH_POSTS.TID IS NULL AND SEARCH_POSTS.PID IS NULL ";
    $sql.= "AND POST_CONTENT.CONTENT IS NOT NULL ";
    $sql.= "LIMIT 0, 1";

    $result = db_query($sql, $db_search_index_old_post);

    if (db_num_rows($result) > 0) {

        list($fid, $tid, $pid, $by_uid, $fuid, $tuid, $content, $created) = db_fetch_array($result, DB_RESULT_NUM);

        search_index_post($fid, $tid, $pid, $by_uid, $fuid, $tuid, $content, $created);
    }

    return false;
}

function search_index_post($fid, $tid, $pid, $by_uid, $fuid, $tuid, $content, $created = 0)
{
    $db_search_index_post = db_connect();

    include("./include/search_stopwords.inc.php");

    if (!is_numeric($fid)) return false;
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($fuid)) return false;
    if (!is_numeric($tuid)) return false;

    if (is_numeric($created) && $created > 0) {
        $created = "FROM_UNIXTIME($created)";
    }else {
        $created = "NOW()";
    }

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $search_min_word_length = intval(forum_get_setting('search_min_word_length', false, 3));

    // Tidy the content up (remove URLs, new lines, HTML and invalid chars)

    $drop_char_match = array("/\^/", "/\$/", "/&/", "/\(/", "/\)/", "/\</",
                             "/\>/", "/`/", "/\"/", "/\|/", "/,/", "/@/",
                             "/_/", "/\?/", "/%/", "/-/", "/~/", "/\+/",
                             "/\./", "/\[/", "/\]/", "/\{/", "/\}/",
                             "/\:/", "/\\\/", "/\//", "/\=/", "/#/",
                             "/'/", "/;/", "/\!/");

    $content = preg_replace("/[\n\r]/is", " ", strip_tags($content));
    $content = preg_replace("/&[a-z]+;/", " ", $content);
    $content = preg_replace("/[a-z0-9]+:\/\/[a-z0-9\.\-]+(\/[a-z0-9\?\.%_\-\+=&\/]+)?/", " ", $content);
    $content = preg_replace($drop_char_match, " ", $content);
    $content = preg_replace("/ +/", " ", $content);

    preg_match_all("/([\w']+)/i", $content, $content_array);

    $content_array = $content_array[0];

    $keyword_array = array();
    $keyword_query = array();

    foreach ($content_array as $key => $keyword_add) {

        $keyword_add = trim(strtolower($keyword_add));
        $keyword_sql = addslashes(trim(strtolower($keyword_add)));

        if (strlen($keyword_add) > ($search_min_word_length - 1) && strlen($keyword_add) < 50 && !_in_array($keyword_add, $mysql_fulltext_stopwords)) {

            if (!_in_array($keyword_add, $keyword_array)) {

                $keyword_array[] = $keyword_add;
                $keyword_query[] = "('$keyword_sql')";
            }
        }
    }

    if (sizeof($keyword_query) > 0) {

        $sql_values = implode(", ", $keyword_query);
        $keyword_list = implode("', '", $keyword_array);

        $sql = "INSERT IGNORE INTO SEARCH_KEYWORDS ";
        $sql.= "(WORD) VALUES $sql_values ";

        $result = db_query($sql, $db_search_index_post);

        $sql = "INSERT IGNORE INTO SEARCH_MATCH ";
        $sql.= "SELECT WID, $forum_fid, $tid, $pid FROM ";
        $sql.= "SEARCH_KEYWORDS WHERE WORD IN ('$keyword_list')";

        $result = db_query($sql, $db_search_index_post);

        $sql = "INSERT IGNORE INTO SEARCH_POSTS (FORUM, FID, TID, PID, BY_UID, FROM_UID, TO_UID, CREATED) ";
        $sql.= "VALUES ($forum_fid, $fid, $tid, $pid, $by_uid, $fuid, $tuid, $created)";

        return db_query($sql, $db_search_index_post);
    }

    return false;
}

?>