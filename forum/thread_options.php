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

/* $Id: thread_options.php,v 1.89 2007-08-21 20:27:39 decoyduck Exp $ */

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

//$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "beehive.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
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
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Guests can't use this

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that required variables are set

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode(".", $_GET['msg']);

}elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];
    list($tid, $pid) = explode(".", $_POST['msg']);

}else {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Get the folder ID for the current message

if (!$fid = thread_get_folder($tid)) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// UID of the current user.

$uid = bh_session_get_value('UID');

// Get the existing thread data.

if (!$threaddata = thread_get($tid, true)) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Back button clicked.

if (isset($_POST['back'])) {

    header_redirect("./messages.php?webtag=$webtag&msg=$msg");
    exit;
}

// Code for handling functionality from messages.php

if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {

    $mark_as_read = $_GET['markasread'];

    if (messages_set_read($tid, $mark_as_read, $uid, $threaddata['MODIFIED'])) {

        header_redirect("./messages.php?webtag=$webtag&msg=$msg&markasread=1");
        exit;
    }

}else if (isset($_POST['setinterest']) && is_numeric($_POST['setinterest'])) {

    $thread_interest = $_POST['setinterest'];

    if (thread_set_interest($tid, $thread_interest)) {

        header_redirect("./messages.php?webtag=$webtag&msg=$msg&setinterest=1");
        exit;
    }
}

// Submit Code

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['markasread']) && is_numeric($_POST['markasread'])) {

        $mark_as_read = $_POST['markasread'];

        if (!messages_set_read($tid, $mark_as_read, $uid, $threaddata['MODIFIED'])) {

            $error_msg_array[] = $lang['failedtoupdatethreadreadstatus'];
            $valid = false;
        }
    }

    if (isset($_POST['interest']) && is_numeric($_POST['interest'])) {

        $thread_interest = $_POST['interest'];

        if (!thread_set_interest($tid, $threaddata['INTEREST'])) {

            $error_msg_array[] = $lang['failedtoupdatethreadinterest'];
            $valid = false;
        }
    }

    // Admin Options

    if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid) || ((($threaddata['FROM_UID'] == $uid) && $threaddata['ADMIN_LOCK'] == THREAD_ADMIN_LOCK_DISABLED) && ((forum_get_setting('allow_post_editing', 'Y')) && intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)))) {

        if (isset($_POST['rename']) && strlen(trim(_stripslashes($_POST['rename']))) > 0) {

            $t_rename = trim(_stripslashes($_POST['rename']));

            if (thread_change_title($fid, $tid, $t_rename)) {

                post_add_edit_text($tid, 1);

                if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

                    admin_add_log_entry(RENAME_THREAD, array($tid, $threaddata['TITLE'], $t_rename));
                }

            }else {

                $error_msg_array[] = $lang['failedtorenamethread'];
                $valid = false;
            }
        }

        if (isset($_POST['move']) && is_numeric($_POST['move'])) {

            $t_move = $_POST['move'];

            if (folder_is_valid($t_move) && bh_session_check_perm(USER_PERM_THREAD_CREATE, $t_move)) {

                if (thread_change_folder($tid, $t_move)) {

                    $new_folder_title = folder_get_title($t_move);
                    $old_folder_title = folder_get_title($threaddata['FID']);

                    post_add_edit_text($tid, 1);

                    if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

                        admin_add_log_entry(MOVED_THREAD, array($tid, $threaddata['TITLE'], $old_folder_title, $new_folder_title));
                    }

                }else {

                    $error_msg_array[] = $lang['failedtomovethread'];
                    $valid = false;
                }
            }
        }
    }

    if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

        if (isset($_POST['closed']) && in_array($_POST['closed'], array('Y', 'N'))) {

            $threaddata['CLOSED'] = ($_POST['closed'] == "Y");

            if (thread_set_closed($tid, $threaddata['CLOSED'])) {

                admin_add_log_entry(($threaddata['CLOSED']) ? CLOSED_THREAD : OPENED_THREAD, array($tid, $threaddata['TITLE']));

            }else {

                $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                $valid = false;
            }
        }

        if (isset($_POST['lock']) && in_array($_POST['lock'], array('Y', 'N'))) {

            $threaddata['ADMIN_LOCK'] = ($_POST['lock'] == "Y");

            if (thread_admin_lock($tid, $threaddata['ADMIN_LOCK'])) {

                admin_add_log_entry(($threaddata['ADMIN_LOCK']) ? LOCKED_THREAD : UNLOCKED_THREAD, array($tid, $threaddata['TITLE']));

            }else {

                $error_msg_array[] = $lang['failedtoupdatethreadlockstatus'];
                $valid = false;
            }
        }

        if (isset($_POST['sticky']) && $_POST['sticky'] == "Y") {

            if (isset($_POST['sticky_year']) && isset($_POST['sticky_month']) && isset($_POST['sticky_day'])) {

                $sticky_day   = trim(_stripslashes($_POST['sticky_day']));
                $sticky_month = trim(_stripslashes($_POST['sticky_month']));
                $sticky_year  = trim(_stripslashes($_POST['sticky_year']));

                if (@checkdate($sticky_month, $sticky_day, $sticky_year)) {

                    $thread_sticky_until = mktime(0, 0, 0, $sticky_month, $sticky_day, $sticky_year);

                    $threaddata['STICKY'] = $_POST['sticky'];
                    $threaddata['STICKY_UNTIL'] = $thread_sticky_until;

                    if (thread_set_sticky($tid, true, $thread_sticky_until)) {

                        admin_add_log_entry(CREATE_THREAD_STICKY, array($tid, $threaddata['TITLE']));

                    }else {

                        $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                        $valid = false;
                    }

                }else {

                    $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                    $valid = false;
                }
            }

        }else {

            $threaddata['STICKY'] = $_POST['sticky'];

            if (thread_set_sticky($tid, false)) {

                admin_add_log_entry(REMOVE_THREAD_STICKY, array($tid, $threaddata['TITLE']));

            }else {

                $error_msg_array[] = $lang['failedtoupdatethreadstickystatus'];
                $valid = false;
            }
        }

        if (isset($_POST['thread_merge_split']) && is_numeric($_POST['thread_merge_split'])) {

            if ($_POST['thread_merge_split'] == THREAD_TYPE_MERGE) {

                if (isset($_POST['merge_thread']) && is_numeric($_POST['merge_thread'])) {

                    if (isset($_POST['merge_type']) && is_numeric($_POST['merge_type']) && isset($_POST['merge_thread_con']) && $_POST['merge_thread_con'] == "Y") {

                        $merge_thread = $_POST['merge_thread'];
                        $merge_type   = $_POST['merge_type'];

                        if (validate_msg($merge_thread)) list($merge_thread,) = explode('.', $merge_thread);

                        if ($merge_result = thread_merge($merge_thread, $tid, $merge_type, $error_str)) {

                            admin_add_log_entry(THREAD_MERGE, $merge_result);

                        }else {

                            $error_msg_array[] = $error_str;
                            $valid = false;
                        }
                    }
                }

            }elseif ($_POST['thread_merge_split'] == THREAD_TYPE_SPLIT) {

                if (isset($_POST['split_thread']) && is_numeric($_POST['split_thread']) && $_POST['split_thread'] > 1) {

                    if (isset($_POST['split_type']) && is_numeric($_POST['split_type']) && isset($_POST['split_thread_con']) && $_POST['split_thread_con'] == "Y") {

                        $split_start = $_POST['split_thread'];
                        $split_type  = $_POST['split_type'];

                        if ($split_result = thread_split($tid, $split_start, $split_type, $error_str)) {

                            admin_add_log_entry(THREAD_SPLIT, $split_result);

                        }else {

                            $error_msg_array[] = $error_str;
                            $valid = false;
                        }
                    }
                }
            }
        }

        if (isset($_POST['t_to_uid_in_thread']) && is_numeric($_POST['t_to_uid_in_thread']) && isset($_POST['deluser_con']) && $_POST['deluser_con'] == "Y") {

            if ($del_uid = $_POST['t_to_uid_in_thread']) {

                if ($user_logon = user_get_logon($del_uid['UID'])) {

                    if (thread_delete_by_user($tid, $del_uid['UID'])) {

                        admin_add_log_entry(DELETE_USER_THREAD_POSTS, array($tid, $threaddata['TITLE'], $user_logon));

                    }else {

                        $error_msg_array[] = sprintf($lang['failedtodeletepostsbyuser'], $user_logon);
                        $valid = false;
                    }
                }
            }
        }

        if (isset($_POST['delthread']) && is_numeric($_POST['delthread'])) {

            if (isset($_POST['delthread_con']) && $_POST['delthread_con'] == "Y") {

                $delete_thread = $_POST['delthread'];

                if (thread_delete($tid, $delete_thread)) {

                    admin_add_log_entry(DELETE_THREAD, array($tid, $threaddata['TITLE']));

                }else {

                    $error_msg_array[] = $lang['failedtodeletethread'];
                    $valid = false;
                }
            }
        }

        if (isset($_POST['undelthread']) && $_POST['undelthread'] == "Y") {

            if (isset($_POST['undelthread_con']) && $_POST['undelthread_con'] == "Y") {

                if (thread_undelete($tid)) {

                    admin_add_log_entry(UNDELETE_THREAD, array($tid, $threaddata['TITLE']));

                }else {

                    $error_msg_array[] = $lang['failedtoundeletethread'];
                    $valid = false;
                }
            }
        }

        if ($valid) {

            header_redirect("thread_options.php?webtag=$webtag&msg=$msg&updated=true");
            exit;
        }
    }
}

if ($threaddata['LENGTH'] > 0) {

    html_draw_top("basetarget=_blank", "robots=noindex,nofollow", 'thread_options.js');

    echo "<h1>{$lang['threadoptions']} &raquo; <a href=\"messages.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\">#{$tid} ", thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']), "</a></h1>\n";

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '500', 'center');

    }else if (isset($_GET['updated'])) {

        html_display_success_msg($lang['updatessavedsuccessfully'], '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"thread_options.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("msg", _htmlentities($msg)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['useroptions']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"250\" class=\"posthead\">{$lang['markedasread']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("markasread", _htmlentities($threaddata['LAST_READ']), 5), " {$lang['postsoutof']} {$threaddata['LENGTH']}</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\" class=\"posthead\">{$lang['interest']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_IGNORED, $lang['ignore'], $threaddata['INTEREST'] == THREAD_IGNORED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_NOINTEREST, $lang['normal'], $threaddata['INTEREST'] == THREAD_NOINTEREST), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_INTERESTED, $lang['interested'], $threaddata['INTEREST'] == THREAD_INTERESTED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("interest", THREAD_SUBSCRIBED, $lang['subscribe'], $threaddata['INTEREST'] == THREAD_SUBSCRIBED), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";

    if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid) || ((($threaddata['FROM_UID'] == $uid) && $threaddata['ADMIN_LOCK'] == THREAD_ADMIN_LOCK_DISABLED) && ((forum_get_setting('allow_post_editing', 'Y')) && intval(forum_get_setting('post_edit_time', false, 0)) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time', false, 0)) * MINUTE_IN_SECONDS)))) {

        echo "        <br />\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['rename']} / {$lang['move']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"250\" class=\"posthead\">{$lang['renamethread']}:</td>\n";

        if (thread_is_poll($tid)) {
            echo "                        <td align=\"left\"><a href=\"edit_poll.php?webtag=$webtag&amp;msg=$msg\" target=\"_parent\">{$lang['editthepoll']}</a> {$lang['torenamethisthread']}.</td>\n";
        }else {
            echo "                        <td align=\"left\">", form_input_text("rename", $threaddata['TITLE'], 30, 64), "</td>\n";
        }

        $thread_type = (thread_is_poll($tid) ? FOLDER_ALLOW_POLL_THREAD : FOLDER_ALLOW_NORMAL_THREAD);

        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"posthead\">{$lang['movethread']}:</td>\n";
        echo "                        <td align=\"left\">", folder_draw_dropdown($threaddata['FID'], "move", "", $thread_type, "", "post_folder_dropdown"), "</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";

        if (bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

            $thread_available_pids = thread_get_unmoved_posts($tid);

            if (thread_is_poll($tid) && $thread_available_pids) {

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mergesplitthread']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_input_hidden("thread_merge_split", 1), $lang['splitthreadatpost'], "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 0, $lang['selectedpostsandrepliesonly'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 1, $lang['selectedandallfollowingposts'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("split_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";

            }else if (!thread_is_poll($tid) && !$thread_available_pids) {

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mergesplitthread']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_input_hidden("thread_merge_split", 0), $lang['mergewiththreadid'], "</td>\n";
                echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text("merge_thread", "", 28, 15, "", "merge_thread_id"), "<a href=\"search_popup.php?webtag=$webtag&amp;type=2&amp;obj_name=merge_thread\" onclick=\"return openThreadSearch('$webtag', 'merge_thread');\"><img src=\"", style_image('search_button.png'), "\" alt=\"{$lang['search']}\" title=\"{$lang['search']}\" border=\"0\" class=\"search_button\" /></a></div></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 0, $lang['postsinthisthreadatstart'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 1, $lang['postsinthisthreadatend'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 2, $lang['reorderpostsintodateorder'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("merge_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";

            }else if (!thread_is_poll($tid) && $thread_available_pids) {

                $thread_available_pids = array('&nbsp;') + $thread_available_pids;

                echo "        <br />\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['mergesplitthread']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"center\">\n";
                echo "                    <table class=\"posthead\" width=\"95%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_radio("thread_merge_split", 0, $lang['mergewiththreadid'], false, false, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\" nowrap=\"nowrap\"><div class=\"bhinputsearch\">", form_input_text('merge_thread', '', 26, 0, "", "merge_thread_id"), form_submit_image("search_button.png", "search", $lang['search'], "onclick=\"return openThreadSearch('$webtag', 'merge_thread');\" title=\"{$lang['search']}\"", "search_button"), "</div></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 0, $lang['postsinthisthreadatstart'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 1, $lang['postsinthisthreadatend'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("merge_type", 2, $lang['reorderpostsintodateorder'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("merge_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" colspan=\"2\"><hr /></td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" width=\"250\">", form_radio("thread_merge_split", 1, $lang['splitthreadatpost'], false, false, 'posthead'), "</td>\n";
                echo "                        <td align=\"left\">", form_dropdown_array('split_thread', $thread_available_pids), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 0, $lang['selectedpostsandrepliesonly'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\" class=\"posthead\">", form_radio("split_type", 1, $lang['selectedandallfollowingposts'], false), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">", form_checkbox("split_thread_con", "Y", $lang['confirm']), "</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                    </table>\n";
                echo "                  </td>\n";
                echo "                </tr>\n";
                echo "              </table>\n";
                echo "            </td>\n";
                echo "          </tr>\n";
                echo "        </table>\n";
            }

            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['makethreadsticky']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" width=\"50%\" class=\"posthead\">{$lang['sticky']}:</td>\n";

            if ($threaddata['STICKY_UNTIL'] && $threaddata['STICKY'] == "Y") {

                $sticky_year  = date("Y", $threaddata['STICKY_UNTIL']);
                $sticky_month = date("n", $threaddata['STICKY_UNTIL']);
                $sticky_day   = date("j", $threaddata['STICKY_UNTIL']);

            }else {

                $sticky_year  = 0;
                $sticky_month = 0;
                $sticky_day   = 0;
            }

            echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_radio("sticky", "Y", $lang['until'], $threaddata['STICKY'] == "Y"), "&nbsp;", form_date_dropdowns($sticky_year, $sticky_month, $sticky_day, "sticky_"), "&nbsp;&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">", form_radio("sticky", "N", $lang['no'], $threaddata['STICKY'] == "N"), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['locked']} / {$lang['closed']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['closedforposting']}:</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("closed", "Y", $lang['yes'], $threaddata['CLOSED']), " \n";
            echo "                          ", form_radio("closed", "N", $lang['no'], !$threaddata['CLOSED']), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['locktitleandfolder']}:</td>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          ", form_radio("lock", "Y", $lang['yes'], $threaddata['ADMIN_LOCK']), " \n";
            echo "                          ", form_radio("lock", "N", $lang['no'], !$threaddata['ADMIN_LOCK']), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['deleteposts']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['deletepostsinthreadbyuser']}:</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", post_draw_to_dropdown_in_thread($tid, 0, false, true), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("deluser_con", "Y", $lang['confirm']), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "        <br />\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['deletethread']}</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"posthead\">{$lang['deletethread']}:</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delthread", -1, $lang['no'], true), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delthread", 0, $lang['permenantlydelete'], false), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_radio("delthread", 1, $lang['movetodeleteditems'], false), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("delthread_con", "Y", $lang['confirm'], false), "</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
        }

        echo "      </td>\n";
        echo "    </tr>\n";
    }

    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), " &nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif ($thread_length = thread_can_be_undeleted($tid)) {

    html_draw_top("basetarget=_blank", "robots=noindex,nofollow", 'thread_options.js');

    echo "<h1>{$lang['threadoptions']}: <a href=\"messages.php?webtag=$webtag&amp;msg=$msg\" target=\"_self\">#{$tid} ", thread_format_prefix($threaddata['PREFIX'], $threaddata['TITLE']), "</a></h1>\n";
    echo "<br />\n";

    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"thread_options.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden("msg", _htmlentities($msg)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\"> \n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['undeletethread']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['undeletethread']}</td>\n";
    echo "                        <td align=\"left\">", form_radio("undelthread", "Y", $lang['yes']), "&nbsp;", form_radio("undelthread", "N", $lang['no'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\" class=\"posthead\">", form_checkbox("undelthread_con", "Y", $lang['confirm'], false), " \n";
    echo "                        </td>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top();
    html_error_msg($lang['threaddeletedpermenantly']);
    html_draw_bottom();
}

?>