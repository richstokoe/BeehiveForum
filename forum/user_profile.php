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

/* $Id: user_profile.php,v 1.78 2004-08-16 22:07:14 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/format.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/profile.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/user_profile.inc.php");
include_once("./include/user_rel.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $uid = $_GET['uid'];
}

if (isset($_GET['psid']) && is_numeric($_GET['psid'])) {
    $psid = $_GET['psid'];
}

if (!isset($uid)) {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}:</h1>";
    echo "<h2>{$lang['nouserspecified']}</h2>";
    html_draw_bottom();
    exit;
}

if (!$profile_sections = profile_sections_get()) {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<h2>{$lang['profilesnotsetup']}</h2>";
    html_draw_bottom();
    exit;
}

if (!$user_profile = user_get_profile($uid)) {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<h2>{$lang['profilesnotsetup']}</h2>";
    html_draw_bottom();
    exit;
}

$title = format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']);

html_draw_top("title=$title", "openprofile.js", "basetarget=_blank");

// user has chosen to modify their relationship

if (isset($_GET['setrel']) && ($uid != bh_session_get_value('UID')) && bh_session_get_value('UID') > 0) {
    $user_profile['RELATIONSHIP'] = ($user_profile['RELATIONSHIP'] & (~(USER_FRIEND | USER_IGNORED)) | $_GET['setrel']);
    user_rel_update(bh_session_get_value('UID'), $uid, $user_profile['RELATIONSHIP']);
}

echo "<div align=\"center\">\n";
echo "  <table width=\"550\" class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table width=\"100%\" class=\"subhead\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "          <tr>\n";
echo "            <td><h2>&nbsp;", format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']);

if (bh_session_get_value('UID') > 0) {

    if ($user_profile['RELATIONSHIP'] & USER_FRIEND) echo "&nbsp;&nbsp;<img src=\"", style_image('friend.png'), "\" height=\"15\" alt=\"{$lang['friend']}\" />";
    if ($user_profile['RELATIONSHIP'] & USER_IGNORED) echo "&nbsp;&nbsp;<img src=\"", style_image('enemy.png'), "\" height=\"15\" alt=\"{$lang['ignoreduser']}\" />";
}

echo "</h2></td>\n";
echo "            <td align=\"right\" class=\"smalltext\">{$lang['lastvisit']}: {$user_profile['LAST_LOGON']}&nbsp;</td>\n";
echo "          </tr>\n";

if (isset($user_profile['AGE'])) {

    echo "          <tr>\n";
    echo "            <td>&nbsp;</td>\n";
    echo "            <td align=\"right\" class=\"smalltext\">";

    if (isset($user_profile['DOB'])) {

        echo "{$lang['birthday']}: {$user_profile['DOB']} ({$lang['aged']} {$user_profile['AGE']})&nbsp;</td>\n";

    }else {

        echo "{$lang['age']}: {$user_profile['AGE']}&nbsp;</td>\n";
    }

    echo "          </tr>\n";
}

echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "            <td align=\"right\" class=\"smalltext\">{$lang['posts']}: {$user_profile['POST_COUNT']}&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";

echo "        <table width=\"100%\" class=\"subhead\" border=\"0\">\n";
echo "          <tr>\n";

for ($i = 0; $i < sizeof($profile_sections); $i++) {

    if ($i == 0) {

        if (!isset($psid)) {
            $psid = $profile_sections[$i]['PSID'];
        }

    } else if (!($i % 4)) { // Start new row every 4 sections
        echo "          </tr>\n";
        echo "          <tr>\n";
    }

    echo "    <td width=\"25%\" align=\"center\">";

    if ($profile_sections[$i]['PSID'] != $psid) {
        echo "<a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid&amp;psid={$profile_sections[$i]['PSID']}\" target=\"_self\">";
        echo _stripslashes($profile_sections[$i]['NAME']), "</a></td>\n";
    } else {
        echo "<b>", _stripslashes($profile_sections[$i]['NAME']), "</b></td>\n";
    }
}

for(;$i % 4; $i++) {
    echo "            <td width=\"25%\">&nbsp;</td>\n";
}

echo "          </tr>\n";
echo "        </table>\n";

echo "        <table width=\"100%\" class=\"posthead\">\n";
echo "          <tr>\n";
echo "            <td width=\"70%\" valign=\"top\">\n";
echo "              <table width=\"100%\">\n";

$user_profile_array = user_get_profile_entries($uid, $psid);

foreach ($user_profile_array as $profile_entry) {

    if (($profile_entry['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_entry['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

        list($field_name, $field_values) = explode(':', $profile_entry['NAME']);

        $field_values = explode(';', $field_values);

        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" width=\"33%\" valign=\"top\">", $field_name, "</td>\n";

        if (isset($profile_entry['ENTRY']) && isset($field_values[$profile_entry['ENTRY']])) {

            echo "                  <td width=\"67%\" class=\"posthead\" valign=\"top\">{$field_values[$profile_entry['ENTRY']]}</td>\n";

        }else {

            echo "                  <td width=\"67%\" class=\"posthead\" valign=\"top\">&nbsp;</td>\n";
        }

        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" width=\"33%\" valign=\"top\">{$profile_entry['NAME']}</td>\n";
        echo "                  <td width=\"67%\" class=\"posthead\" valign=\"top\">", isset($profile_entry['ENTRY']) ? nl2br(make_links(_stripslashes($profile_entry['ENTRY']))) : "", "</td>\n";
        echo "                </tr>\n";
    }
}

echo "              </table>\n";
echo "            </td>\n";
echo "            <td valign=\"top\">\n";
echo "              <table width=\"100%\" class=\"subhead\">\n";
echo "                <tr>\n";

if (isset($user_profile['PIC_URL'])) {
    echo "                  <td align=\"center\"><img src=\"{$user_profile['PIC_URL']}\" width=\"110\" height=\"110\" /></td>\n";
}

echo "                </tr>\n";

if ($uid == bh_session_get_value('UID')) {

    echo "                <tr>\n";
    echo "                  <td><a href=\"javascript:void(0)\" onclick=\"launchAttachProfileWin('$webtag');\" target=\"_self\">{$lang['editmyattachments']}</a></td>\n";
    echo "                </tr>\n";
}

if (bh_session_get_value('UID') != 0) {

    echo "                <tr>\n";
    echo "                  <td><a href=\"email.php?webtag=$webtag&amp;uid=$uid\" target=\"_self\">{$lang['sendemail']}</a></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td><a href=\"index.php?webtag=$webtag&amp;final_uri=", rawurlencode("./pm_write.php?webtag=$webtag&amp;uid=$uid"), "\" target=\"_blank\">{$lang['sendpm']}</a></td>\n";
    echo "                </tr>\n";

    if ($uid != bh_session_get_value('UID')) {

        if ($user_profile['RELATIONSHIP'] & USER_FRIEND) {

            $setrel = 0;
            $text = $lang['removefromfriends'];

        }else {

            $setrel = USER_FRIEND;
            $text = $lang['addtofriends'];
        }

        echo "                <tr>\n";
        echo "                  <td><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid&amp;setrel=$setrel\" target=\"_self\">$text</a></td>\n";
        echo "                </tr>\n";

        if ($user_profile['RELATIONSHIP'] & USER_IGNORED) {

            $setrel = 0;
            $text = $lang['stopignoringuser'];

        }else {

            $setrel = USER_IGNORED;
            $text = $lang['ignorethisuser'];
        }

        echo "                <tr>\n";
        echo "                  <td><a href=\"user_profile.php?webtag=$webtag&amp;uid=$uid&amp;setrel=$setrel\" target=\"_self\">$text</a></td>\n";
        echo "                </tr>\n";
    }
}

echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>