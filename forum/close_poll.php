<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'admin.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

// Array to hold error messages
$error_msg_array = array();

// Check if the user is viewing signatures.
$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

// Form validation
$valid = true;

// Submit code.
if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {

    $msg = $_POST['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];

    list($tid, $pid) = explode(".", $msg);

    if (!$t_fid = thread_get_folder($tid, $pid)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    html_draw_error(gettext("No message specified for deletion"));
}

if (isset($_POST['cancel'])) {

    header_redirect("discussion.php?webtag=$webtag&msg=$msg");
    exit;
}

if (session::check_perm(USER_PERM_EMAIL_CONFIRM, 0)) {

    html_email_confirmation_error();
    exit;
}

if (!session::check_perm(USER_PERM_POST_EDIT | USER_PERM_POST_READ, $t_fid)) {
    html_draw_error(gettext("You cannot delete posts in this folder"));
}

if (!$thread_data = thread_get($tid)) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (!thread_is_poll($tid) || ($pid != 1)) {

    $uri = "discussion.php?webtag=$webtag";

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        $uri.= "&msg=". $_GET['msg'];
    } else if (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
        $uri.= "&msg=". $_POST['msg'];
    }

    header_redirect($uri);
}

if (!$edit_message = messages_get($tid, 1, 1)) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_display_error_msg(gettext("That post does not exist in this thread!"));
    html_draw_bottom();
    exit;
}

$post_edit_time = forum_get_setting('post_edit_time', null, 0);

$uid = session::get_value('UID');

if ((forum_get_setting('allow_post_editing', 'N') || (($uid != $edit_message['FROM_UID']) && !(perm_get_user_permissions($edit_message['FROM_UID']) & USER_PERM_PILLORIED)) || (session::check_perm(USER_PERM_PILLORIED, 0)) || ($post_edit_time > 0 && (time() - $edit_message['CREATED']) >= ($post_edit_time * HOUR_IN_SECONDS))) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
    html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $edit_message));
}

if (forum_get_setting('require_post_approval', 'Y') && isset($edit_message['APPROVED']) && $edit_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {
    html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => $edit_message));
}

if (($preview_message = messages_get($tid, $pid, 1))) {

    $preview_message['CONTENT'] = message_get_content($tid, $pid);

    if ((strlen(trim($preview_message['CONTENT'])) < 1) && !thread_is_poll($tid)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        post_edit_refuse($tid, $pid);
        html_draw_bottom();
        exit;
    }

    if ((session::get_value('UID') != $preview_message['FROM_UID'] || session::check_perm(USER_PERM_PILLORIED, 0)) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        post_edit_refuse($tid, $pid);
        html_draw_bottom();
        exit;
    }

    if (forum_get_setting('require_post_approval', 'Y') && isset($preview_message['APPROVED']) && $preview_message['APPROVED'] == 0 && !session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid)) {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        post_edit_refuse($tid, $pid);
        html_draw_bottom();
        exit;
    }
}

if (isset($_POST['endpoll'])) {

    if (poll_close($tid)) {

        post_add_edit_text($tid, 1);

        if (session::check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) && $preview_message['FROM_UID'] != session::get_value('UID')) {
            admin_add_log_entry(EDIT_POST, array($t_fid, $tid, $pid));
        }
    }

    if ($thread_data['LENGTH'] > 1) {

        header_redirect("discussion.php?webtag=$webtag&msg=$msg&edit_success=$msg");
        exit;

    } else {

        header_redirect("discussion.php?webtag=$webtag&edit_success=$msg");
        exit;
    }
}

html_draw_top(sprintf("title=%s", gettext("Close Poll")), "post.js", "resize_width=720", "basetarget=_blank", 'class=window_title');

echo "<h1>", gettext("Close Poll"), " {$tid}.{$pid}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {
    html_display_error_array($error_msg_array, '720', 'left');
}

if ($preview_message['TO_UID'] == 0) {

    $preview_message['TLOGON'] = gettext("ALL");
    $preview_message['TNICK'] = gettext("ALL");

} else {

    $preview_tuser = user_get($preview_message['TO_UID']);
    $preview_message['TLOGON'] = $preview_tuser['LOGON'];
    $preview_message['TNICK'] = $preview_tuser['NICKNAME'];
}

$preview_tuser = user_get($preview_message['FROM_UID']);

$preview_message['FLOGON'] = $preview_tuser['LOGON'];
$preview_message['FNICK'] = $preview_tuser['NICKNAME'];

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"close_poll.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('msg', htmlentities_array($msg)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"720\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">", gettext("End Poll"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\"><br />";

poll_display($tid, $thread_data['LENGTH'], $pid, $thread_data['FID'], false, $thread_data['CLOSED'], false, $show_sigs, true);

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
echo "      <td align=\"center\">", form_submit("endpoll", gettext("End Poll")), "&nbsp;".form_submit("cancel", gettext("Cancel")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>