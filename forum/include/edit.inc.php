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

/* $Id: edit.inc.php,v 1.31 2004-03-09 23:00:08 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/lang.inc.php");

function post_update($tid, $pid, $content)
{
    if (!is_numeric($tid) || !is_numeric($pid)) return false;

    $db_post_update = db_connect();

    $content  = addslashes($content);
    $edit_uid = bh_session_get_value('UID');
    
    $table_prefix = get_table_prefix();

    $sql = "UPDATE {$table_prefix}POST_CONTENT SET CONTENT = '$content' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_post_update);

    return (db_affected_rows($db_post_update) > 0);
}

function post_add_edit_text($tid, $pid)
{
    if (!is_numeric($tid) || !is_numeric($pid)) return false;
    
    $db_post_add_edit_text = db_connect();
    $edit_uid = bh_session_get_value('UID');
    
    $table_prefix = get_table_prefix();
    
    $sql = "UPDATE {$table_prefix}POST SET EDITED = NOW(), EDITED_BY = '$edit_uid' ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_post_add_edit_text);
    
    return (db_affected_rows($db_post_add_edit_text) > 0);
}

function post_delete($tid, $pid)
{
    if (!is_numeric($tid) || !is_numeric($pid)) return false;

    $db_post_delete = db_connect();

    if (thread_is_poll($tid) && $pid == 1) {
        $sql = "UPDATE {$table_prefix}THREAD SET POLL_FLAG = 'N' WHERE TID = '$tid'";
        $result = db_query($sql, $db_post_delete);
    }
    
    $table_prefix = get_table_prefix();

    $sql = "DELETE FROM {$table_prefix}THREAD WHERE TID = '$tid' AND LENGTH = 1";
    $result = db_query($sql, $db_post_delete);

    $sql = "UPDATE {$table_prefix}POST_CONTENT SET CONTENT = NULL ";
    $sql.= "WHERE TID = '$tid' AND PID = '$pid'";

    $result = db_query($sql, $db_post_delete);

    return (db_affected_rows($db_post_delete) > 0);
}

function edit_refuse($tid, $pid)
{
    global $lang;

    echo "<div align=\"center\">";
    echo "<h1>{$lang['error']}</h1>";
    echo "<p>{$lang['nopermissiontoedit']}</p>";
    echo form_quick_button("discussion.php", $lang['back'], "msg", "$tid.$pid");
    echo "</div>";
}

?>