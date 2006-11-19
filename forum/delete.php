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

/* $Id: delete.php,v 1.112 2006-11-19 00:13:21 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

$valid = true;

if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];
    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['nomessagespecifiedfordel']}</h2>";
    html_draw_bottom();
    exit;
}

if (isset($_POST['cancel'])) {
    $uri = "./discussion.php?webtag=$webtag&msg=". $msg;
    header_redirect($uri);
}

if (bh_session_check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!bh_session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['cannotdeletepostsinthisfolder']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threadcouldnotbefound']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (isset($tid) && isset($pid) && is_numeric($tid) && is_numeric($pid)) {

    if ($preview_message = messages_get($tid, $pid, 1)) {

        $preview_message['CONTENT'] = message_get_content($tid, $pid);

        if ((strlen(trim($preview_message['CONTENT'])) == 0) && !thread_is_poll($tid)) {

            html_draw_top();
            edit_refuse($tid, $pid);
            html_draw_bottom();
            exit;
        }

        if ((bh_session_get_value('UID') != $preview_message['FROM_UID'] || bh_session_check_perm(USER_PERM_PILLORIED, 0)) && !bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

            html_draw_top();
            edit_refuse($tid, $pid);
            html_draw_bottom();
            exit;
        }

    }else {

        html_draw_top();
        echo "<h1>{$lang['error']}</h1>\n";
        echo "<h2>{$lang['message']} $tid.$pid {$lang['wasnotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }
}

html_draw_top("openprofile.js", "basetarget=_blank");

if (isset($_POST['submit']) && is_numeric($tid) && is_numeric($pid)) {

    if (post_delete($tid, $pid)) {

        if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != bh_session_get_value('UID')) {

            admin_add_log_entry(DELETE_POST, array($t_fid, $tid, $pid));
        }

        if ($threaddata['LENGTH'] == 1) {
            $msg = messages_get_most_recent(bh_session_get_value('UID'));
        }else {
            $msg = "$tid.$pid";
        }

        echo "<h1>{$lang['deletemessage']} {$tid}.{$pid}</h1>\n";
        echo "<br />\n";
        echo "<form name=\"prefs\" action=\"discussion.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden('webtag', $webtag), "\n";
        echo "  ", form_input_hidden('msg', $msg), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['deletemessage']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\"><h2>{$lang['postdelsuccessfully']}</h2></td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";

        html_draw_bottom();
        exit;

    }else {

        $error_html = "<h2>{$lang['errordelpost']}</h2>";
    }
}

echo "<h1>{$lang['deletemessage']} {$tid}.{$pid}</h1>\n";
echo "<br />\n";

if ($preview_message['TO_UID'] == 0) {

    $preview_message['TLOGON'] = $lang['allcaps'];
    $preview_message['TNICK'] = $lang['allcaps'];

}else {

    $preview_tuser = user_get($preview_message['TO_UID']);
    $preview_message['TLOGON'] = $preview_tuser['LOGON'];
    $preview_message['TNICK'] = $preview_tuser['NICKNAME'];

}

$preview_tuser = user_get($preview_message['FROM_UID']);

$preview_message['FLOGON'] = $preview_tuser['LOGON'];
$preview_message['FNICK'] = $preview_tuser['NICKNAME'];

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_delete\" action=\"delete.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('msg', $msg), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['deletemessage']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";

if (thread_is_poll($tid) && $pid == 1) {

    poll_display($tid, $threaddata['LENGTH'], $pid, $threaddata['FID'], false, false, false, true, true, true);

}else {

    message_display($tid, $preview_message, $threaddata['LENGTH'], $pid, $threaddata['FID'], true, false, false, false, $show_sigs, true);
}

echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['delete']), "&nbsp;".form_submit("cancel", $lang['cancel']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>