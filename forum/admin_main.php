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

/* $Id: admin_main.php,v 1.23 2004-03-13 20:04:33 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/constants.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

echo "<h1>{$lang['forumadmin']}</h1>\n";
echo "<p>{$lang['adminexp_1']}</p>\n";
echo "<p>{$lang['adminexp_2']}</p>\n";
echo "<p>{$lang['adminexp_3']}</p>\n";
echo "<p>{$lang['adminexp_4']}</p>\n";
echo "<p>{$lang['adminexp_5']}</p>\n";
echo "<p>{$lang['adminexp_6']}</p>\n";
echo "<p>{$lang['adminexp_7']}</p>\n";
echo "<p>{$lang['adminexp_8']}</p>\n";

html_draw_bottom();

?>