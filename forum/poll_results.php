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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'poll.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

if (isset($_GET['tid']) && is_numeric($_GET['tid'])) {

    $tid = $_GET['tid'];

    if (!$t_fid = thread_get_folder($tid, 1)) {
        html_draw_error(gettext("The requested thread could not be found or access was denied."));
    }

} else {

    html_draw_error(gettext("You must specify a poll to view."));
}

if (!$thread_data = thread_get($tid, session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

if (!$folder_data = folder_get($thread_data['FID'])) {
    html_draw_error(gettext("The requested folder could not be found or access was denied."));
}

if (!$poll_data = poll_get($tid)) {
    html_draw_error(gettext("The requested thread could not be found or access was denied."));
}

$show_sigs = (session::get_value('VIEW_SIGS') == 'N') ? false : true;

$highlight_array = array();

$poll_user_count = 0;

$poll_results = poll_get_votes($tid);

$user_poll_votes_array = poll_get_user_votes($tid);

html_draw_top("title={$thread_data['TITLE']}", 'pm_popup_disabled', 'class=window_title', 'poll.js');

echo "<div align=\"center\">\n";
echo "<table width=\"96%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, 1, $thread_data['FID'], $folder_data['TITLE'], $thread_data['TITLE'], $thread_data['INTEREST'], $folder_data['INTEREST'], $thread_data['STICKY'], $thread_data['CLOSED'], $thread_data['ADMIN_LOCK'], ($thread_data['DELETED'] == 'Y'), false, array()), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<table width=\"100%\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td width=\"2%\">&nbsp;</td>\n";
echo "    <td align=\"left\">", poll_display($tid, $thread_data['LENGTH'], 1, $thread_data['FID'], false, $thread_data['CLOSED'], false, $show_sigs, true, $highlight_array), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<br />\n";
echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"poll_results.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_button('close_popup', gettext("Close")), "\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>