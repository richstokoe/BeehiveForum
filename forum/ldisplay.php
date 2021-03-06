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
require_once 'lboot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'beehive.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'light.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// User UID for fetching recent message
$uid = session::get_value('UID');

// Check that required variables are set
// default to display most recent discussion for user
if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    $msg = $_GET['msg'];
    list($tid, $pid) = explode('.', $msg);

} else {

    light_html_draw_top(sprintf("title=%s", gettext("Error")), "robots=noindex,nofollow");
    light_html_display_error_msg(gettext("Invalid Message ID or no Message ID specified."));
    light_html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid, session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")));
    light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
    light_html_draw_bottom();
    exit;
}

if (!$folder_data = folder_get($thread_data['FID'])) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")));
    light_html_display_error_msg(gettext("The requested folder could not be found or access was denied."));
    light_html_draw_bottom();
    exit;
}

if (!$message = messages_get($tid, $pid, 1)) {

    light_html_draw_top(sprintf("title=%s", gettext("Error")));
    light_html_display_error_msg(gettext("That post does not exist in this thread!"));
    light_html_draw_bottom();
    exit;
}

light_html_draw_top("title={$thread_data['TITLE']}");

light_messages_top($msg, $thread_data['TITLE'], $thread_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'));

$first_msg = $message['PID'];
$message['CONTENT'] = message_get_content($tid, $message['PID']);

if ($thread_data['POLL_FLAG'] == 'Y') {

    if ($message['PID'] == 1) {

        light_poll_display($tid, $thread_data['LENGTH'], $thread_data['FID'], false, $thread_data['CLOSED'], false, false);
        $last_pid = $message['PID'];

    } else {

        light_message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], false, $thread_data['CLOSED'], false, true, false, false);
        $last_pid = $message['PID'];
    }

} else {

    light_message_display($tid, $message, $thread_data['LENGTH'], $first_msg, $thread_data['FID'], false, $thread_data['CLOSED'], false, false, false, false);
    $last_pid = $message['PID'];
}

echo "<a href=\"lmessages.php?webtag=$webtag&amp;msg=$msg\">", gettext("Back"), "</a>\n";

light_html_draw_bottom();

?>