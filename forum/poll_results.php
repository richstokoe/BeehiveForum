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

/* $Id: poll_results.php,v 1.23 2007-05-15 22:13:16 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (isset($_POST['close'])) {

    html_draw_top();

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($_GET['tid']) && is_numeric($_GET['tid'])) {

    $tid = $_GET['tid'];

    if (!$t_fid = thread_get_folder($tid, 1)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    html_error_msg($lang['mustspecifypolltoview'], 'poll_results.php', 'post', array('close' => $lang['close']));
    html_draw_bottom();
    exit;
}

$polldata = poll_get($tid);

$view_style = POLL_VIEW_TYPE_OPTION;

if (isset($_GET['view_style']) && is_numeric($_GET['view_style'])) {

    if ($_GET['view_style'] == POLL_VIEW_TYPE_OPTION) {

        $view_style = POLL_VIEW_TYPE_OPTION;

    }elseif ($_GET['view_style'] == POLL_VIEW_TYPE_USER) {

        $view_style = POLL_VIEW_TYPE_USER;
    }
}

html_draw_top("openprofile.js");

echo "<h1>{$lang['pollresults']}</h1>\n";
echo "<br />\n";

if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

    echo "<div align=\"center\">\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\" class=\"postbody\">\n";
    echo "      <form name=\"f_mode\" method=\"get\" action=\"poll_results.php\">\n";
    echo "        ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "        ", form_input_hidden("tid", _htmlentities($tid)), "\n";
    echo "        View Style: ", form_dropdown_array("view_style", array($lang['viewbypolloption'], $lang['viewbyuser']), $view_style, "onchange=\"submit()\""), "&nbsp;", form_submit('go', $lang['goexcmark']), "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</div>\n";
}

echo "<div align=\"center\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <table width=\"95%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\"><h2>". thread_get_title($tid). "</h2></td>\n";
echo "        </tr>\n";

if ($polldata['SHOWRESULTS'] == POLL_SHOW_RESULTS || bh_session_get_value('UID') == $polldata['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) || ($polldata['CLOSES'] > 0 && $polldata['CLOSES'] < mktime())) {

    if ($polldata['VOTETYPE'] == POLL_VOTE_PUBLIC && $polldata['CHANGEVOTE'] < POLL_VOTE_MULTI && $polldata['POLLTYPE'] <> POLL_TABLE_GRAPH) {

        echo "        <tr>\n";
        echo "          <td align=\"left\" colspan=\"2\">", poll_public_ballot($tid, $view_style), "</td>\n";
        echo "        </tr>\n";

    }else {

        if ($polldata['POLLTYPE'] == POLL_HORIZONTAL_GRAPH) {

            echo "        <tr>\n";
            echo "          <td align=\"left\">", poll_horizontal_graph($tid), "</td>\n";
            echo "        </tr>\n";

        }elseif ($polldata['POLLTYPE'] == POLL_TABLE_GRAPH) {

            echo "        <tr>\n";
            echo "          <td align=\"left\">", poll_table_graph($tid), "</td>\n";
            echo "        </tr>\n";

        }else {

            echo "        <tr>\n";
            echo "          <td align=\"left\">", poll_vertical_graph($tid), "</td>\n";
            echo "        </tr>\n";
        }
    }

}else {

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i <= sizeof($pollresults['OPTION_ID']); $i++) {

        if (!empty($pollresults['OPTION_NAME'][$i])) {

            echo "        <tr>\n";
            echo "          <td align=\"left\" class=\"postbody\">{$pollresults['OPTION_NAME'][$i]}</td>\n";
            echo "        </tr>\n";
        }
    }
}

echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";
echo "<form method=\"post\" action=\"poll_results.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ". form_submit('close', $lang['close']). "\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>