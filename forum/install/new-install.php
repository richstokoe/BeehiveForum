<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id$ */

if (isset($_SERVER['SCRIPT_NAME']) && basename($_SERVER['SCRIPT_NAME']) == 'new-install.php') {

    header("Request-URI: install.php");
    header("Content-Location: install.php");
    header("Location: install.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

@set_time_limit(0);

if (!isset($forum_webtag) || strlen(trim($forum_webtag)) < 1) {

    $error_array[] = "<h2>You must specify a forum webtag for your choosen type of installation.</h2>\n";
    $valid = false;
    return;
}

$remove_conflicts = (isset($remove_conflicts) && $remove_conflicts === true);

if (($conflicting_tables = install_check_table_conflicts($db_database, $forum_webtag, true, true, $remove_conflicts))) {

    $error_str = "<h2>Selected database contains tables which conflict with Beehive Forum. ";
    $error_str.= "If this database contains an existing Beehive Forum installation please ";
    $error_str.= "check that you have selected the correct install / upgrade method.</h2>\n";

    $error_array[] = $error_str;

    $error_str = "<h2>If you continue to encounter errors you may want to consider enabling ";
    $error_str.= "the remove conflicts option at the bottom of the installer.</h2>\n";

    $error_array[] = $error_str;

    $error_str = "<h2>Conflicting tables</h2>\n";
    $error_str.= "<div id=\"conflicting_tables\" class=\"install_table_list\">\n";
    $error_str.= sprintf("<ul><li>%s</li></ul>\n", implode("</li><li>", $conflicting_tables));
    $error_str.= "</div>\n";

    $error_array[] = $error_str;

    $valid = false;
    return;
}

$forum_table_prefix = install_format_table_prefix($db_database, $forum_webtag);

$sql = "CREATE TABLE `{$forum_table_prefix}ADMIN_LOG` (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CREATED DATETIME DEFAULT NULL, ";
$sql.= "  ACTION MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  ENTRY TEXT, ";
$sql.= "  PRIMARY KEY (ID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}BANNED` (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  BANTYPE TINYINT(4) NOT NULL DEFAULT '0', ";
$sql.= "  BANDATA VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  COMMENT VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  EXPIRES DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (ID), ";
$sql.= "  KEY BANTYPE (BANTYPE, BANDATA)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}FOLDER` (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  TITLE VARCHAR(32) DEFAULT NULL, ";
$sql.= "  DESCRIPTION VARCHAR(255) DEFAULT NULL, ";
$sql.= "  CREATED datetime default NULL, ";
$sql.= "  MODIFIED datetime default NULL, ";
$sql.= "  PREFIX VARCHAR(16) DEFAULT NULL, ";
$sql.= "  ALLOWED_TYPES TINYINT(3) DEFAULT NULL, ";
$sql.= "  POSITION MEDIUMINT(8) UNSIGNED DEFAULT '0', ";
$sql.= "  PRIMARY KEY (FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}FORUM_LINKS` (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  POS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  URI VARCHAR(255) DEFAULT NULL, ";
$sql.= "  TITLE VARCHAR(64) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (LID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}LINKS` (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  URI VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  TITLE VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  DESCRIPTION TEXT NOT NULL, ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  CLICKS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (LID), ";
$sql.= "  KEY FID (FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}LINKS_COMMENT` (";
$sql.= "  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  COMMENT TEXT NOT NULL, ";
$sql.= "  PRIMARY KEY (CID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}LINKS_FOLDERS` (";
$sql.= "  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT '1', ";
$sql.= "  NAME VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  VISIBLE CHAR(1) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (FID), ";
$sql.= "  KEY PARENT_FID (PARENT_FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}LINKS_VOTE` (";
$sql.= "  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (LID, UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}POLL` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  QUESTION VARCHAR(64) DEFAULT NULL, ";
$sql.= "  CLOSES DATETIME DEFAULT NULL, ";
$sql.= "  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1', ";
$sql.= "  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0', ";
$sql.= "  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1', ";
$sql.= "  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  OPTIONTYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  ALLOWGUESTS TINYINT(1) NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (TID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}POLL_VOTES` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  OPTION_NAME CHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (TID, OPTION_ID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}POST` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  VIEWED DATETIME DEFAULT NULL, ";
$sql.= "  CREATED DATETIME DEFAULT NULL, ";
$sql.= "  STATUS TINYINT(4) DEFAULT '0', ";
$sql.= "  APPROVED DATETIME DEFAULT NULL, ";
$sql.= "  APPROVED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  EDITED DATETIME DEFAULT NULL, ";
$sql.= "  EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  IPADDRESS VARCHAR(15) DEFAULT NULL, ";
$sql.= "  MOVED_TID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  MOVED_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (TID, PID), ";
$sql.= "  KEY TO_UID (TO_UID), ";
$sql.= "  KEY FROM_UID (FROM_UID), ";
$sql.= "  KEY IPADDRESS (IPADDRESS, FROM_UID), ";
$sql.= "  KEY APPROVED (APPROVED), ";
$sql.= "  KEY CREATED (CREATED)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}POST_CONTENT` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CONTENT TEXT, ";
$sql.= "  PRIMARY KEY (TID, PID), ";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}PROFILE_ITEM` (";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  NAME VARCHAR(64) DEFAULT NULL, ";
$sql.= "  TYPE TINYINT(3) UNSIGNED DEFAULT '0', ";
$sql.= "  OPTIONS TEXT NOT NULL, ";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0', ";
$sql.= "  PRIMARY KEY (PIID), ";
$sql.= "  KEY PSID (PSID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}PROFILE_SECTION` (";
$sql.= "  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  NAME VARCHAR(64) DEFAULT NULL, ";
$sql.= "  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0', ";
$sql.= "  PRIMARY KEY (PSID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}RSS_FEEDS` (";
$sql.= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  NAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  URL VARCHAR(255) DEFAULT NULL, ";
$sql.= "  PREFIX VARCHAR(16) DEFAULT NULL, ";
$sql.= "  FREQUENCY MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  LAST_RUN DATETIME DEFAULT NULL, ";
$sql.= "  MAX_ITEM_COUNT MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (RSSID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}RSS_HISTORY` (";
$sql.= "  RSSID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  LINK VARCHAR(255) DEFAULT NULL, ";
$sql.= "  KEY RSSID (RSSID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}STATS` (";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (ID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}THREAD` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  TITLE VARCHAR(64) DEFAULT NULL, ";
$sql.= "  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  UNREAD_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  POLL_FLAG CHAR(1) DEFAULT NULL, ";
$sql.= "  CREATED DATETIME DEFAULT NULL, ";
$sql.= "  MODIFIED DATETIME DEFAULT NULL, ";
$sql.= "  CLOSED DATETIME DEFAULT NULL, ";
$sql.= "  STICKY CHAR(1) DEFAULT NULL, ";
$sql.= "  STICKY_UNTIL DATETIME DEFAULT NULL, ";
$sql.= "  ADMIN_LOCK DATETIME DEFAULT NULL, ";
$sql.= "  DELETED CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  PRIMARY KEY (TID), ";
$sql.= "  KEY STICKY (STICKY, MODIFIED, FID, LENGTH, DELETED), ";
$sql.= "  KEY MODIFIED (MODIFIED, FID, LENGTH, DELETED), ";
$sql.= "  FULLTEXT KEY TITLE (TITLE) ";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}THREAD_STATS` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  VIEWCOUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (TID) ";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}THREAD_TRACK` (";
$sql.= "  TID MEDIUMINT(8) NOT NULL DEFAULT '0', ";
$sql.= "  NEW_TID MEDIUMINT(8) NOT NULL DEFAULT '0', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  TRACK_TYPE TINYINT(4) NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (TID, NEW_TID), ";
$sql.= "  KEY NEW_TID (NEW_TID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_FOLDER` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  INTEREST TINYINT(4) DEFAULT '0', ";
$sql.= "  PRIMARY KEY (UID, FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_PEER` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  RELATIONSHIP TINYINT(4) DEFAULT NULL, ";
$sql.= "  PEER_NICKNAME VARCHAR(32) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID, PEER_UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_POLL_VOTES` (";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  VOTE_ID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (TID, VOTE_ID), ";
$sql.= "  KEY UID (UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_PREFS` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  PIC_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  PIC_AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  AVATAR_URL VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  AVATAR_AID CHAR(32) NOT NULL DEFAULT '',";
$sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  POSTS_PER_PAGE VARCHAR(3) NOT NULL DEFAULT '20',";
$sql.= "  FONT_SIZE VARCHAR(2) NOT NULL DEFAULT '10',";
$sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT '',";
$sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  START_PAGE VARCHAR(3) NOT NULL DEFAULT '0',";
$sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT '',";
$sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2',";
$sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0',";
$sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N',";
$sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  SHOW_THUMBS VARCHAR(2) NOT NULL DEFAULT '2',";
$sql.= "  ENABLE_WIKI_WORDS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  USE_MOVER_SPOILER CHAR(1) DEFAULT 'N', ";
$sql.= "  USE_LIGHT_MODE_SPOILER CHAR(1) DEFAULT 'N', ";
$sql.= "  USE_OVERFLOW_RESIZE CHAR(1) DEFAULT 'Y', ";
$sql.= "  REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  THREADS_BY_FOLDER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  THREAD_LAST_PAGE CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  USE_EMAIL_ADDR CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  LEFT_FRAME_WIDTH SMALLINT(4) NOT NULL DEFAULT '280',";
$sql.= "  SHOW_AVATARS CHAR(1) NOT NULL DEFAULT 'Y',";
$sql.= "  PRIMARY KEY  (UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_PROFILE` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  ENTRY VARCHAR(255) DEFAULT NULL, ";
$sql.= "  PRIVACY TINYINT(3) NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (UID, PIID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_SIG` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CONTENT TEXT, ";
$sql.= "  HTML CHAR(1) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_THREAD` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  LAST_READ_AT DATETIME DEFAULT NULL, ";
$sql.= "  INTEREST TINYINT(4) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID, TID), ";
$sql.= "  KEY TID (TID), ";
$sql.= "  KEY LAST_READ (LAST_READ)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}USER_TRACK` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  DDKEY DATETIME DEFAULT NULL, ";
$sql.= "  LAST_POST DATETIME DEFAULT NULL, ";
$sql.= "  LAST_SEARCH DATETIME DEFAULT NULL, ";
$sql.= "  LAST_SEARCH_KEYWORDS TEXT, ";
$sql.= "  LAST_SEARCH_SORT_BY TINYINT(3) DEFAULT NULL, ";
$sql.= "  LAST_SEARCH_SORT_DIR TINYINT(3) DEFAULT NULL, ";
$sql.= "  POST_COUNT MEDIUMINT(8) UNSIGNED DEFAULT NULL, ";
$sql.= "  USER_TIME_BEST DATETIME DEFAULT NULL, ";
$sql.= "  USER_TIME_TOTAL DATETIME DEFAULT NULL, ";
$sql.= "  USER_TIME_UPDATED DATETIME DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE `{$forum_table_prefix}WORD_FILTER` (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  FILTER_NAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  MATCH_TEXT TEXT NOT NULL, ";
$sql.= "  REPLACE_TEXT TEXT NOT NULL, ";
$sql.= "  FILTER_TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FILTER_ENABLED TINYINT(3) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (UID, FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE DICTIONARY (";
$sql.= "  WORD VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SOUND VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (WORD, UID), ";
$sql.= "  KEY SOUND (SOUND)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE FORUMS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  WEBTAG VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  OWNER_UID MEDIUMINT(8) UNSIGNED NOT NULL, ";
$sql.= "  DATABASE_NAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  DEFAULT_FORUM TINYINT(4) NOT NULL DEFAULT '0', ";
$sql.= "  ACCESS_LEVEL TINYINT(4) NOT NULL DEFAULT '0', ";
$sql.= "  FORUM_PASSWD VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (FID), ";
$sql.= "  KEY WEBTAG (WEBTAG), ";
$sql.= "  KEY DEFAULT_FORUM (DEFAULT_FORUM)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE FORUM_SETTINGS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SNAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  SVALUE TEXT NOT NULL, ";
$sql.= "  PRIMARY KEY (FID, SNAME) ";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUPS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  GROUP_NAME VARCHAR(32) DEFAULT NULL,";
$sql.= "  GROUP_DESC VARCHAR(255) DEFAULT NULL,";
$sql.= "  PRIMARY KEY  (GID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_PERMS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PERM INT(32) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,FORUM,FID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE GROUP_USERS (";
$sql.= "  GID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',";
$sql.= "  UID MEDIUMINT(8) NOT NULL DEFAULT '0',";
$sql.= "  PRIMARY KEY  (GID,UID),";
$sql.= "  KEY UID (UID)";
$sql.= ") ENGINE=MYISAM DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  RECIPIENTS VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SMID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (MID), ";
$sql.= "  KEY TYPE (TYPE), ";
$sql.= "  KEY FROM_UID (FROM_UID), ";
$sql.= "  KEY SMID (SMID), ";
$sql.= "  KEY TO_UID (TO_UID), ";
$sql.= "  FULLTEXT KEY SUBJECT (SUBJECT)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_ATTACHMENT_IDS (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (MID), ";
$sql.= "  KEY AID (AID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_CONTENT (";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CONTENT TEXT, ";
$sql.= "  PRIMARY KEY (MID), ";
$sql.= "  FULLTEXT KEY CONTENT (CONTENT)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_FOLDERS (";
$sql.= "  UID MEDIUMINT(8) NOT NULL,";
$sql.= "  FID MEDIUMINT(8) NOT NULL,";
$sql.= "  TITLE VARCHAR(32) NOT NULL,";
$sql.= "  PRIMARY KEY (UID, FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE PM_SEARCH_RESULTS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  SUBJECT VARCHAR(64) NOT NULL DEFAULT '', ";
$sql.= "  RECIPIENTS VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (UID, MID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_FILES (";
$sql.= "  AID VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FILENAME VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (AID, ID), ";
$sql.= "  KEY UID (UID), ";
$sql.= "  KEY HASH (HASH)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE POST_ATTACHMENT_IDS (";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  AID CHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PRIMARY KEY (FID, TID, PID), ";
$sql.= "  KEY AID (AID), ";
$sql.= "  KEY TID (TID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_ENGINE_BOTS (";
$sql.= "  SID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql.= "  NAME VARCHAR(32) DEFAULT NULL, ";
$sql.= "  URL VARCHAR(255) DEFAULT NULL, ";
$sql.= "  AGENT_MATCH VARCHAR(32) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (SID), ";
$sql.= "  KEY NAME (NAME), ";
$sql.= "  KEY AGENT_MATCH (AGENT_MATCH)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SEARCH_RESULTS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  BY_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  LENGTH MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  RELEVANCE FLOAT UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  PRIMARY KEY (UID, FORUM, TID, PID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE SESSIONS (";
$sql.= "  HASH VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '', ";
$sql.= "  TIME DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL, ";
$sql.= "  SID MEDIUMINT(8) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (HASH), ";
$sql.= "  KEY REFERER (REFERER), ";
$sql.= "  KEY UID (UID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE TIMEZONES (";
$sql.= "  TZID INT(11) NOT NULL DEFAULT '0', ";
$sql.= "  GMT_OFFSET DOUBLE DEFAULT '0', ";
$sql.= "  DST_OFFSET DOUBLE DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (TZID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  LOGON VARCHAR(32) DEFAULT NULL, ";
$sql.= "  PASSWD VARCHAR(32) DEFAULT NULL, ";
$sql.= "  NICKNAME VARCHAR(32) DEFAULT NULL, ";
$sql.= "  EMAIL VARCHAR(80) DEFAULT NULL, ";
$sql.= "  REGISTERED DATETIME DEFAULT NULL, ";
$sql.= "  IPADDRESS VARCHAR(15) DEFAULT NULL, ";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL, ";
$sql.= "  APPROVED DATETIME DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID), ";
$sql.= "  KEY LOGON (LOGON), ";
$sql.= "  KEY NICKNAME (NICKNAME)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_FORUM (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  INTEREST TINYINT(4) DEFAULT '0', ";
$sql.= "  ALLOWED TINYINT(4) DEFAULT '0', ";
$sql.= "  LAST_VISIT DATETIME DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID, FID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_HISTORY (";
$sql.= "  HID MEDIUMINT(8) NOT NULL AUTO_INCREMENT, ";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  LOGON VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  NICKNAME VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  EMAIL VARCHAR(80) NOT NULL DEFAULT '', ";
$sql.= "  MODIFIED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00', ";
$sql.= "  PRIMARY KEY (HID)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE USER_PREFS (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  FIRSTNAME VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  LASTNAME VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  DOB DATE NOT NULL DEFAULT '0000-00-00', ";
$sql.= "  HOMEPAGE_URL VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  PIC_URL VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  PIC_AID VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  AVATAR_URL VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  AVATAR_AID VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  EMAIL_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  TIMEZONE INT(11) NOT NULL DEFAULT '27', ";
$sql.= "  DL_SAVING CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  MARK_AS_OF_INT CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  POSTS_PER_PAGE CHAR(3) NOT NULL DEFAULT '20', ";
$sql.= "  FONT_SIZE CHAR(2) NOT NULL DEFAULT '10', ";
$sql.= "  STYLE VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  EMOTICONS VARCHAR(255) NOT NULL DEFAULT '', ";
$sql.= "  VIEW_SIGS CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  START_PAGE CHAR(1) NOT NULL DEFAULT '0', ";
$sql.= "  LANGUAGE VARCHAR(32) NOT NULL DEFAULT '', ";
$sql.= "  PM_NOTIFY CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  PM_NOTIFY_EMAIL CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  PM_SAVE_SENT_ITEM CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  PM_INCLUDE_REPLY CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  PM_AUTO_PRUNE CHAR(3) NOT NULL DEFAULT '-60', ";
$sql.= "  PM_EXPORT_TYPE CHAR(1) NOT NULL DEFAULT '0', ";
$sql.= "  PM_EXPORT_FILE CHAR(1) NOT NULL DEFAULT '0', ";
$sql.= "  PM_EXPORT_ATTACHMENTS CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  PM_EXPORT_STYLE CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  PM_EXPORT_WORDFILTER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  DOB_DISPLAY CHAR(1) NOT NULL DEFAULT '2', ";
$sql.= "  ANON_LOGON CHAR(1) NOT NULL DEFAULT '0', ";
$sql.= "  SHOW_STATS CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  IMAGES_TO_LINKS CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  USE_WORD_FILTER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  USE_ADMIN_FILTER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  ALLOW_EMAIL CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  USE_EMAIL_ADDR CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  ALLOW_PM CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  POST_PAGE SMALLINT(4) NOT NULL DEFAULT '3271', ";
$sql.= "  SHOW_THUMBS CHAR(2) NOT NULL DEFAULT '2', ";
$sql.= "  ENABLE_WIKI_WORDS CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  USE_MOVER_SPOILER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  USE_LIGHT_MODE_SPOILER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  USE_OVERFLOW_RESIZE CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  REPLY_QUICK CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  THREADS_BY_FOLDER CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  THREAD_LAST_PAGE CHAR(1) NOT NULL DEFAULT 'N', ";
$sql.= "  SHOW_AVATARS CHAR(1) NOT NULL DEFAULT 'Y', ";
$sql.= "  PRIMARY KEY (UID), ";
$sql.= "  KEY DOB (DOB), ";
$sql.= "  KEY DOB_DISPLAY (DOB_DISPLAY)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "CREATE TABLE VISITOR_LOG (";
$sql.= "  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  VID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, ";
$sql.= "  FORUM MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0', ";
$sql.= "  LAST_LOGON DATETIME DEFAULT NULL, ";
$sql.= "  IPADDRESS VARCHAR(15) DEFAULT NULL, ";
$sql.= "  REFERER VARCHAR(255) DEFAULT NULL, ";
$sql.= "  SID MEDIUMINT(8) DEFAULT NULL, ";
$sql.= "  PRIMARY KEY (UID, VID), ";
$sql.= "  KEY FORUM (FORUM), ";
$sql.= "  KEY SID (SID), ";
$sql.= "  KEY LAST_LOGON (LAST_LOGON)";
$sql.= ") ENGINE=MYISAM  DEFAULT CHARSET=UTF8";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}FOLDER` (TITLE, CREATED, MODIFIED, ALLOWED_TYPES, POSITION) ";
$sql.= "VALUES ('General', NOW(), NOW(), 3, 1)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POS, TITLE, URI) ";
$sql.= "VALUES (2, 'Project Beehive Forum Home', 'http://www.beehiveforum.net/')";
if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POS, TITLE, URI) ";
$sql.= "VALUES (3, 'Project Beehive Forum on Facebook', 'http://www.facebook.com/pages/Project-Beehive-Forum/100468551205')";
if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}FORUM_LINKS` (POS, TITLE, URI) ";
$sql.= "VALUES (3, 'Teh Forum', 'http://www.tehforum.co.uk/forum/')";
if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) VALUES (1, 1, 1, 6652)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) VALUES (2, 0, 0, 1536)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) VALUES (1, 1, 0, 33536)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO GROUP_PERMS (GID, FORUM, FID, PERM) VALUES (0, 1, 1, 14588)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO GROUP_USERS (GID, UID) VALUES (1, 1)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO GROUP_USERS (GID, UID) VALUES (2, 1)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}LINKS_FOLDERS` (PARENT_FID, NAME, VISIBLE) ";
$sql.= "VALUES (NULL, 'Top Level', 'Y')";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}POST` ";
$sql.= "(TID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, APPROVED, ";
$sql.= "APPROVED_BY, EDITED, EDITED_BY, IPADDRESS) VALUES (1, 0, 1, 0, NULL, NOW(), ";
$sql.= "0, NOW(), 1, NULL, 0, '')";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
$sql.= "VALUES (1, 1, 'Welcome to your new Beehive Forum')";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` (PSID, NAME, TYPE, OPTIONS, POSITION) ";
$sql.= "VALUES (1, 'Location', 0, '', 1)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` (PSID, NAME, TYPE, OPTIONS, POSITION) ";
$sql.= "VALUES (1, 'Gender', 5, 'Male\nFemale\nUnspecified', 3)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` (PSID, NAME, TYPE, OPTIONS, POSITION) ";
$sql.= "VALUES (1, 'Quote', 0, '', 4)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}PROFILE_ITEM` (PSID, NAME, TYPE, OPTIONS, POSITION) ";
$sql.= "VALUES (1, 'Occupation', 0, '', 5)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}PROFILE_SECTION` (NAME, POSITION) ";
$sql.= "VALUES ('Personal', 1)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$sql = "INSERT INTO `{$forum_table_prefix}THREAD` ";
$sql.= "(FID, BY_UID, TITLE, LENGTH, POLL_FLAG, CREATED, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) ";
$sql.= "VALUES (1, 1, 'Welcome', 1, 'N', NOW(), NOW(), NULL, 'N', NULL, NULL)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$forum_settings = array('wiki_integration_uri'    => 'http://en.wikipedia.org/wiki/[WikiWord]',
                        'enable_wiki_quick_links' => 'Y',
                        'enable_wiki_integration' => 'N',
                        'minimum_post_frequency'  => '0',
                        'maximum_post_length'     => '6226',
                        'post_edit_time'          => '0',
                        'allow_post_editing'      => 'Y',
                        'require_post_approval'   => 'N',
                        'forum_dl_saving'         => 'Y',
                        'forum_timezone'          => '27',
                        'default_language'        => 'en',
                        'default_emoticons'       => 'default',
                        'default_style'           => 'default',
                        'forum_keywords'          => 'A Beehive Forum, Beehive Forum, Project Beehive Forum',
                        'forum_desc'              => 'A Beehive Forum',
                        'forum_email'             => 'admin@abeehiveforum.net',
                        'forum_name'              => 'A Beehive Forum',
                        'forum_links_top_link'    => 'Forum Links:',
                        'show_links'              => 'Y',
                        'allow_polls'             => 'Y',
                        'show_stats'              => 'Y',
                        'allow_search_spidering'  => 'Y',
                        'guest_account_enabled'   => 'Y');

foreach ($forum_settings as $sname => $svalue) {

    $sname = db_escape_string($sname);
    $svalue = db_escape_string($svalue);

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
    $sql.= "VALUES (1, '$sname', '$svalue')";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$global_settings = array('forum_keywords'             => 'A Beehive Forum, Beehive Forum, Project Beehive Forum',
                         'forum_desc'                 => 'A Beehive Forum',
                         'forum_email'                => 'admin@abeehiveforum.net',
                         'forum_noreply_email'        => 'noreply@abeehiveforum.net',
                         'forum_name'                 => 'A Beehive Forum',
                         'allow_search_spidering'     => 'Y',
                         'pm_allow_attachments'       => 'Y',
                         'pm_auto_prune'              => '-60',
                         'pm_max_user_messages'       => '100',
                         'show_pms'                   => 'Y',
                         'new_user_mark_as_of_int'    => 'Y',
                         'showpopuponnewpm'           => 'Y',
                         'new_user_pm_notify_email'   => 'Y',
                         'new_user_email_notify'      => 'Y',
                         'text_captcha_key'           => md5(uniqid(mt_rand())),
                         'text_captcha_enabled'       => 'N',
                         'require_email_confirmation' => 'N',
                         'require_unique_email'       => 'N',
                         'allow_new_registrations'    => 'Y',
                         'active_sess_cutoff'         => '900',
                         'session_cutoff'             => '86400',
                         'search_min_frequency'       => '30',
                         'guest_account_enabled'      => 'Y',
                         'guest_auto_logon'           => 'Y',
                         'attachments_enabled'        => 'N',
                         'attachment_dir'             => 'attachments',
                         'attachments_max_user_space' => '1048576',
                         'attachments_max_post_space' => '1048576',
                         'attachments_allow_embed'    => 'N',
                         'attachment_use_old_method'  => 'N',
                         'message_cache_enabled'      => 'N');

foreach ($global_settings as $sname => $svalue) {

    $sname = db_escape_string($sname);
    $svalue = db_escape_string($svalue);

    $sql = "INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) ";
    $sql.= "VALUES (0, '$sname', '$svalue')";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "INSERT INTO FORUMS (WEBTAG, OWNER_UID, DATABASE_NAME, DEFAULT_FORUM, ACCESS_LEVEL) ";
$sql.= "VALUES ('{$forum_webtag}', '1', '{$db_database}', 1, 0)";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

$bots_array = array('ia_archiver'      => array('NAME' => 'Alexa', 'URL' => 'http://www.alexa.com/'),
                    'Ask Jeeves/Teoma' => array('NAME' => 'Ask.com', 'URL' => 'http://www.ask.com/'),
                    'Baiduspider'      => array('NAME' => 'Baidu', 'URL' => 'http://www.baidu.com/'),
                    'GameSpyHTTP'      => array('NAME' => 'GameSpy', 'URL' => 'http://www.gamespy.com/'),
                    'Gigabot'          => array('NAME' => 'Gigablast', 'URL' => 'http://www.gigablast.com/'),
                    'Googlebot'        => array('NAME' => 'Google', 'URL' => 'http://www.google.com/'),
                    'Googlebot-Image'  => array('NAME' => 'Google Images', 'URL' => 'http://images.google.com/'),
                    'Slurp/si'         => array('NAME' => 'Inktomi', 'URL' => 'http://searchmarketing.yahoo.com/'),
                    'msnbot'           => array('NAME' => 'Bing', 'URL' => 'http://www.bing.com/'),
                    'Scooter'          => array('NAME' => 'Altavista', 'URL' => 'http://www.altavista.com/'),
                    'Yahoo! Slurp;'    => array('NAME' => 'Yahoo!', 'URL' => 'http://www.yahoo.com/'),
                    'Yahoo-MMCrawler'  => array('NAME' => 'Yahoo!', 'URL' => 'http://www.yahoo.com/'));
foreach ($bots_array as $agent => $details) {

    $agent = db_escape_string($agent);
    $name  = db_escape_string($details['NAME']);
    $url   = db_escape_string($details['URL']);

    $sql = "INSERT INTO SEARCH_ENGINE_BOTS (NAME, URL, AGENT_MATCH) ";
    $sql.= "VALUES ('$name', '$url', '%$agent%')";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$timezones_array = array(1  => array(-12, 0),  2  => array(-11, 0),  3  => array(-10, 0),
                         4  => array(-9, 1),   5  => array(-8, 1),   6  => array(-7, 0),
                         7  => array(-7, 1),   8  => array(-7, 1),   9  => array(-6, 0),
                         10 => array(-6, 1),   11 => array(-6, 1),   12 => array(-6, 0),
                         13 => array(-5, 0),   14 => array(-5, 1),   15 => array(-5, 0),
                         16 => array(-4, 1),   17 => array(-4, 0),   18 => array(-4, 1),
                         19 => array(-3.5, 1), 20 => array(-3, 1),   21 => array(-3, 0),
                         22 => array(-3, 1),   23 => array(-2, 1),   24 => array(-1, 1),
                         25 => array(-1, 0),   26 => array(0, 0),    27 => array(0, 1),
                         28 => array(1, 1),    29 => array(1, 1),    30 => array(1, 1),
                         31 => array(1, 1),    32 => array(1, 0),    33 => array(2, 1),
                         34 => array(2, 1),    35 => array(2, 1),    36 => array(2, 0),
                         37 => array(2, 1),    38 => array(2, 0),    39 => array(3, 1),
                         40 => array(3, 0),    41 => array(3, 1),    42 => array(3, 0),
                         43 => array(3.5, 1),  44 => array(4, 0),    45 => array(4, 1),
                         46 => array(4.5, 0),  47 => array(5, 1),    48 => array(5, 0),
                         49 => array(5.5, 0),  50 => array(5.75, 0), 51 => array(6, 1),
                         52 => array(6, 0),    53 => array(6, 0),    54 => array(6.5, 0),
                         55 => array(7, 0),    56 => array(7, 1),    57 => array(8, 0),
                         58 => array(8, 1),    59 => array(8, 0),    60 => array(8, 0),
                         61 => array(8, 0),    62 => array(9, 0),    63 => array(9, 0),
                         64 => array(9, 1),    65 => array(9.5, 1),  66 => array(9.5, 0),
                         67 => array(10, 0),   68 => array(10, 1),   69 => array(10, 0),
                         70 => array(10, 1),   71 => array(10, 1),   72 => array(11, 0),
                         73 => array(12, 1),   74 => array(12, 0),   75 => array(13, 0));

foreach ($timezones_array as $tzid => $tz_data) {

    if (!is_numeric($tzid)) return false;

    if (!isset($tz_data[0]) || !is_numeric($tz_data[0])) return false;
    if (!isset($tz_data[1]) || !is_numeric($tz_data[1])) return false;

    $sql = "INSERT INTO TIMEZONES (TZID, GMT_OFFSET, DST_OFFSET) ";
    $sql.= "VALUES ('$tzid', '{$tz_data[0]}', '{$tz_data[1]}')";

    if (!$result = @db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

$sql = "INSERT INTO USER (LOGON, PASSWD, NICKNAME, EMAIL, REGISTERED) ";
$sql.= "VALUES (UPPER('$admin_username'), MD5('$admin_password'), ";
$sql.= "'$admin_username', '$admin_email', NOW())";

if (!$result = @db_query($sql, $db_install)) {

    $valid = false;
    return;
}

if (!isset($skip_dictionary) || $skip_dictionary === false) {
    
    // Construct full path to the dictionary file.
    $dictionary_path = str_replace('\\', '/', rtrim(dirname(__FILE__), DIRECTORY_SEPARATOR));

    // Check the file exists and is readable by PHP.
    if (@file_exists("$dictionary_path/english.dic") && is_readable("$dictionary_path/english.dic")) {
        
        try {

            // Try importing the file using MySQL's LOAD DATA INFILE
            $sql = "LOAD DATA INFILE '$dictionary_path/english.dic' ";
            $sql.= "INTO TABLE DICTIONARY LINES TERMINATED BY '\\n' (WORD)";

            $result = db_query($sql, $db_install);
            
        } catch (Exception $e) {

            // MySQL LOAD DATA INFILE failed. Try reading the file
            // using PHP.
            $dictionary_words_array = file($dictionary_path);

            foreach ($dictionary_words_array as $word) {

                $word = db_escape_string(trim($word));

                $sql = "INSERT INTO DICTIONARY (WORD) VALUES('$word')";

                if (!$result = db_query($sql, $db_install)) {

                    $valid = false;
                    return;
                }
            }
        }
    }

    // Generate the soundex values for the words.
    $sql = "UPDATE DICTIONARY SET SOUND = SOUNDEX(WORD)";

    if (!$result = db_query($sql, $db_install)) {

        $valid = false;
        return;
    }
}

?>
