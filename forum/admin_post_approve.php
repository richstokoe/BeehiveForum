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

/* $Id: admin_post_approve.php,v 1.52 2007-09-08 17:42:40 decoyduck Exp $ */

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
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
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Array to hold error messages

$error_msg_array = array();

// Returning to the approval queue?

if (isset($_POST['return_queue']) && $_POST['return_queue'] == 'Y') {
    $return_queue = "Y";
}elseif (isset($_GET['return_queue']) && $_GET['return_queue'] == 'Y') {
    $return_queue = "Y";
}else {
    $return_queue = "N";
}

// Check POST and GET for message ID and check it is valid.

if (isset($_POST['msg'])) {

    if (validate_msg($_POST['msg'])) {

        $msg = $_POST['msg'];

    }else {

        html_draw_top();
        html_error_msg($lang['nomessagespecifiedforedit'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }

}elseif (isset($_GET['msg'])) {

    if (validate_msg($_GET['msg'])) {

        $msg = $_GET['msg'];

    }else {

        html_draw_top();
        html_error_msg($lang['nomessagespecifiedforedit'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

// User clicked cancel

if (isset($_POST['cancel'])) {

    if ($return_queue == "Y") {

        header_redirect("admin_post_approve.php?webtag=$webtag");

    }else {

        $uri = "./discussion.php?webtag=$webtag&msg=$msg";
        header_redirect($uri);
    }
}

if (isset($msg) && validate_msg($msg)) {

    $valid = true;

    list($tid, $pid) = explode('.', $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {

        html_draw_top();
        html_error_msg($lang['cannoteditpostsinthisfolder'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }

    if (!bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top();
        html_error_msg($lang['cannoteditpostsinthisfolder'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }

    if (!$threaddata = thread_get($tid)) {

        html_draw_top();
        html_error_msg($lang['threadcouldnotbefound'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }

    if ($preview_message = messages_get($tid, $pid, 1)) {

        if (!isset($preview_message['APPROVED']) || $preview_message['APPROVED'] > 0) {

            html_draw_top();
            html_error_msg($lang['postdoesnotrequireapproval'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
            html_draw_bottom();
            exit;
        }

        $preview_message['CONTENT'] = message_get_content($tid, $pid);

        if ((strlen(trim($preview_message['CONTENT'])) == 0) && !thread_is_poll($tid)) {

            html_draw_top();
            edit_refuse($tid, $pid);
            html_draw_bottom();
            exit;
        }

        if (isset($_POST['approve']) && is_numeric($tid) && is_numeric($pid)) {

            if (post_approve($tid, $pid)) {

                admin_add_log_entry(APPROVED_POST, array($t_fid, $tid, $pid));

                if ($threaddata['LENGTH'] == 1) {
                    $msg = messages_get_most_recent(bh_session_get_value('UID'));
                }else {
                    $msg = "$tid.$pid";
                }

                $ret = ($return_queue == 'Y') ? 'admin_post_approve.php' : 'discussion.php';

                html_draw_top();
                html_display_msg($lang['approvepost'], $lang['postapprovedsuccessfully'], $ret, 'get', array('back' => $lang['back']), array('msg' => $msg));
                html_draw_bottom();

            }else {

                $error_msg_array[] = $lang['postapprovalfailed'];
            }
        }

        html_draw_top("post.js", "poll.js", "resize_width=720");

        echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['approvepost']}</h1>\n";

        if ($preview_message['TO_UID'] == 0) {

            $preview_message['TLOGON'] = $lang['allcaps'];
            $preview_message['TNICK']  = $lang['allcaps'];

        }else {

            $preview_tuser = user_get($preview_message['TO_UID']);
            $preview_message['TLOGON'] = $preview_tuser['LOGON'];
            $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
        }

        $preview_tuser = user_get($preview_message['FROM_UID']);

        $preview_message['FLOGON'] = $preview_tuser['LOGON'];
        $preview_message['FNICK'] = $preview_tuser['NICKNAME'];

        $show_sigs = (bh_session_get_value('VIEW_SIGS') == 'N') ? false : true;

        if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
            html_display_error_array($error_msg_array, '720', 'left');
        }

        echo "<br />\n";
        echo "<form name=\"f_delete\" action=\"admin_post_approve.php\" method=\"post\" target=\"_self\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden('msg', _htmlentities($msg)), "\n";
        echo "  ", form_input_hidden("return_queue", _htmlentities($return_queue)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['approvepost']}</td>\n";
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
        echo "      <td align=\"center\">", form_submit("approve", $lang['approve']), "&nbsp;".form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";

        html_draw_bottom();

    }else {

        html_draw_top();
        html_error_msg($lang['postdoesnotexist'], 'admin_post_approve.php', 'post', array('cancel' => $lang['cancel']), array('return_queue' => $return_queue));
        html_draw_bottom();
        exit;
    }

}else {

    if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) && !bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0) && !bh_session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE)) {

        html_draw_top();
        html_error_msg($lang['accessdeniedexp']);
        html_draw_bottom();
        exit;
    }

    html_draw_top();

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['postapprovalqueue']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"420\">{$lang['threadtitle']}</td>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">{$lang['messagenumber']}</td>\n";
    echo "                   <td class=\"subhead\" align=\"left\" width=\"100\">&nbsp;</td>\n";
    echo "                 </tr>\n";

    $start = floor($page - 1) * 10;
    if ($start < 0) $start = 0;

    $post_approval_array = admin_get_post_approval_queue($start);

    if (sizeof($post_approval_array['post_array']) > 0) {

        foreach($post_approval_array['post_array'] as $post_approval_entry) {

            echo "                 <tr>\n";
            echo "                   <td align=\"left\">", word_filter_add_ob_tags(_htmlentities(thread_format_prefix($post_approval_entry['PREFIX'], $post_approval_entry['TITLE']))), "</td>\n";
            echo "                   <td align=\"left\">{$post_approval_entry['MSG']}</td>\n";
            echo "                   <td align=\"left\">", form_quick_button("admin_post_approve.php", $lang['approve'], array('msg' => $post_approval_entry['MSG'], 'return_queue' => "Y")), "</td>\n";
            echo "                 </tr>\n";
        }

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
        echo "                 </tr>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" colspan=\"3\">&nbsp;{$lang['nopostsawaitingapproval']}</td>\n";
        echo "                 </tr>\n";
        echo "                 <tr>\n";
        echo "                   <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
        echo "                 </tr>\n";
    }

    echo "               </table>\n";
    echo "             </td>\n";
    echo "           </tr>\n";
    echo "         </table>\n";
    echo "       </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(true, false), $start, $post_approval_array['post_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>