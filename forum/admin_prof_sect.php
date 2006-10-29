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

/* $Id: admin_prof_sect.php,v 1.83 2006-10-29 23:07:22 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Do updates

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['t_psid']) && is_array($_POST['t_psid'])) {

        foreach($_POST['t_psid'] as $psid => $value) {

            if (isset($_POST['t_name'][$psid]) && strlen(trim(_stripslashes($_POST['t_name'][$psid]))) > 0) {
                $t_new_name = trim(_stripslashes($_POST['t_name'][$psid]));
            }else {
                $valid = false;
            }

            if (isset($_POST['t_old_name'][$psid]) && strlen(trim(_stripslashes($_POST['t_old_name'][$psid]))) > 0) {
                $t_old_name = trim(_stripslashes($_POST['t_old_name'][$psid]));
            }else {
                $valid = false;
            }

            if ($valid && ($t_new_name != $t_old_name)) {

                profile_section_update($psid, $t_new_name);

                $log_data = array($t_old_name, $t_new_name);

                admin_add_log_entry(CHANGE_PROFILE_SECT, $log_data);
            }
        }

    }

    if (isset($_POST['t_name_new']) && strlen(trim(_stripslashes($_POST['t_name_new']))) > 0) {

        if (trim(_stripslashes($_POST['t_name_new'])) != $lang['newsection']) {

            $t_name_new = trim(_stripslashes($_POST['t_name_new']));

        }else {

            $valid = false;
        }

    }else {

        $valid = false;
    }

    if ($valid) {

        $new_psid = profile_section_create($t_name_new);
        admin_add_log_entry(ADDED_PROFILE_SECT, $t_name_new);

    }

}

if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

    list($psid) = array_keys($_POST['t_delete']);

    $profile_name = profile_section_get_name($psid);

    profile_section_delete($psid);

    admin_add_log_entry(DELETE_PROFILE_SECT, $profile_name);
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($psid) = array_keys($_POST['move_up']);
    profile_section_move_up($psid);
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($psid) = array_keys($_POST['move_down']);
    profile_section_move_down($psid);
}

// Draw the form
echo "<h1>{$lang['admin']} &raquo; ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " &raquo; {$lang['manageprofilesections']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_sections\" action=\"admin_prof_sect.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['sectionname']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['items']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['deletesection']}</td>\n";
echo "                </tr>\n";

if ($profile_sections = profile_sections_get()) {

    $profile_index = 0;
    
    foreach ($profile_sections as $profile_section) {

        $profile_index++;
        
        echo "                <tr>\n";

        if (sizeof($profile_sections) == 1) {

            echo "                  <td align=\"center\" width=\"40\"><img src=\"", style_image('move_up.png'), "\" width=\"20\" height=\"20\" class=\"move_ctrl_disabled\" /><img src=\"", style_image('move_down.png'), "\" width=\"20\" height=\"20\" class=\"move_ctrl_disabled\" />", "</td>\n";

        }elseif ($profile_index == sizeof($profile_sections)) {

            echo "                  <td align=\"center\" width=\"40\">", form_submit_image('move_up.png', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\" class=\"move_ctrl\""), "<img src=\"", style_image('move_down.png'), "\" width=\"20\" height=\"20\" class=\"move_ctrl_disabled\" />", "</td>\n";

        }elseif ($profile_index > 1) {

            echo "                  <td align=\"center\" width=\"40\">", form_submit_image('move_up.png', "move_up[{$profile_section['PSID']}]", "Move Up", "title=\"Move Up\""), form_submit_image('move_down.png', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\""), "</td>\n";

        }else {

            echo "                  <td align=\"center\" width=\"40\"><img src=\"", style_image('move_up.png'), "\" width=\"20\" height=\"20\" class=\"move_ctrl_disabled\" />", form_submit_image('move_down.png', "move_down[{$profile_section['PSID']}]", "Move Down", "title=\"Move Down\""), "</td>\n";
        }

        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_name[{$profile_section['PSID']}]", $profile_section['NAME'], 40, 64), form_input_hidden("t_old_name[{$profile_section['PSID']}]", $profile_section['NAME']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_button("items", $lang['items'], "onclick=\"document.location.href='admin_prof_items.php?webtag=$webtag&amp;psid={$profile_section['PSID']}'\""), "</td>\n";

        if (!profile_items_get($profile_section['PSID'])) {
            echo "                  <td align=\"left\">", form_submit("t_delete[{$profile_section['PSID']}]", $lang['delete']), "</td>\n";
        }else{
            echo "                  <td align=\"left\">&nbsp;</td>\n";
        }

        echo "                </tr>\n";
    }
}

// Draw a row for a new section to be created
echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['newcaps']}</td>\n";
echo "                  <td align=\"left\">", form_field("t_name_new", $lang['newsection'], 40, 64), "</td>\n";
echo "                  <td align=\"center\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"4\">&nbsp;</td>\n";
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
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>