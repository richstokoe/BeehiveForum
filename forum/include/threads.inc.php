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

// Included functions for displaying threads in the left frameset.

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/format.inc.php"); // Formatting functions

function threads_get_folders()
{
	$db = db_connect();
	$query = "select distinct FID, TITLE from " . forum_table("FOLDER") . " order by FID";
	$result = db_query($query, $db);

	if (!db_num_rows($result)) {
		 $folder_titles = FALSE;
	} else {
		while($query_data = db_fetch_array($result)) {
			$folder_titles[$query_data['FID']] = $query_data['TITLE'];
		}
	}

	return $folder_titles;
	db_disconnect($db);
}

function threads_get_all($uid) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
	$db = db_connect();

	// Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
	// for threads with unread messages, so the UID needs to be passed to the function

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_unread($uid) // get unread messages for $uid
{
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL)";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_unread_to_me($uid) // get unread messages for $uid
{
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, ";
	$sql .= forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid), ";
	$sql .= forum_table("POST") . " POST ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "AND (USER_THREAD.last_read < THREAD.length OR USER_THREAD.last_read IS NULL) ";
	$sql .= "AND POST.TID = THREAD.TID AND POST.TO_UID = $uid AND POST.VIEWED IS NULL ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_by_days($uid,$days = 1) // get "all" threads (i.e. most recent threads, irrespective of read or unread status).
{
	$db = db_connect();

	// Formulate query - the join with USER_THREAD is needed becuase even in "all" mode we need to display [x new of y]
	// for threads with unread messages, so the UID needs to be passed to the function

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, " . forum_table("THREAD") . " THREAD ";
	$sql .= "LEFT JOIN " . forum_table("USER_THREAD") . " USER_THREAD ON ";
	$sql .= "(USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid) ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "AND TO_DAYS(NOW()) - TO_DAYS(THREAD.MODIFIED) <= $days ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_by_interest($uid,$interest = 3) // get unread messages for $uid (default High Interest)
{
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
	$sql .= "AND USER_THREAD.INTEREST = $interest ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_unread_by_interest($uid,$interest = 3) // get unread messages for $uid (default High Interest)
{
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
	$sql .= "AND USER_THREAD.last_read < THREAD.length ";
	$sql .= "AND USER_THREAD.INTEREST = $interest ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_get_recently_viewed($uid) // get unread messages for $uid (default High Interest)
{
	$db = db_connect();

	// Formulate query

	$sql  = "SELECT THREAD.tid, THREAD.fid, THREAD.title, THREAD.length, USER_THREAD.last_read, UNIX_TIMESTAMP(THREAD.modified) AS modified ";
	$sql .= "FROM " . forum_table("FOLDER") . " FOLDER, " . forum_table("THREAD") . " THREAD, ";
	$sql .= forum_table("USER_THREAD") . " USER_THREAD ";
	$sql .= "WHERE THREAD.fid = FOLDER.fid ";
	$sql .= "AND USER_THREAD.TID = THREAD.TID AND USER_THREAD.UID = $uid ";
	$sql .= "AND TO_DAYS(NOW()) - TO_DAYS(USER_THREAD.LAST_READ_AT <= 1 ";
	$sql .= "ORDER BY THREAD.modified DESC ";
	$sql .= "LIMIT 0, 50";

	$resource_id = db_query($sql, $db);
	list($threads, $folder_order) = threads_process_list($resource_id);
	return array($threads, $folder_order);
	db_disconnect($db);

}

function threads_process_list($resource_id) // Arrange the results of a query into the right order for display
{
	// If the user has clicked on a folder header, we want that folder to be first in the list
	global $HTTP_GET_VARS;
	if (isset($HTTP_GET_VARS['folder'])) $folder_order[] = $HTTP_GET_VARS['folder'];

	// Loop through the results and construct an array to return
	for ($i = 0; $i < db_num_rows($resource_id); $i++) {
		$thread = db_fetch_array($resource_id);

		// If this folder ID has not been encountered before, make it the next folder in the order to be displayed
		if (!isset($folder_order)) {
			$folder_order[] = $thread['fid'];
		} else {
			if (!in_array($thread['fid'], $folder_order)) $folder_order[] = $thread['fid'];
		}

		$lst[$i]['tid'] = $thread['tid'];
		$lst[$i]['fid'] = $thread['fid'];
		$lst[$i]['title'] = stripslashes($thread['title']);
		$lst[$i]['length'] = $thread['length'];

		if (isset($thread['last_read'])) { // special case - last_read may be NULL, in which case PHP will complain that the array index doesn't exist if we don't do this
			$lst[$i]['last_read'] = $thread['last_read'];
		} else {
			$lst[$i]['last_read'] = 0;
		}

		$lst[$i]['modified'] = $thread['modified'];
		
	}
	return array($lst, $folder_order); // $lst is the array with thread information, $folder_order is a list of FIDs in the order in which the folders should be displayed
}

function threads_display_list($thread_info, $folder_order) // Displays the thread list when given an array of thread information and an array containing the desired order of folders
{
	// Get folder FIDs and titles
	$folder_info = threads_get_folders();
	if (!$folder_info) die ("Could not retrieve folder information");

	// Get total number of messages for each folder
	$folder_msgs = threads_get_folder_msgs();

	// Work out if any folders have no messages - if so, they still need to be displayed, so add them to $folder_order
	while (list($fid, $title) = each($folder_info)) {
		if (!in_array($fid, $folder_order)) $folder_order[] = $fid;
	}

	// Iterate through the information we've just got and display it in the right order
	while (list($key1, $folder) = each($folder_order)) {
		echo "<tr>\n";
		echo "<td class=\"foldername\">\n";
		echo "<img src=\"./images/folder.png\" alt=\"folder\" />\n";
		echo $folder_info[$folder];
		echo "</td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class=\"threadname\">\n";
		echo "<span class=\"folderinfo\">".$folder_msgs[$folder]." msgs</span>\n";
		echo "<span class=\"folderpostnew\"><a href=\"post.php?fid=$folder\" target=\"right\">Post New</a></span><br />\n";
		echo "<ul>\n";
		while (list($key2, $thread) = each($thread_info)) {
			if ($thread['fid'] == $folder) {
				if ($thread['length'] == $thread['last_read']) {
					$number = "[".$thread['length']."]";
					$latest_post = 1;
				} elseif ($thread['last_read'] == 0) {
					$number = "[".$thread['length']." new]";
					$latest_post = 1;
				} else {
					$new_posts = $thread['length'] - $thread['last_read'];
					$number = "[".$new_posts." new of ".$thread['length']."]";
					$latest_post = $thread['last_read'] + 1;
				}
				echo "<li><a href=\"messages.php?msg=".$thread['tid'].".".$latest_post."\" target=\"right\">".$thread['title']."</a>";
				echo "<span class=\"folderxnewofy\">$number</span></li>\n";
			}
		}
		reset($thread_info);
		echo "</ul>\n";
		echo "</td>\n";
		echo "</tr>\n";
	}
}

function thread_get_title($tid)
{
   $db = db_connect();
   $sql = "SELECT THREAD.title FROM " . forum_table("THREAD") . " WHERE tid = $tid";
   $resource_id = db_query($sql,$db);
   if(!db_num_rows($resource_id)){
     $threadtitle = "The Unknown Thread";
   } else {
     $data = db_fetch_array($resource_id);
     $threadtitle = stripslashes($data['title']);
   }
   db_disconnect($db);
   return $threadtitle;
}

function thread_get($tid)
{
   $db = db_connect();
   $sql = "SELECT * FROM " . forum_table("THREAD") . " WHERE tid = $tid";
   $resource_id = db_query($sql,$db);
   if(!db_num_rows($resource_id)){
     $threaddata = false;
   } else {
     $threaddata = db_fetch_array($resource_id);
   }
   db_disconnect($db);
   return $threaddata;
}

function threads_get_folder_msgs()
{
	$db = db_connect();
	$sql = "SELECT fid, COUNT(fid) AS total FROM " . forum_table("THREAD") . " GROUP BY fid";
	$resource_id = db_query($sql, $db);
	for ($i = 0; $i < db_num_rows($resource_id); $i++) {
		$folder = db_fetch_array($resource_id);
		$folder_msgs[$folder['fid']] = $folder['total'];
	}
	db_disconnect($db);
	return $folder_msgs;
}

function thread_get_author($tid)
{
	$db = db_connect();
	$sql = "SELECT * FROM USER, POST WHERE USER.UID = POST.FROM_UID AND POST.TID = $tid";
	$resource_id = db_query($sql, $db);
	$author = db_fetch_array($resource_id);
	db_disconnect($db);
	return format_user_name($author['LOGON'], $author['NICKNAME']);
}
	
?>
