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

/* $Id: nav.php,v 1.85 2005-12-21 17:32:50 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum_links.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

$user_sess = bh_session_check(false);

// Load language file

$lang = load_language_file();

// Make sure we have a webtag

$webtag = get_webtag($webtag_search);

header_no_cache();

html_draw_top("class=navpage", "forumlinks.js");

echo "<div class=\"navleft\">\n";

if ($webtag) {

    echo "<a href=\"start.php?webtag=$webtag\" target=\"main\">{$lang['start']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"discussion.php?webtag=$webtag\" target=\"main\">{$lang['messages']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"discussion.php?webtag=$webtag&amp;right=search\" target=\"main\">{$lang['search']}</a>&nbsp;|&nbsp;\n";

    if (forum_get_setting('show_links', 'Y')) {
        echo "<a href=\"links.php?webtag=$webtag\" target=\"main\">{$lang['links']}</a>&nbsp;|&nbsp;\n";
    }

    if (forum_get_setting('show_pms', 'Y')) {
        echo "<a href=\"pm.php?webtag=$webtag\" target=\"main\">{$lang['pminbox']}</a>&nbsp;|&nbsp;\n";
    }

    echo "<a href=\"user.php?webtag=$webtag\" target=\"main\">{$lang['mycontrols']}</a>&nbsp;|&nbsp;\n";
}

echo "<a href=\"forums.php?webtag=$webtag\" target=\"main\">{$lang['myforums']}</a>&nbsp;|&nbsp;\n";

if (perm_has_admin_access()) {
    echo "<a href=\"admin.php?webtag=$webtag\" target=\"main\">{$lang['admin']}</a>&nbsp;|&nbsp;\n";
}

if (bh_session_get_value('UID') == 0) {
    echo "<a href=\"logout.php?webtag=$webtag\" target=\"_top\">{$lang['login']}</a>&nbsp;|&nbsp;\n";
    echo "<a href=\"register.php?webtag=$webtag\" target=\"main\">{$lang['register']}</a>\n";
}else {
    echo "<a href=\"logout.php?webtag=$webtag\" target=\"main\">{$lang['logout']}</a>\n";
}

echo "</div>\n";
echo "<div class=\"navright\">\n";

echo forum_links_draw_dropdown();

echo "</div>\n";

html_draw_bottom();

?>