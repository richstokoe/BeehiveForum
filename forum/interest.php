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

/* $Id: interest.php,v 1.25 2004-03-13 20:04:34 decoyduck Exp $ */

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/db.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($HTTP_POST_VARS['tid']) && isset($HTTP_POST_VARS['interest']) && is_numeric($HTTP_POST_VARS['tid']) && is_numeric($HTTP_POST_VARS['interest']) && thread_can_view($HTTP_POST_VARS['tid'], bh_session_get_value('UID'))) {

    $tid = $HTTP_POST_VARS['tid'];
    $int = $HTTP_POST_VARS['interest'];
    $uid = bh_session_get_value('UID');

    thread_set_interest($tid, $int);
}

if (isset($HTTP_GET_VARS['ret'])) {
    header_redirect($HTTP_GET_VARS['ret']);
}else {
    header_redirect("./messages.php?webtag={$webtag['WEBTAG']}");
}

?>