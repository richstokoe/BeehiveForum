# Beehive Forum Database Creation
# version 0.4-dev
# http://beehiveforum.sourceforge.net/
#
# Schema generated using phpMyAdmin
# (http://phpmyadmin.sourceforge.net)
# Generation Time: Mar 17, 2004 at 00:17
#
# $Id: schema.sql,v 1.69 2004-04-12 18:32:24 decoyduck Exp $
#
# --------------------------------------------------------

#
# Table structure for table `ADMIN_LOG`
#

CREATE TABLE DEFAULT_ADMIN_LOG (
  LOG_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  LOG_TIME DATETIME DEFAULT NULL,
  ADMIN_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PSID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  ACTION MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (LOG_ID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `BANNED_IP`
#

CREATE TABLE DEFAULT_BANNED_IP (
  IP CHAR(15) NOT NULL DEFAULT '',
  PRIMARY KEY  (IP)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `DEDUPE`
#

CREATE TABLE DEFAULT_DEDUPE (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  DDKEY CHAR(32) DEFAULT NULL,
  PRIMARY KEY  (UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `FILTER_LIST`
#

CREATE TABLE DEFAULT_FILTER_LIST (
  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  MATCH_TEXT VARCHAR(255) NOT NULL DEFAULT '',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  REPLACE_TEXT VARCHAR(255) NOT NULL DEFAULT '',
  FILTER_OPTION TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (ID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `FOLDER`
#

CREATE TABLE DEFAULT_FOLDER (
  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  TITLE VARCHAR(32) DEFAULT NULL,
  ACCESS_LEVEL TINYINT(4) DEFAULT '0',
  DESCRIPTION VARCHAR(255) DEFAULT NULL,
  ALLOWED_TYPES TINYINT(3) DEFAULT NULL,
  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (FID)
) TYPE=MYISAM;

#
# Dumping data for table `folder`
#

INSERT INTO DEFAULT_FOLDER (TITLE, ACCESS_LEVEL, DESCRIPTION, ALLOWED_TYPES, POSITION) VALUES ('General', 0, NULL, NULL, 0);

# --------------------------------------------------------

#
# Table structure for table `FORUM_SETTINGS`
#

CREATE TABLE FORUM_SETTINGS (
  SID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  SNAME VARCHAR(255) NOT NULL DEFAULT '',
  SVALUE VARCHAR(255) NOT NULL DEFAULT '',
  KEY SID (SID,FID)
) TYPE=MYISAM;

#
# Dumping data for table `FORUM_SETTINGS`
#

INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'forum_name', 'A Beehive Forum');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'forum_email', 'admin@abeehiveforum.net');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'default_style', 'default');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'default_emoticons', 'default');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'default_language', 'en');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'show_friendly_errors', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'cookie_domain', '');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'show_stats', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'show_links', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'auto_logon', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'show_pms', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'pm_allow_attachments', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'maximum_post_length', '6226');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'allow_post_editing', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'post_edit_time', '0');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'allow_polls', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'search_min_word_length', '3');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'attachments_enabled', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'attachments_dir', 'attachments');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'attachments_show_deleted', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'attachments_allow_embed', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'attachments_use_old_method', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'guest_account_active', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'session_cutoff', '86400');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'active_session_cutoff', '900');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'gzip_compress_output', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (0, 'gzip_compress_level', '1');

INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_name', 'A Beehive Forum');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'forum_email', 'admin@abeehiveforum.net');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'default_style', 'default');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'default_emoticons', 'default');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'default_language', 'en');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_friendly_errors', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'cookie_domain', '');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_stats', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_links', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'auto_logon', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'show_pms', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'pm_allow_attachments', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'maximum_post_length', '6226');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_post_editing', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'post_edit_time', '0');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'allow_polls', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'search_min_word_length', '3');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_enabled', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_dir', 'attachments');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_show_deleted', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_allow_embed', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'attachments_use_old_method', 'N');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'guest_account_active', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'session_cutoff', '86400');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'active_session_cutoff', '900');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'gzip_compress_output', 'Y');
INSERT INTO FORUM_SETTINGS (FID, SNAME, SVALUE) VALUES (1, 'gzip_compress_level', '1');

# --------------------------------------------------------

#
# Table structure for table `FORUMS`
#

CREATE TABLE FORUMS (
  FID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  WEBTAG VARCHAR(255) DEFAULT NULL,
  DEFAULT_FORUM TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',
  ACCESS_LEVEL TINYINT(4) DEFAULT '0',
  PRIMARY KEY  (FID)
) TYPE=MYISAM;

#
# Dumping data for table `FORUMS`
#

INSERT INTO FORUMS (WEBTAG, DEFAULT_FORUM) VALUES ('DEFAULT', 1);

# --------------------------------------------------------

#
# Table structure for table `links`
#

CREATE TABLE DEFAULT_LINKS (
  LID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  FID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  URI VARCHAR(255) NOT NULL DEFAULT '',
  TITLE VARCHAR(64) NOT NULL DEFAULT '',
  DESCRIPTION TEXT NOT NULL,
  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  VISIBLE CHAR(1) NOT NULL DEFAULT 'N',
  CLICKS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (LID),
  KEY FID (FID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `LINKS_COMMENT`
#

CREATE TABLE DEFAULT_LINKS_COMMENT (
  CID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  COMMENT TEXT NOT NULL,
  PRIMARY KEY  (CID),
  KEY LID (LID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `LINKS_FOLDERS`
#

CREATE TABLE DEFAULT_LINKS_FOLDERS (
  FID SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  PARENT_FID SMALLINT(5) UNSIGNED DEFAULT '1',
  NAME VARCHAR(32) NOT NULL DEFAULT '',
  VISIBLE CHAR(1) NOT NULL DEFAULT '',
  PRIMARY KEY  (FID)
) TYPE=MYISAM;

#
# Dumping data for table `LINKS_FOLDERS`
#

INSERT INTO DEFAULT_LINKS_FOLDERS (PARENT_FID, NAME, VISIBLE) VALUES (NULL, 'Top Level', 'Y');

# --------------------------------------------------------

#
# Table structure for table `LINKS_VOTE`
#

CREATE TABLE DEFAULT_LINKS_VOTE (
  LID SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  RATING SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',
  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (LID,UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `PM`
#

CREATE TABLE DEFAULT_PM (
  MID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  TYPE TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  TO_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FROM_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  SUBJECT VARCHAR(64) NOT NULL DEFAULT '',
  CREATED DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  NOTIFIED TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (MID),
  KEY TO_UID (TO_UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `PM_ATTACHMENT_IDS`
#

CREATE TABLE DEFAULT_PM_ATTACHMENT_IDS (
  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  AID CHAR(32) NOT NULL DEFAULT '',
  PRIMARY KEY  (MID),
  KEY AID (AID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `PM_CONTENT`
#

CREATE TABLE DEFAULT_PM_CONTENT (
  MID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  CONTENT TEXT,
  PRIMARY KEY  (MID),
  FULLTEXT KEY CONTENT (CONTENT)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `POLL`
#

CREATE TABLE DEFAULT_POLL (
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  CLOSES DATETIME DEFAULT NULL,
  CHANGEVOTE TINYINT(1) NOT NULL DEFAULT '1',
  POLLTYPE TINYINT(1) NOT NULL DEFAULT '0',
  SHOWRESULTS TINYINT(1) NOT NULL DEFAULT '1',
  VOTETYPE TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (TID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `POLL_VOTES`
#

CREATE TABLE DEFAULT_POLL_VOTES (
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  OPTION_NAME CHAR(255) NOT NULL DEFAULT '',
  GROUP_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (TID,OPTION_ID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `POST`
#

CREATE TABLE DEFAULT_POST (
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  REPLY_TO_PID MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  FROM_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  TO_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  VIEWED DATETIME DEFAULT NULL,
  CREATED DATETIME DEFAULT NULL,
  STATUS TINYINT(4) DEFAULT '0',
  EDITED DATETIME DEFAULT NULL,
  EDITED_BY MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',
  PRIMARY KEY  (TID,PID),
  KEY TO_UID (TO_UID),
  KEY IPADDRESS (IPADDRESS)
) TYPE=MYISAM;

#
# Dumping data for table `POST`
#

INSERT INTO DEFAULT_POST (TID, REPLY_TO_PID, FROM_UID, TO_UID, VIEWED, CREATED, STATUS, EDITED, EDITED_BY, IPADDRESS) VALUES (1, 0, 1, 0, NULL, NOW(), 0, NULL, 0, '');

# --------------------------------------------------------

#
# Table structure for table `POST_ATTACHMENT_FILES`
#

CREATE TABLE DEFAULT_POST_ATTACHMENT_FILES (
  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  AID VARCHAR(32) NOT NULL DEFAULT '',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FILENAME VARCHAR(255) NOT NULL DEFAULT '',
  MIMETYPE VARCHAR(255) NOT NULL DEFAULT '',
  HASH VARCHAR(32) NOT NULL DEFAULT '',
  DOWNLOADS MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (ID),
  KEY AID (AID),
  KEY HASH (HASH)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `POST_ATTACHMENT_IDS`
#

CREATE TABLE DEFAULT_POST_ATTACHMENT_IDS (
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  AID CHAR(32) NOT NULL DEFAULT '',
  PRIMARY KEY  (TID,PID),
  KEY AID (AID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `POST_CONTENT`
#

CREATE TABLE DEFAULT_POST_CONTENT (
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  CONTENT TEXT,
  PRIMARY KEY  (TID,PID),
  FULLTEXT KEY CONTENT (CONTENT)
) TYPE=MYISAM;

#
# Dumping data for table `POST_CONTENT`
#

INSERT INTO DEFAULT_POST_CONTENT (TID, PID, CONTENT) VALUES (1, 1, 'Welcome to your new Beehive Forum');

# --------------------------------------------------------

#
# Table structure for table `PROFILE_ITEM`
#

CREATE TABLE DEFAULT_PROFILE_ITEM (
  PIID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  PSID MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  NAME VARCHAR(64) DEFAULT NULL,
  TYPE TINYINT(3) UNSIGNED DEFAULT '0',
  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (PIID)
) TYPE=MYISAM;

#
# Dumping data for table `PROFILE_ITEM`
#

INSERT INTO DEFAULT_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Location', 0, 0);
INSERT INTO DEFAULT_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Age', 0, 0);
INSERT INTO DEFAULT_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Gender', 0, 0);
INSERT INTO DEFAULT_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Quote', 0, 0);
INSERT INTO DEFAULT_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Occupation', 0, 0);
INSERT INTO DEFAULT_PROFILE_ITEM (PSID, NAME, TYPE, POSITION) VALUES (1, 'Birthday (DD/MM)', 0, 0);

# --------------------------------------------------------

#
# Table structure for table `PROFILE_SECTION`
#

CREATE TABLE DEFAULT_PROFILE_SECTION (
  PSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  NAME VARCHAR(64) DEFAULT NULL,
  POSITION MEDIUMINT(3) UNSIGNED DEFAULT '0',
  PRIMARY KEY  (PSID)
) TYPE=MYISAM;

#
# Dumping data for table `PROFILE_SECTION`
#

INSERT INTO DEFAULT_PROFILE_SECTION (NAME, POSITION) VALUES ('Personal', 0);

# --------------------------------------------------------

#
# Table structure for table `SESSIONS`
#

CREATE TABLE SESSIONS (
  SESSID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  HASH VARCHAR(32) NOT NULL DEFAULT '',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  IPADDRESS VARCHAR(15) NOT NULL DEFAULT '',
  TIME DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (SESSID),
  KEY HASH (HASH),
  KEY FID (FID),
  KEY UID (UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `START_MAIN`
#

CREATE TABLE START_MAIN (
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  HTML TEXT NOT NULL,
  PRIMARY KEY  (FID)
) TYPE=MYISAM;

#
# Dumping data for table `START_MAIN`
#

INSERT INTO START_MAIN (FID, HTML) VALUES (1, '<!doctype HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">\n<html>\n<head>\n<title>Project Beehive</title>\n<style type="text/css">\n<!--\n\n.bodytext    { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n               font-style: normal; line-height: 13px; font-weight: normal; color: #666666;\n               background-color: #EAEFF4 }\n\n.title       { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 18px;\n               font-style: normal; font-weight: bold; color: #ffffff; background-color: #A6BED7 }\n\na            { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n               line-height: 13px; font-weight: normal; color: #333399;\n               text-decoration: underline }\n\n-->\n</style>\n</head>\n\n<body class="bodytext">\n<table width="100%" border="0" cellspacing="0" cellpadding="8">\n  <tr>\n    <td class="title">Welcome to your new Beehive Forum!</td>\n  </tr>\n  <tr>\n    <td class="bodytext"><a href="http://sourceforge.net/projects/beehiveforum/" target="_blank">Home</a> | <a href="http://beehiveforum.net/faq">FAQ</a> | <a href="http://sourceforge.net/docman/?group_id=50772" target="_blank">Docs</a> | <a href="http://sourceforge.net/project/showfiles.php?group_id=50772" target="_blank"> Download</a> | <a href="../forums.php">Live Forums</a></td>\n  </tr>\n  <tr>\n    <td height="1" class="title"></td>\n  </tr>\n  <tr>\n    <td valign="top" class="bodytext">\n      <p>You can modify this start page from the admin interface.</p>\n    </td>\n  </tr>\n  <tr>\n    <td height="1" class="title"> </td>\n  </tr>\n</table>\n</body>\n</html>');

# --------------------------------------------------------

#
# Table structure for table `STATS`
#

CREATE TABLE DEFAULT_STATS (
  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  MOST_USERS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  MOST_USERS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  MOST_POSTS_DATE DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  MOST_POSTS_COUNT MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY  (ID)
) TYPE=MYISAM;

#
# Dumping data for table `STATS`
#

INSERT INTO DEFAULT_STATS (MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) VALUES (NOW(), 0, NOW(), 0);

# --------------------------------------------------------

#
# Table structure for table `THREAD`
#

CREATE TABLE DEFAULT_THREAD (
  TID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  FID MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  BY_UID MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  TITLE VARCHAR(64) DEFAULT NULL,
  LENGTH MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  POLL_FLAG CHAR(1) DEFAULT NULL,
  MODIFIED DATETIME DEFAULT NULL,
  CLOSED DATETIME DEFAULT NULL,
  STICKY CHAR(1) DEFAULT NULL,
  STICKY_UNTIL DATETIME DEFAULT NULL,
  ADMIN_LOCK DATETIME DEFAULT NULL,
  PRIMARY KEY  (TID),
  KEY IX_THREAD_FID (FID),
  KEY BY_UID (BY_UID)
) TYPE=MYISAM;

#
# Dumping data for table `THREAD`
#

INSERT INTO DEFAULT_THREAD (FID, BY_UID, TITLE, LENGTH, POLL_FLAG, MODIFIED, CLOSED, STICKY, STICKY_UNTIL, ADMIN_LOCK) VALUES (1, 1, 'Welcome', 1, 'N', NOW(), NULL, 'N', NULL, NULL);

# --------------------------------------------------------

#
# Table structure for table `USER`
#

CREATE TABLE USER (
  UID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  LOGON VARCHAR(32) DEFAULT NULL,
  PASSWD VARCHAR(32) DEFAULT NULL,
  NICKNAME VARCHAR(32) DEFAULT NULL,
  EMAIL VARCHAR(80) DEFAULT NULL,
  PRIMARY KEY  (UID)
) TYPE=MYISAM;

#
# Dumping data for table `USER`
#

INSERT INTO USER (LOGON, PASSWD, NICKNAME, EMAIL) VALUES ('ADMIN', 'b60eb83bf533eecf1bde65940925a981', 'Administrator', 'your@email.com');
INSERT INTO USER (LOGON, PASSWD, NICKNAME, EMAIL) VALUES ('GUEST', '084e0343a0486ff05530df6c705c8bb4', 'Guest', 'guest@email.com');

# --------------------------------------------------------

#
# Table structure for table `USER_FOLDER`
#

CREATE TABLE DEFAULT_USER_FOLDER (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  INTEREST TINYINT(4) DEFAULT '0',
  ALLOWED TINYINT(4) DEFAULT '0',
  PRIMARY KEY  (UID,FID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_FORUM`
#

CREATE TABLE USER_FORUM (
  UID mediumint(8) unsigned NOT NULL default '0',
  FID mediumint(8) unsigned NOT NULL default '0',
  INTEREST tinyint(4) default '0',
  ALLOWED tinyint(4) default '0',
  PRIMARY KEY  (UID,FID)
) TYPE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_PEER`
#

CREATE TABLE DEFAULT_USER_PEER (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PEER_UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  RELATIONSHIP TINYINT(4) DEFAULT NULL,
  PRIMARY KEY  (UID,PEER_UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_POLL_VOTES`
#

CREATE TABLE DEFAULT_USER_POLL_VOTES (
  ID MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PTUID VARCHAR(32) NOT NULL DEFAULT '',
  OPTION_ID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  TSTAMP DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (ID,TID,PTUID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_PREFS`
#

CREATE TABLE DEFAULT_USER_PREFS (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FIRSTNAME VARCHAR(32) DEFAULT NULL,
  LASTNAME VARCHAR(32) DEFAULT NULL,
  DOB DATE DEFAULT '0000-00-00',
  HOMEPAGE_URL VARCHAR(255) DEFAULT NULL,
  PIC_URL VARCHAR(255) DEFAULT NULL,
  EMAIL_NOTIFY CHAR(1) DEFAULT NULL,
  TIMEZONE DECIMAL(2,1) DEFAULT NULL,
  DL_SAVING CHAR(1) DEFAULT NULL,
  MARK_AS_OF_INT CHAR(1) DEFAULT NULL,
  POSTS_PER_PAGE TINYINT(3) UNSIGNED DEFAULT NULL,
  FONT_SIZE TINYINT(3) UNSIGNED DEFAULT NULL,
  STYLE VARCHAR(255) DEFAULT NULL,
  EMOTICONS VARCHAR(255) DEFAULT NULL,
  VIEW_SIGS CHAR(1) DEFAULT NULL,
  START_PAGE TINYINT(3) UNSIGNED DEFAULT NULL,
  LANGUAGE VARCHAR(32) DEFAULT NULL,
  PM_NOTIFY CHAR(1) DEFAULT NULL,
  PM_NOTIFY_EMAIL CHAR(1) DEFAULT NULL,
  DOB_DISPLAY TINYINT(3) UNSIGNED DEFAULT NULL,
  ANON_LOGON TINYINT(3) UNSIGNED DEFAULT NULL,
  SHOW_STATS TINYINT(3) UNSIGNED DEFAULT NULL,
  IMAGES_TO_LINKS CHAR(1) DEFAULT NULL,
  USE_WORD_FILTER CHAR(1) DEFAULT NULL,
  USE_ADMIN_FILTER CHAR(1) DEFAULT NULL,
  ALLOW_EMAIL CHAR(1) DEFAULT NULL,
  ALLOW_PM CHAR(1) DEFAULT NULL,
  PRIMARY KEY  (UID,UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_PROFILE`
#

CREATE TABLE DEFAULT_USER_PROFILE (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  PIID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  ENTRY VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY  (UID,PIID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_SIG`
#

CREATE TABLE DEFAULT_USER_SIG (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  CONTENT TEXT,
  HTML CHAR(1) DEFAULT NULL,
  PRIMARY KEY  (UID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `USER_STATUS`
#

CREATE TABLE USER_STATUS (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  STATUS INT(16) NOT NULL DEFAULT '0',
  PRIMARY KEY  (UID,FID)
) TYPE=MYISAM;

#
# Dumping data for table `USER_STATUS`
#

INSERT INTO USER_STATUS (UID, FID, STATUS) VALUES (1, 0, 56);
INSERT INTO USER_STATUS (UID, FID, STATUS) VALUES (1, 1, 56);
INSERT INTO USER_STATUS (UID, FID, STATUS) VALUES (2, 1, 0);

# --------------------------------------------------------

#
# Table structure for table `USER_THREAD`
#

CREATE TABLE DEFAULT_USER_THREAD (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  TID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  LAST_READ MEDIUMINT(8) UNSIGNED DEFAULT NULL,
  LAST_READ_AT DATETIME DEFAULT NULL,
  INTEREST TINYINT(4) DEFAULT NULL,
  PRIMARY KEY  (UID,TID)
) TYPE=MYISAM;

# --------------------------------------------------------

#
# Table structure for table `VISITOR_LOG`
#

CREATE TABLE VISITOR_LOG (
  UID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  FID MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  LAST_LOGON DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (UID,FID)
) TYPE=MYISAM;

#
# Dumping data for table `VISITOR_LOG`
#

INSERT INTO VISITOR_LOG (UID, FID, LAST_LOGON) VALUES (1, 1, NOW());
