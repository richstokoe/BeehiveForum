# beehiveforum database schema
# version 0.1
# requires MySQL version 3.23.5 or greater
#-----------------------------------------

#
# Table structure for table `FOLDER`
#

CREATE TABLE FOLDER (
  FID mediumint(8) unsigned NOT NULL auto_increment,
  TITLE varchar(32) default NULL,
  PRIMARY KEY  (FID)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `POLL`
#

CREATE TABLE POLL (
  TID mediumint(8) unsigned default NULL,
  O1 varchar(255) default NULL,
  O1_VOTES mediumint(8) unsigned default NULL,
  O2 varchar(255) default NULL,
  O2_VOTES mediumint(8) unsigned default NULL,
  O3 varchar(255) default NULL,
  O3_VOTES mediumint(8) unsigned default NULL,
  O4 varchar(255) default NULL,
  O4_VOTES mediumint(8) unsigned default NULL,
  O5 varchar(255) default NULL,
  O6_VOTES mediumint(8) unsigned default NULL,
  CLOSES datetime default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `POST`
#

CREATE TABLE POST (
  TID mediumint(8) unsigned NOT NULL default '0',
  PID mediumint(8) unsigned NOT NULL auto_increment,
  REPLY_TO_PID mediumint(8) unsigned default NULL,
  FROM_UID mediumint(8) unsigned default NULL,
  TO_UID mediumint(8) unsigned default NULL,
  VIEWED datetime default NULL,
  CREATED timestamp(14) NOT NULL,
  CONTENT text,
  PRIMARY KEY  (TID,PID)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `POST_ATTACHMENT`
#

CREATE TABLE POST_ATTACHMENT (
  PID mediumint(8) unsigned default NULL,
  FILE varchar(255) default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `PROFILE_ITEM`
#

CREATE TABLE PROFILE_ITEM (
  PIID mediumint(8) unsigned NOT NULL auto_increment,
  PSID mediumint(8) unsigned default NULL,
  NAME varchar(64) default NULL,
  PRIMARY KEY  (PIID)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `PROFILE_SECTION`
#

CREATE TABLE PROFILE_SECTION (
  PSID mediumint(8) unsigned NOT NULL auto_increment,
  NAME varchar(64) default NULL,
  PRIMARY KEY  (PSID)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `THREAD`
#

CREATE TABLE THREAD (
  TID mediumint(8) unsigned NOT NULL auto_increment,
  FID mediumint(8) unsigned default NULL,
  TITLE varchar(64) default NULL,
  LENGTH mediumint(8) unsigned default NULL,
  POLL_FLAG char(1) default NULL,
  MODIFIED datetime default NULL,
  CLOSED datetime default NULL,
  PRIMARY KEY  (TID)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER`
#

CREATE TABLE USER (
  UID mediumint(8) unsigned NOT NULL auto_increment,
  LOGON varchar(32) default NULL,
  PASSWD varchar(32) default NULL,
  NICKNAME varchar(32) default NULL,
  EMAIL varchar(80) default NULL,
  STATUS int(16) default NULL,
  PRIMARY KEY  (UID)
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER_FOLDER`
#

CREATE TABLE USER_FOLDER (
  UID mediumint(8) unsigned default NULL,
  FID mediumint(8) unsigned default NULL,
  INTEREST tinyint(4) default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER_PEER`
#

CREATE TABLE USER_PEER (
  UID mediumint(8) unsigned default NULL,
  PEER_UID mediumint(8) unsigned default NULL,
  RELATIONSHIP tinyint(4) default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER_PREFS`
#

CREATE TABLE USER_PREFS (
  UID mediumint(8) unsigned default NULL,
  FIRSTNAME varchar(32) default NULL,
  LASTNAME varchar(32) default NULL,
  HOMEPAGE_URL varchar(255) default NULL,
  PIC_URL varchar(255) default NULL,
  EMAIL_NOTIFY char(1) default NULL,
  TIMEZONE tinyint(4) default NULL,
  DL_SAVING char(1) default NULL,
  MARK_AS_OF_INT char(1) default NULL,
  POSTS_PER_PAGE tinyint(3) unsigned default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER_PROFILE`
#

CREATE TABLE USER_PROFILE (
  UID mediumint(8) unsigned default NULL,
  PIID mediumint(8) unsigned default NULL,
  ENTRY varchar(255) default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER_SIG`
#

CREATE TABLE USER_SIG (
  UID mediumint(8) unsigned default NULL,
  CONTENT text,
  HTML char(1) default NULL
) TYPE=MyISAM;
# --------------------------------------------------------

#
# Table structure for table `USER_THREAD`
#

CREATE TABLE USER_THREAD (
  UID mediumint(8) unsigned default NULL,
  TID mediumint(8) unsigned default NULL,
  LAST_READ mediumint(8) unsigned default NULL,
  INTEREST tinyint(4) default NULL
) TYPE=MyISAM;

